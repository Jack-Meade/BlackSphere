#!/usr/bin/bash

function usage() {
    echo Usage: $1
    exit
}

remote_user="sshfs"
url="jmpi.ddns.net"
remote_path="TopLevelDir"
local_mount=~/LocalMount

if [[ $(mount | grep $remote_user@$url:$remote_path) == "" ]]; then
    mkdir $local_mount 2> /dev/null
    sshfs -o idmap=user $remote_user@$url:$remote_path $local_mount -p 22
else
    echo -e "You sure you want to unmount? [y] \c"
    read confirm
    if [[ $confirm == "y" ]]; then
        umount $local_mount
    else
        echo "Unrecognised input, just 'y' to confirm"
    fi
fi
