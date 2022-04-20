#!/bin/bash

# update local repository
git fetch --prune
git checkout develop
git pull

# get all migration files in last commit
# requires rebase and squashed commits
touch migrations
File="migrationfiles"
git diff --name-only HEAD HEAD~1 | grep migrations | sed 's/migrations\///' | sed 's/.php//' > $File
Lines=$(cat $File)

# for each migration file in migrationfiles
# do migration with dontrine
for Line in $Lines
do
	php bin/console doctrine:migrations:execute --up DoctrineMigrations\\\\${Line} --no-interaction
done

# cleanup
rm $File
