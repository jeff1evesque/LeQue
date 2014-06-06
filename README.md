Auditory Analyzer
=====================

I am curious with the idea of having a web application that may be partly driven by voice-commands.  I will be using various languages - such as: Python, PhP, and basic shell scripting.

##Auditory Analyzer, written in Python & PhP

###Definition:

Speech recognition (SR) is the translation of spoken words into text.

- http://en.wikipedia.org/wiki/Speech_recognition

###Overview:

This project will leverage Python's scripting ability - primarily to house the logic component of the sound analyzer.  The Python component will begin by activating the microphone on the machine, and do the necessary algorithms to convert defined speech components into commands.  The second component, the PHP portion will provide an interactive web application to house the former logic component.

##Requirement

Since we running OSX 10.6.8 for the host Operating system, we installed VirtualBox 4.1.10 r76795 using Ubuntu 10.04 for the Guest Operating System. 

###Installation:

The following packages need to be installed through terminal in Ubuntu:

```
sudo apt-get update
sudo apt-get install inotify-tools
sudo apt-get install ffmpeg
sudo apt-get install firefox
sudo apt-get install git-core
sudo apt-get install lamp-server^ phpmyadmin
sudo apt-get install python-pocketsphinx
sudo apt-get install pocketsphinx-hmm-wsj1
sudo apt-get install pocketsphinx-lm-wsj
sudo apt-get install python-pyscss
```

The following need to be installed without terminal in Ubuntu:

1. Flash Player 11.1.102.62 (Released 02/15/2012)
  - http://helpx.adobe.com/flash-player/kb/archived-flash-player-versions.html

###Configuration:

####Bootable bash script

`/etc/rc.local` allows us to run bash-scripts during apache2 boot.  Since `bash_loader` loads all our required bash-scripts, we will run this script.  So, add the following lines -

```
# run 'bash_loader' at start-up for '/var/www/audio-analyzer' application (edited by JL)
cd /var/www/audio-analyzer/bash && ./bash_loader > /dev/null 2>&1 &
```

To ensure the above modification is working -

```
sudo /etc/init.d/rc.local start
```

####LAMP server

Recall earlier that we installed our LAMP server.  We need to modify `apache2.conf` file in order to access phpMyAdmin:

```
sudo pico /etc/apache2/apache2.conf
```

and add the following to the end of the file:

```
Include /etc/phpmyadmin/apache.conf
```

Then, restart apache:

```
sudo service apache2 restart
```

####GIT

Since we installed GIT earlier, we have to remember to configure our GIT user.  Only change the values within the double quotes (remove the quores for the email) -

```
git config --global user.email "YOUR-EMAIL@DOMAIN.COM"
git config --global user.name "YOUR-NAME"
```

Fork this project in your GitHub account, then clone your repository of this project within Ubuntu VM -

```
sudo git clone https://jeff1evesque@github.com/[YOUR-USERNAME]/audio-analyzer.git [PROJECT-NAME]
```

We need to initialize any submodules *audio-analyzer* is using.  Currently, we are only using one, *pyScss* -

```
git submodule init
git submodule update
```

**Note:** the above two commands will update submodules.  If they are already initialized, then the latter command will suffice. 
