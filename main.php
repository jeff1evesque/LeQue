/**
 * main.php
 *
 * Jeffrey M. Levesque
 * 05/12/2014
 *
 * This file calls the python script to initiate the microphone and begin recording audio, and analyzing input stream.
 */

<?php 

$command = escapeshellcmd('/python_scripts/audio_analyzer.py');
$output = shell_exec($command);
echo $output;

?>
