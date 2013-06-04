<?php

define('Mecab_Encoding', 'UTF-8');
define('Mecab_ResultEncoding', 'UTF-8');
define('MeCab_Path', 'C:\MeCab\bin\mecab.exe');

function morph_analysis($text) {
  $text = mb_convert_encoding($text, Mecab_Encoding, Mecab_ResultEncoding);
  $result = "";
  $descriptorspec = array (
    0 => array ("pipe", "r"), // stdin
    1 => array ("pipe", "w") // stdout
  );
  $process = proc_open(MeCab_Path, $descriptorspec, $pipes);

  if (is_resource($process)) {
    // mecab‚É•¶Í‚ð—^‚¦‚é
    fwrite($pipes[0], $text);
    fclose($pipes[0]);
    // Œ‹‰Ê‚ð“Ç‚ÝŽæ‚é
    while (!feof($pipes[1])) {
      $result .= fread($pipes[1], 4096);
    }
    fclose($pipes[1]);
    proc_close($process);
   
    $result = mb_convert_encoding($result, Mecab_ResultEncoding, Mecab_Encoding);
    $lines = explode("\r\n", $result);
    $res = array();

    foreach($lines as $line) {
      if(in_array(trim($line), array('EOS', ''))) {continue;}
      $s = explode("\t", $line);
      $word = $s[0];
      $words = explode(',', $s[1]);
      //Šî–{Œ`‚È‚Ç‚ð—˜—p‚µ‚½‚¢ê‡‚Í‚±‚±‚É’Ç‰Á
      $res[] = array(
        'word' => $word,
        'class' => $words[0],
        'detail1' => $words[1],
        'detail2' => $words[2],
        'detail3' => $words[3],
        'conjugation1' => $words[4]
        // 'conjugation2' => $words[5]
      );
    }
    return $res;
  } else {
    return false;
  }
}

$text = "‚·‚à‚à‚à‚à‚à‚à‚à‚à‚Ì‚¤‚¿";
$text = mb_convert_encoding($text, 'UTF-8', 'Shift-JIS');
$res = morph_analysis($text);

foreach($res as $fes){
echo $fes['word']." ".$fes['class'];
echo "<br>";
}

?>
