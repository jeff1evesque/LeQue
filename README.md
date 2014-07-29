Auditory Analyzer
=====================

The intention of this *web-application* is to allow the visitor to provide auditory commands, which get executed on the server.  The languages used for this project includes:

- PhP
- Python
- Bash-Script
- JavaScript
- Sass (Ruby)

**Note:** Since this project is open to the public, feel free to contribute, or email jeff1evesque@yahoo.com regarding any questions.

##Auditory Analyzer, written in Python & PhP

###Definition:

Speech recognition (SR) is the translation of spoken words into text.

- http://en.wikipedia.org/wiki/Speech_recognition

###Overview:

This project utilizes [Flash](https://getadobe.com/flashplayer/) within the web-browser in order to access the users microphone.  When a recording is saved, it is reconfigured to a `16 bit, 16 kHz, mono` if it has a different format.  This reconfigured *wav* file, is then converted to text using [PocketSphinx](http://cmusphinx.sourceforge.net/wiki/tutorialpocketsphinx), which allows our Python scripts to parse the converted text into executable commands.  This *Bash Automation* occurs automatically, and triggered when an audio file is saved either through the web-application, or by manually saving a *wav* file into the `recording/` subdirectory.

##Requirement

###Installation

####Ubuntu Server 14.04

Format two USB flash drives as `MS-DOS (FAT)`.  Using [UNetbootin](http://unetbootin.sourceforge.net/), make both USB drives bootable with the following ISO images:

- [Ubuntu Server 14.04](http://www.ubuntu.com/download/server/thank-you?country=US&version=14.04.1&architecture=amd64)
- [boot-repair-disk](https://help.ubuntu.com/community/Boot-Repair)

Next, ensure the machine being used has been partitioned enough *unallocated space* for the [*Ubuntu Server 14.04*](https://wiki.ubuntu.com/TrustyTahr/ReleaseNotes) operating system.

**Note:** Current development is on a windows machine, hence formatting the latter USB drives to `MS-DOS (FAT)`.

**Note:** The *unallocated space* on the hard-disk does not need to be formatted before installation.

During [installation](http://ubuntuserverguide.com/2014/04/how-to-install-ubuntu-server-14-04-trusty-tahr.html) (boot-up with the Ubuntu ISO USB), select `Install`.  At the `[!] Partition disks` section, select `Manual`, and carefully partition *only* the *unallocated space* on the hard-disk.  This is important if the overall machine is a multiboot.  The partitioning process will create two partitions, `Ext4`, and `SWAP` from the *unallocated space*.  Upon reaching the `[!] Software Selection` section, select `Basic Ubuntu Server`, and `Ubuntu desktop`. Also, select `yes` when asked `Install the GRUB boot loader to the master boot record?`

**Note:** If Ubuntu Server 14.04 was not bootable on the hard disk after installation, use the boot-repair-disk bootable USB, and *reinstall Grub*.

####Linux Packages

The following packages need to be installed through terminal in Ubuntu:

```
# General Packages:
sudo apt-get update
sudo apt-get install inotify-tools
sudo apt-get install ffmpeg
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

###Configuration:

####LAMP server

Recall earlier that we installed our LAMP server with phpMyAdmin.  We need to modify `apache2.conf` file in order to access phpMyAdmin:

```
sudo pico /etc/apache2/apache2.conf
```

by adding the following to the end of the file:

```
# Allow access to phpMyAdmin (edited by JL)
Include /etc/phpmyadmin/apache.conf
```

Then, restart apache:

```
sudo service apache2 restart
```

####GIT

Since we installed GIT earlier, we have to remember to configure our GIT user.  Only change the values within the double quotes (remove the quotes for the email):

```
git config --global user.email "YOUR-EMAIL@DOMAIN.COM"
git config --global user.name "YOUR-NAME"
```

Fork this project in your GitHub account, then clone your repository of this project within Ubuntu VM:

```
sudo git clone https://[YOUR-USERNAME]@github.com/[YOUR-USERNAME]/audio-analyzer.git [PROJECT-NAME]
```

Then, add the *Remote Upstream*, this way we can pull any merged pull-requests:

```
cd /var/www/audio-analyzer
git remote add upstream https://github.com/[YOUR-USERNAME]/[REPOSITORY-NAME].git
```

#####GIT Submodule

We need to initialize our git *submodules*:

```
sudo git submodule init
sudo git submodule update
```

**Note:** We have to use the *sudo* prefix, since we haven't taken care of file permissions yet.

The above two commands will update submodules.  If they are already initialized, then the latter command will suffice. Then, we need to pull the code-base into the initialized submodule directory:

```
cd /var/www/audio-analyzer
git checkout -b NEW_BRANCH master
cd [YOUR_SUBMODULE]
git checkout master
git pull
cd ..
git status
```

Now, commit and merge the submodule changes.

####File Permission

Change the file permission for the entire project by issuing the command:

```
cd /var/www
sudo chown -R jeffrey:sudo audio-analyzer
```

**Note:** change 'jeffrey' to the user account YOU use.

Then, with the exception of the `.gitignore` file, ensure `/var/www/audio-analyzer/audio` is an empty directory, so that we can change it's ownership:

```
cd /var/www/audio-analyzer
sudo chown www-data:sudo audio
```

####Bootable bash script

`/etc/rc.local` allows us to run bash-scripts during apache2 boot.  Since `bash_loader` loads all our required bash-scripts, we will run this script.  So, add the following lines:

```
# run 'bash_loader' at start-up for '/var/www/audio-analyzer' application (edited by JL)
cd /var/www/audio-analyzer/bash && ./bash_loader > /dev/null 2>&1 &
```

To ensure the above modification is working:

```
sudo /etc/init.d/rc.local start
```

####Local Ignore Rules

We do not want to commit files, or directories within our git *submodules*.  For this reason, we created a bash-script that will apply git *local ignore rules*, which will ignore anything contained within the specified directories.

To begin ignoring specific directories (submodules), simply open the following file:

```
/var/www/audio-analyzer/bash/git/local_ignore_rules
```

and, add respective directories to the `haystack` array.

**Note:** each repository (or submodule) has it's own `.git/info/exclude` file.

####Submodule Installation

We need to install our *Sphinx* related submodules:

```
cd /var/www/audio-analyzer/pocketsphinx/sphinxbase
./autogen.sh
sudo make install

cd ../pocketsphinx
./autogen.sh
sudo make install

cd ../sphinxtrain
./autogen.sh
sudo make install
```

####Automation

#####Grunt

We will automate [Grunt's](https://gruntjs.com) task management, which will encompass tools such as [Sass](https://github.com/gruntjs/grunt-contrib-sass), [Uglify](https://github.com/gruntjs/grunt-contrib-uglify), [Imagemin](https://github.com/gruntjs/grunt-contrib-imagemin), and [Modernizr](https://github.com/Modernizr/grunt-modernizr).  It requires setup only once within each web-appliation utilizing its tools.

More information regarding setting-up [Grunt](https://gruntjs.com), can be found within the [README.md](https://github.com/jeff1evesque/grunt/blob/master/README.md) file from the [Grunt](http://github.com/jeff1evesque/grunt) repository.

## Testing / Execution

###Test Scripts:

Before translating audio files, it is possible to perform a few tests to gauge the [PocketSphinx](http://cmusphinx.sourceforge.net/wiki/tutorialpocketsphinx) translation engine.  For example, the following script tests the command `pocketsphinx_continuous` against `sample.wav` file from the *pocketsphinx* submodule:

```
cd /var/www/audio-analyzer/bash/tests
./test_pocketsphinx_continuous
```

**Note:** Since the above script uses `sample.wav`, be sure to initialize all submodules (as outlined in the GIT subsection).

The execution of the above the script will produce a text-file containing the text translation of `sample.wav`:

```
cd /var/www/audio-analyzer/audio/recording_text/
pico test_sample.txt
```

A corresponding log-file is also created:

```
cd /var/www/audio-analyzer/bash/logs/
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
/var/www/audio-analyzer/bash/logs/
pico log_bash_loader
```

If `test_pocketsphinx_continuous` was executed:

```
cd /var/www/audio-analyzer/bash/tests/
./test_pocketsphinx_continuous
```

then, the *translation time* information can be found within `log_test_pocketsphinx_continuous`:

```
/var/www/audio-analyzer/bash/logs/
pico log_text_pocketsphinx_continuous
```
