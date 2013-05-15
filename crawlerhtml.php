<?php

  // Warningを表示させない
  error_reporting(0);

  // 単語フィルター（仮）
  $filter = array("★");
  $log = "";

  // ノードの内容でフィルタ
  function valueFilter($filter, $node)
  {
    global $log;
    foreach($filter as $word) {
      if (strstr($node->nodeValue, $word)) {
        $log .=  $node->getAttribute("href")."\n";
        echo $node->nodeValue . "<br>\n";
      }
    }
  }

  // リンクを保存
  function saveLogs($text)
  {
    $file = fopen("crowler.log", "wb");
    // mb_language("Japanese");
    // $text = mb_convert_encoding($text, mb_detect_encoding(), "AUTO");
    if(fwrite($file, $text) == FALSE){
      return 0;
    }
    $res = fclose($file);

    if($res){
      return 0;
    }else{
      return -1;
    }
  }

  // HTMLファイル入力
  $file = "test.html";
  $doc  = new DOMDocument();

  $doc->loadHTMLFile($file);
  $xpath = new DOMXpath($doc);

  // ノード取り出し
  foreach($xpath->query('//a') as $node) {
    // $log .=  $node->getAttribute("href")."\n";
    // echo $node->nodeValue."<br/>\n";
    valueFilter($filter, $node);
  } 
  saveLogs($log);

?>
