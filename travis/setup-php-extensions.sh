
#!/bin/bash
#
# This file is part of the phpBB Forum Software package.
#
# @copyright (c) phpBB Limited <https://www.phpbb.com>
# @license GNU General Public License, version 2 (GPL-2.0)
#
# For full copyright and license information, please see
# the docs/CREDITS.txt file.
#
set -e
set -x

function find_php_ini
{
	echo $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
}

php_ini_file=$(find_php_ini)

-# disable broken opcache on PHP 5.5.7 and 5.5.8
-if [ `php -r "echo (int) version_compare(PHP_VERSION, '5.5.9', '<');"` == "1" ]
-then
-	sed -i '/opcache.so/d' "$php_ini_file"
-fi
