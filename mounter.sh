#!/bin/bash

echo "\$1: $1"
echo "\$2: $2"
echo "\$3: $3"
echo "\$4: $4"
echo "\$5: $5"
echo sshfs123 | su sshfs -c "sshfs -o idmap=user,password_stdin,allow_other $1@$2:$3 TopLevelDir/$4 -p 22 <<< $5 2>&1"
