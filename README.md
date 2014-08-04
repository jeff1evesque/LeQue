LeQue
=====================

The intention of this *web-application* is to allow the visitor to provide auditory commands, which get executed on the server.  The languages used for this project includes:

- PhP
- Python
- Bash-Script
- JavaScript
- Sass (Ruby)

**Note:** Since this project is open to the public, feel free to contribute, or email jeff1evesque@yahoo.com regarding any questions.

###Definition

Speech recognition (SR) is the translation of spoken words into text.

- http://en.wikipedia.org/wiki/Speech_recognition

###Overview

This project utilizes [Flash](https://getadobe.com/flashplayer/) within the web-browser in order to access the users microphone.  When a recording is saved, it is reconfigured to a `16 bit, 16 kHz, mono` if it has a different format.  This reconfigured *wav* file, is then converted to text using [PocketSphinx](http://cmusphinx.sourceforge.net/wiki/tutorialpocketsphinx), which allows our Python scripts to parse the converted text into executable commands.  This *Bash Automation* occurs automatically, and triggered when an audio file is saved either through the web-application, or by manually saving a *wav* file into the `recording/` subdirectory.

##Installation

###Ubuntu Server 14.04

Format two USB flash drives as `MS-DOS (FAT)`.  Using [UNetbootin](http://unetbootin.sourceforge.net/), make both USB drives bootable with the following ISO images:

- [Ubuntu Server 14.04](http://www.ubuntu.com/download/server/thank-you?country=US&version=14.04.1&architecture=amd64)
- [boot-repair-disk](https://help.ubuntu.com/community/Boot-Repair)

Next, ensure the machine being used has been partitioned enough *unallocated space* for the [*Ubuntu Server 14.04*](https://wiki.ubuntu.com/TrustyTahr/ReleaseNotes) operating system.

**Note:** Current development is on a windows machine, hence formatting the latter USB drives to `MS-DOS (FAT)`.

**Note:** The *unallocated space* on the hard-disk does not need to be formatted before installation.

During [installation](http://ubuntuserverguide.com/2014/04/how-to-install-ubuntu-server-14-04-trusty-tahr.html) (boot-up with the Ubuntu USB), select `Install`.  At the `[!] Partition disks` section, select `Manual`, and carefully partition *only* the *unallocated space* on the hard-disk.  This is important if the overall machine is a multiboot.  The partitioning process will create two partitions, `Ext4`, and `SWAP` from the *unallocated space*.  Upon reaching the `[!] Software Selection` section, select `Basic Ubuntu Server`, and `Ubuntu desktop`. Also, select `yes` when asked `Install the GRUB boot loader to the master boot record?`

**Note:** If Ubuntu Server 14.04 was not bootable on the hard disk after installation, use the boot-repair-disk bootable USB, and *reinstall Grub*.

###Linux Packages

The following packages need to be installed through terminal in Ubuntu:

```
# General Packages:
sudo apt-get update
sudo apt-get install inotify-tools
sudo apt-get install libav-tools
sudo apt-get install firefox
sudo apt-get install flashplugin-installer
sudo apt-get install git-core
sudo apt-get install lamp-server^ phpmyadmin

# Sphinx Packages: allow `./autogen.sh`, `sudo make install` for submodules
sudo apt-get install autoconf
sudo apt-get install libtool
sudo apt-get install bison
sudo apt-get install swig
sudo apt-get install python-dev
```

##Configuration

###GIT

Since we installed GIT earlier, we have to remember to configure our GIT user.  Only change the values within the double quotes (remove the quotes for the email):

```
git config --global user.email "YOUR-EMAIL@DOMAIN.COM"
git config --global user.name "YOUR-NAME"
```

Fork this project in your GitHub account, then clone your repository:

```
cd /var/www/html/
sudo git clone https://[YOUR-USERNAME]@github.com/[YOUR-USERNAME]/leque.git [PROJECT-NAME]
```

Then, add the *Remote Upstream*, this way we can pull any merged pull-requests:

```
cd /var/www/html/leque/
git remote add upstream https://github.com/[YOUR-USERNAME]/[REPOSITORY-NAME].git
```

####GIT Submodule

We need to initialize our git *submodules*:

```
sudo git submodule init
sudo git submodule update
```

**Note:** We have to use the *sudo* prefix, since we haven't taken care of file permissions yet.

The above two commands will update submodules.  If they are already initialized, then the latter command will suffice. Then, we need to pull the code-base into the initialized submodule directory:

```
cd /var/www/html/leque/
git checkout -b NEW_BRANCH master
cd [YOUR_SUBMODULE]/
git checkout master
git pull
cd ../
git status
```

Now, commit and merge the submodule changes.

###File Permission

Change the file permission for the entire project by issuing the command:

```
cd /var/www/html/
sudo chown -R jeffrey:sudo leque
```

**Note:** change 'jeffrey' to the user account YOU use.

Then, with the exception of the `.gitignore` file, ensure `/var/www/html/leque/audio` is an empty directory, so that we can change it's ownership:

```
cd /var/www/html/leque/
sudo chown www-data:sudo audio
```

###Submodule Installation

####Sphinx

```
# Install Sphinx Engine(s)
cd /var/www/html/leque/pocketsphinx/sphinxbase/
./autogen.sh
sudo make install

cd ../pocketsphinx/
./autogen.sh
sudo make install

cd ../sphinxtrain/
./autogen.sh
sudo make install

# Extract Sphinx Acoustic, and Language Models
cd ../../
wget http://sourceforge.net/projects/cmusphinx/files/Acoustic%20and%20Language%20Models/US%20English%20Generic%20Acoustic%20Model/en-us.tar.gz/download -O en-us.tar.gz
sudo tar -zxvf en-us.tar.gz -C /usr/local/share/pocketsphinx/model/hmm/
sudo rm en-us.tar.gz

wget http://sourceforge.net/projects/cmusphinx/files/Acoustic%20and%20Language%20Models/US%20English%20Generic%20Language%20Model/cmusphinx-5.0-en-us.lm.dmp/download -O cmusphinx-5.0-en-us.lm.dmp
sudo mv cmusphinx-5.0-en-us.lm.dmp /usr/local/share/pocketsphinx/model/lm/
```

More information regarding setting-up [PocketSphinx](http://cmusphinx.sourceforge.net/wiki/tutorialpocketsphinx), can be found within the [README.md](https://github.com/jeff1evesque/pocketsphinx/blob/master/README.md) file from the [jeff1evesque/pocketsphinx](https://github.com/jeff1evesque/pocketsphinx/) repository.

####Autobahn

In order to allow browsers to stream audio to the server, a websocket server is needed.  This project uses [Autobahn](http://http://autobahn.ws/), an open source project that provides *WebSocket*, and *Web Application Messaging Protocols* (WAMP) protocol to achieve audio streaming.

More information regarding setting-up [Autobahn](http://autobahn.ws/), and the requirements of streaming audio from the browser to the server can be found within the [README.md](https://github.com/jeff1evesque/whisper/blob/master/README.md) file from the [whisper](https://github.com/jeff1evesque/whisper) repository.

###Automation

###Grunt

We will automate [Grunt's](https://gruntjs.com) task management, which will encompass tools such as [Sass](https://github.com/gruntjs/grunt-contrib-sass), [Uglify](https://github.com/gruntjs/grunt-contrib-uglify), [Imagemin](https://github.com/gruntjs/grunt-contrib-imagemin), and [Modernizr](https://github.com/Modernizr/grunt-modernizr).  It requires setup only once within each web-application utilizing its tools.

More information regarding setting-up [Grunt](https://gruntjs.com), can be found within the [README.md](https://github.com/jeff1evesque/grunt/blob/master/README.md) file from the [Grunt](http://github.com/jeff1evesque/grunt) repository.

####Bash Scripts

Configuring `/etc/rc.local` allows bash-scripts to be run during [apache2](https://help.ubuntu.com/10.04/serverguide/httpd.html) boot.  Since `bash_loader` loads all the required bash-scripts, all required scripts can be automated by adding the following to `/etc/rc.local`:

```
...
# run 'bash_loader' at start-up for '/var/www/html/leque/' application (edited by JL)
cd /var/www/html/leque/bash/ && ./bash_loader > /dev/null 2>&1 &

exit 0
```

The above configuration may require starting [rc.local](http://www.linux.com/news/enterprise/systems-management/8116-an-introduction-to-services-runlevels-and-rcd-scripts):

```
sudo /etc/init.d/rc.local start
```

###Boot Sequence

This application utilizes [GRUB2](http://wiki.gentoo.org/wiki/GRUB2), a bootloader program, which allows the selection of partition (on the hard disk) to boot from.  Modifying the *grub configuration file* allows the boot sequence to change.  This is done by modifying the order of files contained within `/etc/grub.d`:

```
$ cd /etc/grub.d/
$ ls
00_header        10_linux      20_memtest86+  30_uefi-firmware  41_custom
05_debian_theme  20_linux_xen  30_os-prober   40_custom         README
```

Operating systems associated with lower prefixes will be higher in the boot selection sequence.  In the case where two partitions exist - Windows 7, and Ubuntu, `30_os-prober` will be associated to the Windows 7 partition.  Since, *linux* is prefixed with a lower number, the boot sequence at start-up will list Ubuntu higher in the list, and perhaps default to it during start-up.  One way to change this sequence, is to rename `30_os-prober` as follows:

```
$ cd /etc/grub.d/
$ sudo mv 30_os-prober 09_os-prober
$ ls
00_header        09_os-prober  20_linux_xen   30_uefi-firmware  41_custom
05_debian_theme  10_linux      20_memtest86+  40_custom         README
$ sudo update-grub
```

The last command above, generates the *grub configuration file*.  When the hard-disk is started, we may see the following on the monitor:

```
GNU GRUB version 2.02^beta2-9ubuntu1

Windows 7 (loader) (on /dev/sda1)
Windows 7 (loader) (on /dev/sda2)
Ubuntu
Advanced options for Ubuntu
Memory test (memtest86+)
Memory test (memtest86+, serial console 115200)

Use the [up arrow] and [down arrow] keys to select which entry is highlighted.
Press enter to boot the selected OS.  `e' to edit the commands
before booting or `c' for a command-line.
```

**Note:** Without the above modifications, the *Ubuntu* option would preceed both *Windows 7* options (both point to the same partition).

###Domain Name

Webservers need to define their own server name.  Since this project utilizes [Apache2](http://httpd.apache.org/docs/2.0/) as one of its webservers, the `/etc/apache2.conf` file should include the following lines:

```
...
# Global configuration (edited by JL)
ServerName localhost
...
```

Providing server identification is useful for various cases (i.e. self-referential redirects), and eliminates repetitive messages when *starting*, and *restarting* the server:

```
$ sudo /etc/init.d/apache2 restart
 * Restarting web server apache2
[Wed Jul 30 08:48:12.303006 2050] [alias:warn] [pid 5457] AH00671: The Alias directive in /etc/phpmyadmin/apache.conf at line 3 will probably never match because it overlaps an earlier Alias.
```

**Note:** It is important to remember that `apache2.conf` will need to be adjusted when the server has a *[true identity](http://wiki.apache.org/httpd/CouldNotDetermineServerName)* (replacing the defined *localhost*).

##Testing / Execution

###Test Scripts

Before translating audio files, it is possible to perform a few tests to gauge the [PocketSphinx](http://cmusphinx.sourceforge.net/wiki/tutorialpocketsphinx) translation engine.  For example, the following script tests the command `pocketsphinx_continuous` against `sample.wav` file from the *pocketsphinx* submodule:

```
cd /var/www/html/leque/bash/tests/
./test_pocketsphinx_continuous
```

**Note:** Since the above script uses `sample.wav`, be sure to initialize all submodules (as outlined in the GIT subsection).

The execution of the above the script will produce a text-file containing the text translation of `sample.wav`:

```
cd /var/www/html/leque/audio/recording_text/
pico test_sample.txt
```

A corresponding log-file is also created:

```
cd /var/www/html/leque/bash/logs/
pico log_test_pocketsphinx_continuous
```

###Translation Time

The [PocketSphinx](http://cmusphinx.sourceforge.net/wiki/tutorialpocketsphinx) translation engine ideally should have a *translation time* **(TR)** equal to three times the *recording time* **(RT)**:

```
TR = 3 x RT
```

The *translation time* (TR) can be verified by checking the output from the command `pocketsphinx_continuous`.  This command will output many lines.  However, the ones of particular relevance have a very specific form.

####CPU Time

The *CPU Time* is the actual *execution time* for the `pocketsphinx_continuous` command.  Therefore, the sum of all such lines will produce the overall CPU Time for the `pocketsphinx_continuous` command:

```
ngram_search_fwdtree.c(xxx): TOTAL fwdxxxx xx.xx CPU x.xxx xRTINFO:
``` 

####System Time

The *Wall Time* is the actual *system time* for the `pocketsphinx_continuous` command.  A system can pause processes for various operations, including those used in relation to `pocketsphinx_continuous`.  Therefore, possibly a better measure of the overall translation time.  The sum of all such lines will produce the overall *System Time* for the `pocketsphinx_continuous` command:

```
ngram_search_fwdtree.c(xxx): TOTAL fwdtxxxx xx.xx wall x.xxx
```

####Automation Time

If *bash automation* is being implemented, information pertaining to *Translation Time* can be acquired from `log_bash_loader`:

```
/var/www/html/leque/bash/logs/
pico log_bash_loader
```

If `test_pocketsphinx_continuous` was executed:

```
cd /var/www/html/leque/bash/tests/
./test_pocketsphinx_continuous
```

then, the *translation time* information can be found within `log_test_pocketsphinx_continuous`:

```
/var/www/html/leque/bash/logs/
pico log_text_pocketsphinx_continuous
```
