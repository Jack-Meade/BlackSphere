# About
## What is BlackSphere?
Simple way to share files among selected group of people over an ad-hoc network and is configured
automatically when installed on a Linux system. It is SSHFS-based, meaning storage capacity is only limited by
the host machine’s storage on the network.

It primarily uses a web GUI for users to interact with the system.

It will use a central tracker which keeps track of “neighbourhoods” of peers. This central tracker acts as a start
off point for neighbourhoods to create their smaller private networks made up of peers. It will also act as a
pointer to a neighbourhood, so others can find and join a neighbourhood, if permitted.

It will have an option to create/locate local trackers over LAN, by choice or if no Internet connection.

Users connect to the tracker and can see all the directories shared by others in TopLevelDir. From here, they
can navigate the directories like a normal file explorer. Figures 1 & 2 illustrates this idea, where the client
accesses TopLevelDir via the web GUI.

## How to Use BlackSphere
You can access the [test version](https://jmpi.ddns.net/bs/TopLevelDir/) of BlackSphere right now, but be warned it is **under development** and is subject to **change without any notice**.
The test key is `asd`.

# Features
## Virtual Filesystem over Multiple Hosts over Different Networks
Can be used to create a cloud sharing platform either over the Internet or within a local network. Users can
also user a script to create a LocalMount where they can access that network via their native file explorer on
their host machine.

## Able to Add Multiple Directories per Host
Users are not limited to the number of directories they can share.

## Web UI/Frontend for Users
Intuitive and easy-to-use frontend for users to interact with the network they create.

## Upload File(s)
Users can upload files via a drag/drop box to whatever directory they are currently in. It uses a JavaScript
library (dropzone.js) for the drag/drop capabilities. Actual uploading of a file(s) is done by using a NodeJS
module to upload the file(s) to an upload folder. We then move the uploaded files to the directory the user is
currently in by parsing the requested URI and mapping it on to the directory structure.

## Download File(s)
Users can download files from the directory they are currently viewing via checkboxes (seen in Figures 2 & 4).
This is done through PHP, where the files selected are first zipped and then sent to the user if multiple ones
are selected. If they select a single, there are just sent that file. Both methods are implemented by created the
required headers in PHP and are then sent to the user’s browser.

## Make Directory
Users can create directories in the current directory they are viewing to help organise uploads. This is done y
collecting the directory name via PHP and AJAX. The PHP script creates a directory via an exec command, and
AJAX calls that script so the user doesn’t have to leave the currently page they are on.

## Mount a User Directory
Users enter in SSH info, IP/URL of host machine, path to that directory, and the name they want the
mountpoint on BlackSphere to be called, and BlackSphere will remote mount that directory for them. This info
is first passed to a PHP script which then calls a shell script. The shell script then uses a sshfs command with
the details passed in and mounts the remote directory in TopLevelDir.

## Search Files on Neighbourhood
A file sharing application isn’t complete without a search bar as it allows users to quickly find files they are
looking for. The text they enter is used in a PHP script which uses an exec command with the bash find
command to find any filename which has the text in it. The search page then calls a HTML generator PHP
script, which it uses to list the files found.

## Automatically Refresh Changes from Tracker
A feature which was being implemented near the end. It was causing some bugs so we reverted to a version
where users can click a button and it will automatically update the file listings without the need to refresh the
whole page. We hope to rectify these bugs in a future iteration.

## Restricted Access unless User has Key
BlackSphere uses PHP sessions and CSRF validation to protect networks from unauthorised access. Keys are
generated when a network is created and can be entered in a login page as shown in Figure 7.

## Show Hidden Files
Showing hidden files can cause a bit of clutter, so by default BlackSphere hides these by default. We give users
the option to view these files if they so wish. This refreshes the page as a query string is sent indicating to the
HTML generator PHP script mentioned earlier to show hidden files.

## Logout of current neighbourhood
Allows users to leave a neighbourhood if they wish to join another.

## Certain users act as trackers for neighbourhoods
A user (usually the first) will be delegated the task of acting as the tracker, so other who join the network may
use the web GUI BlackSphere provides.


# Dependencies and Prerequisites (***Install Currently Not Available***)
## SSHFS
Debian/Ubuntu: `sudo apt install -y sshfs`

Arch: `sudo pacman -S sshfs`

## PHP
Debian/Ubuntu: `sudo apt install -y php`

Arch: `sudo pacman -S php`

## NGINX
Debian/Ubuntu: `sudo apt install -y nginx`

Arch: `sudo pacman -S nginx`


# Authors
* Bradley Aherne
* Daniels Bindemans
* Conor McDonald
* Jack Meade
* Cian Twomey
* Alexander Smith

# License
GNU Affero General Public License v3.0
