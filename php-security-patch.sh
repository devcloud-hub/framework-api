#!/bin/sh
# Rebuilds PHP inside an official php:*-fpm/-apache image for the 2026-10-21 critical
# PHP security release (CVE-2026-109618, CVE-2026-109619), without waiting for Docker Hub.
#
# Two modes, set by ENV in the Dockerfile's php-base stage:
#   upgrade  PHP_VERSION, PHP_URL, PHP_ASC_URL, PHP_SHA256 point at a newer release
#            (8.2.35, 8.4.27). The source is checked against the sha256 and the release
#            managers' GPG signature. Skipped if the base image already has that version.
#   patch    PHP_PATCH_URL, PHP_PATCH_SHA256 point at the PHP security team's backport
#            (PHP 7.4 gets no release). It is applied to the source already in the image.
#
# Configure flags are read from the base image (php-config), so the rebuilt PHP matches the
# official build and extensions installed later still load.
# Remove once the official images with the fix are out.
set -eux

current="$(php -r 'echo PHP_VERSION;')"
if [ -z "${PHP_PATCH_URL:-}" ] && [ "$current" = "$PHP_VERSION" ]; then
	echo "PHP $current already installed; nothing to do"
	exit 0
fi
# Keep only the --flags. Newer images also list build env vars here, unquoted and with
# spaces (PHP_UNAME=Linux - Docker); those are exported below instead.
configureFlags=""
for arg in $(php-config --configure-options); do
	arg="${arg#\'}"; arg="${arg%\'}"
	case "$arg" in --*) configureFlags="$configureFlags $arg" ;; esac
done
set -- $configureFlags

# Debian 11 (bullseye, php:7.4 images) is past LTS: deb.debian.org still serves the
# bullseye-security index but its pool files 404. Use archive.debian.org instead.
. /etc/os-release
if [ "$VERSION_CODENAME" = bullseye ]; then
	for f in /etc/apt/sources.list /etc/apt/sources.list.d/*; do
		[ -f "$f" ] && sed -i -E 's#https?://(deb|security)\.debian\.org/debian-security#http://archive.debian.org/debian-security#g; s#https?://deb\.debian\.org/debian#http://archive.debian.org/debian#g' "$f"
	done
	echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99archive
fi

# php:*-apache images build mod_php with --with-apxs2, which needs apxs from apache2-dev
apacheDev=""
case " $configureFlags " in *" --with-apxs2 "*) apacheDev="apache2-dev" ;; esac

savedAptMark="$(apt-mark showmanual)"
apt-get update
apt-get install -y --no-install-recommends \
	$apacheDev \
	gnupg \
	patch \
	libargon2-dev \
	libcurl4-openssl-dev \
	libedit-dev \
	libonig-dev \
	libreadline-dev \
	libsodium-dev \
	libsqlite3-dev \
	libssl-dev \
	libxml2-dev \
	zlib1g-dev

cd /usr/src
if [ -n "${PHP_PATCH_URL:-}" ]; then
	curl -fsSL -o php-security.patch "$PHP_PATCH_URL"
	echo "$PHP_PATCH_SHA256 *php-security.patch" | sha256sum -c -
else
	curl -fsSL -o php.tar.xz "$PHP_URL"
	echo "$PHP_SHA256 *php.tar.xz" | sha256sum -c -
	curl -fsSL -o php.tar.xz.asc "$PHP_ASC_URL"
	export GNUPGHOME="$(mktemp -d)"
	for key in $GPG_KEYS; do
		gpg --batch --keyserver keyserver.ubuntu.com --recv-keys "$key"
	done
	gpg --batch --verify php.tar.xz.asc php.tar.xz
	gpgconf --kill all
	rm -rf "$GNUPGHOME"
fi

export \
	CFLAGS="$PHP_CFLAGS" \
	CPPFLAGS="$PHP_CPPFLAGS" \
	LDFLAGS="$PHP_LDFLAGS" \
	PHP_BUILD_PROVIDER='https://github.com/docker-library/php' \
	PHP_UNAME='Linux - Docker'
docker-php-source extract
cd /usr/src/php
if [ -n "${PHP_PATCH_URL:-}" ]; then
	patch -p1 < /usr/src/php-security.patch
	rm /usr/src/php-security.patch
fi
debMultiarch="$(dpkg-architecture --query DEB_BUILD_MULTIARCH)"
if [ ! -d /usr/include/curl ] && [ ! -e /usr/local/include/curl ]; then
	ln -sT "/usr/include/$debMultiarch/curl" /usr/local/include/curl
fi
./configure "$@"
make -j "$(nproc)"
find -type f -name '*.a' -delete
make install
find /usr/local -type f -perm '/0111' -exec sh -euxc 'strip --strip-all "$@" || :' -- '{}' +
make clean
cp -v php.ini-* "$PHP_INI_DIR/"
cd /
docker-php-source delete

# drop the build deps again, keeping every library the installed binaries link against
apt-mark auto '.*' > /dev/null
[ -z "$savedAptMark" ] || apt-mark manual $savedAptMark
find /usr/local -type f -executable -exec ldd '{}' ';' \
	| awk '/=>/ { so = $(NF-1); if (index(so, "/usr/local/") == 1) { next }; gsub("^/(usr/)?", "", so); printf "*%s\n", so }' \
	| sort -u \
	| xargs -r dpkg-query --search \
	| cut -d: -f1 \
	| sort -u \
	| xargs -r apt-mark manual
apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false
rm -rf /var/lib/apt/lists/*

pecl update-channels
rm -rf /tmp/pear ~/.pearrc

# fail the build unless the expected version is the one actually installed
php --version
php -r 'exit(PHP_VERSION === getenv("PHP_VERSION") ? 0 : 1);'
if command -v php-fpm > /dev/null; then php-fpm --version; fi
