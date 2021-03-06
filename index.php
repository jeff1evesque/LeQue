<!DOCTYPE html>
<?php

/**
 * index.php
 */

$command = escapeshellcmd('python/audio_analyzer.py');
$output = shell_exec($command);
echo $output;

?>
<html>
  <head>
    <script src='assets/js/jquery-1.8.3.min.js'></script>
    <script src='assets/js/swfobject.min.js'></script>
    <script src='assets/js/recorder.min.js'></script>
    <script src='assets/js/recorder_control.min.js'></script>
    <script src='assets/js/recorder_attributes.min.js'></script>
    <script src='assets/js/recorder_initialize.min.js'></script>

    <link rel='stylesheet' href='assets/css/main.min.css'>
  </head>

  <body>
    <div class='container'>

      <div class='control_panel audio'>

        <a class='record_button' onclick="FWRecorder.record('audio', 'audio.wav');" href='javascript:void(0);' title='Record'>
          <img src='assets/img/record.png' width='24' height='24' alt='Record' />
        </a>

        <a class='play_button' style='display:none;' onclick='FWRecorder.playBack('audio');" href="javascript:void(0);' title='Play'>
          <img src='assets/img/play.png' width='24' height='24' alt='Play' />
        </a>

        <a class='pause_button' style='display:none;' onclick="FWRecorder.pausePlayBack('audio');" href='javascript:void(0);' title='Pause'>
          <img src='assets/img/pause.png' width='24' height='24' alt='Pause' />
        </a>

        <div class='level'></div>

      </div>  <!-- END: <div class='control_panel audio'> -->


      <div class='details'>
        <button class='show_level' onclick='FWRecorder.observeLevel();'>Show Level</button>
        <button class='hide_level' onclick='FWRecorder.stopObservingLevel();' style='display: none;'>Hide Level</button>
        <span id='save_button'>
          <span id='flashcontent'>
            <p>Your browser must have JavaScript enabled and the Adobe Flash Player installed.</p>
          </span>
        </span>

        <div id='status'>Recorder Status...</div>
        <div>Duration: <span id='duration'></span></div>
        <div>Activity Level: <span id='activity_level'></span></div>
        <div>Upload status: <span id='upload_status'></span></div>
      </div>  <!-- Closes <div class='details'> -->

      <form id='uploadForm' name='uploadForm' action='php/upload.php'>
        <input name='authenticity_token' value='xxxxx' type='hidden'>
        <input name='upload_file[parent_id]' value='1' type='hidden'>
        <input name='format' value='json' type='hidden'>
      </form>

      <h4>Configure Microphone</h4>
      <form class='mic_config' onsubmit='return false;'>
        <ul>
          <li>
            <label for='rate'>Rate</label>
            <select id='rate' name='rate'>
              <option value='44'>44,100 Hz</option>
              <option value='16' selected>16,000 Hz</option>
              <option value='11'>11,025 Hz</option>
              <option value='8'>8,000 Hz</option>
              <option value='5'>5,512 Hz</option>
            </select>
          </li>

          <li>
            <label for='gain'>Gain</label>
            <select id='gain' name='gain'></select>
          </li>

          <li>
            <label for='silenceLevel'>Silence Level</label>
            <select id='silenceLevel' name='silenceLevel'></select>
          </li>

          <li>
            <label for='silenceTimeout'>Silence Timeout</label>
            <input id='silenceTimeout' name='silenceTimeout' value='2000'/>
          </li>

          <li>
            <input id='useEchoSuppression' name='useEchoSuppression' type='checkbox'/>
            <label for='useEchoSuppression'>Use Echo Suppression</label>
          </li>

          <li>
            <input id='loopBack' name='loopBack' type='checkbox'/>
            <label for='loopBack'>Loop Back</label>
          </li>

          <li>
            <button onclick='configureMicrophone();'>Configure</button>
          </li>
        </ul>
      </form>

    </div>  <!-- END: <div class='container'> -->
  </body>

</html>
