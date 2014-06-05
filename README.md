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
sudo apt-get install inotify-tools
```

###Configuration:

We need to open `/etc/rc.local`, and add the following lines -

```
# run 'bash_loader' at start-up for '/var/www/audio-analyzer' application (edited by JL)
cd /var/www/audio-analyzer/bash && ./bash_loader > /dev/null 2>&1 &
```

To ensure the above modification is working:

```
sudo /etc/init.d/rc.local start
```
