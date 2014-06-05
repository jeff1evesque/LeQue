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

Since we running OSX 10.6.8 for the host Operating system, we installed Virtual$

###Installation:

The following packages need to be installed through terminal in Ubuntu:

```
sudo apt-get install inotify-tools
```
