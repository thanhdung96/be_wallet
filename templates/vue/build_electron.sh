#!/bin/bash

# get hash value of the latest commit of current branch
HashValue=$(git log -n 1 --pretty=format:"%H")
# replace hash with actual hash value
sed -i "s/hash/$HashValue/g" package.json
# build electron
yarn electron:build
# revert package.json
sed -i "s/$HashValue/hash/g" package.json
