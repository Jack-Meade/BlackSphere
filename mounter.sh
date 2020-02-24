#!/bin/bash

echo "\$1 (IP): $1"
echo "\$2 (URL): $2"
echo "\$3 (PATH): $3"
echo "\$4 (MOUNT): $4"
echo "\$5 (PASSWD): $5"
echo sshfs123 | su sshfs -c "sshfs -o idmap=user,password_stdin,allow_other $1@$2:$3 TopLevelDir/$4 -p 22 <<< $5 2>&1"
