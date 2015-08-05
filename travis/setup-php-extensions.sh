
#!/bin/bash
set -e
set -x

function find_php_ini
{
#	echo $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
echo $(php --ini | grep "Loaded Configuration")
}

php_ini_file=$(find_php_ini)
sed -i '/opcache.so/d' "$php_ini_file"
sed -i '/xdebug.so/d' "$php_ini_file"
