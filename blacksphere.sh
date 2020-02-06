#!/usr/bin/bash

# Prints usage of script
function usage() {
    echo Usage: $1
    exit
}

# Variables
remote_user="sshfs"
url="jmpi.ddns.net"
ssh_path="/var/www/html/sshfs/TopLevelDir"
web_path="/sshfs/TopLevelDir"
local_mount=~/LocalMount


# Mounts or unmounts remote server directory with all other remotes
if [[ $(mount | grep $remote_user@$url:$ssh_path) == "" ]]; then

<<<<<<< HEAD
    # Adds config to SSH to key connection alive
=======
    # Adds config to SSH to keey connection alive
>>>>>>> 38e6797ebdd930852821c04fd1fa9b013e7c2dfc
    if [[ -f ~/.ssh/config ]]; then
        if [[ $(egrep "ServerAliveInterval [0-9]+" ~/.ssh/config) == "" ]]; then
            echo "ServerAliveInterval 60" >> ~/.ssh/config
        fi
    else
        echo "ServerAliveInterval 60" >> ~/.ssh/config
    fi

    mkdir $local_mount 2> /dev/null
    sshfs -o idmap=user $remote_user@$url:$ssh_path $local_mount -p 22
    xdg-open https://$url$web_path
else
    echo -e "You sure you want to unmount? [y] \c"
    read confirm
    if [[ $confirm == "y" ]]; then
        umount $local_mount
    else
        echo "Unrecognised input, just 'y' to confirm"
    fi
fi
