#!/usr/bin/bash

function usage() {
    echo Usage: $1
    exit
}

remote_user="sshfs"
url="jmpi.ddns.net"
remote_path="TopLevelDir"
local_mount=~/LocalMount

echo -e "[M]ount or [U]nmount? \c"
read mnt_choice
if [[ ${mnt_choice^} == "M" ]]; then
    # read -p "Remote User: " remote_user
    # read -p "URL: "         url
    # read -p "Remote Path: " remote_path
    mkdir $local_mount 2> /dev/null
    sshfs -o idmap=user $remote_user@$url:$remote_path $local_mount
elif [[ ${mnt_choice^} == "U" ]]; then
    umount $local_mount
else
    usage "M to mount, U to unmount"
fi
