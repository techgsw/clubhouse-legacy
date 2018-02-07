#!/bin/bash

# Constants
DATE=$(date +"%Y-%m-%d")

# Functions
usage()
{
    echo "usage: backup [-e env] [-p path] [-n name] [-h help]"
    echo ""
    echo "  env    (dev | prod) environment. Determines default project root."
    echo "  path   Absolute path to project root. Overrides env default."
    echo "  name   Name of backup. If set, filename will be Y-M-D-{name}.sql.gz. If not set, Y-M-D.sql.gz."
    echo ""
    echo "backup will create a backup in the database/backups/ directory of the project. It requires a databases/auth.cnf file with credentials, which should be structured as:"
    echo ""
    echo "  [client]"
    echo "  user={username}"
    echo "  password={password}"
    echo ""
    echo "Setting the strictest possible permissions on this file provides an extra security layer, so do that ya dummy!"
    echo ""
    echo "backup -h to see instructions again."
}

while [ "$1" != "" ]; do
    case $1 in
        -e | --env )  shift
                      env=$1
                      ;;
        -n | --name ) shift
                      name=$1
                      ;;
        -p | --path ) shift
                      path=$1
                      ;;
        -h | --help ) usage
                      exit
                      ;;
        * )           usage
                      exit 1
    esac
    shift
done

# determine path to project root directory
# should include database/auth.cnf and database/backups/ directory
if [ "$path" != "" ]; then
    # use the given path
    dir="$path/database"
elif [ "$env" == "prod" ]; then
    # use the default prod path
    dir="/srv/www/sportsbusinesssolutions/database"
elif [ "$env" == "dev" ]; then
    # use the default dev path
    dir="/home/vagrant/Code/sportsbusinesssolutions/database"
else
    # use current directory if no options are given
    dir=$(pwd)
fi
cnf="${dir}/auth.cnf"

# determine filename
filename="${DATE}"
if [ "$name" != "" ]; then
    filename="${filename}-${name}"
fi

mysqldump --defaults-extra-file=${cnf} --single-transaction --lock-tables=false sbs | gzip > ${dir}/backups/${filename}.sql.gz

echo "✓ Created database backup: ${filename}.sql.gz"
