
#!/bin/bash
set -e
set -x

function find_php_ini
{
	echo $(php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||")
}

php_ini_file=$(find_php_ini)
echo $php_ini_file
// -	sed -i '/opcache.so/d' "$php_ini_file"
