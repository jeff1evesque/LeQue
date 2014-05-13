<?php

/**
 * main.php
 *
 * Jeffrey M. Levesque
 * 05/12/2014
 *
 * This file calls the python script to initiate the microphone and begin recording audio, and analyzing input stream.
 */

$command = escapeshellcmd('python_scripts/audio_analyzer.py');
$output = shell_exec($command);
echo $output;

?>

<!-- index.html -->
    <html>
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="wami/swfobject.js"></script></script>
        <script src="js/recorder.js"></script>
        <script src="js/gui.js"></script>
    </head>

    <body>
        <div id="recorder">
            <button id="record">Record</button>
            <button id="play">Play</button>
        </div>
        <div id="flash"></div>
    </body>

    <script>
        // initialize Wami
        Wami.setup({
            id: 'flash' // where to put the flash object
        });

        // initialize some global vars
        var recording = '';
        var recordingUrl = '';
        var playBackUrl = '';

        // get button elements
        var record = $('#record');
        var play = $('#play');

        // define functions
        function startRecording() {
            recording = 'temp.wav';
            recordingUrl = 'wami/save_file.php?filename=' + recording;
//console.log(Wami.startRecording(recordingUrl));
            Wami.startRecording(recordingUrl);
            // update button attributes
            record
                .html('Stop')
                .unbind()
                .click(function() {
                    stopRecording();
                });
        }

        function stopRecording() {
            Wami.stopRecording();
            // get the recording for playback
            playBackUrl = 'wami/' + recording;
            // update button attributes
            record
                .html('Record')
                .unbind()
                .click(function() {
                    startRecording();
                });
        }

        function startPlaying() {
            Wami.startPlaying(playBackUrl);
            // update button attributes
            play
                .html('Stop')
                .unbind()
                .click(function() {
                    stopPlaying();
                });
        }

        function stopPlaying() {
            Wami.stopPlaying();
            // update button attributes
            play
                .html('Play')
                .unbind()
                .click(function() {
                    startPlaying();
                });
        }

        // add initial click functions
        record.click(function() {
            startRecording();
        });

        play.click(function() {
            startPlaying();
        });
    </script>

    </html>
