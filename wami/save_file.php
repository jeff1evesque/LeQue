<?php
    /* save_file.php */

    // get the filename
    parse_str($_SERVER['QUERY_STRING'], $params);
    $file = isset($params['filename']) ? $params['filename'] : 'temp.wav';
    // save the recorded audio to that file
    $content = file_get_contents('php://input');
    $fh = fopen($file, 'w') or die("can't open file");
    fwrite($fh, $content);
    fclose($fh);
?>
