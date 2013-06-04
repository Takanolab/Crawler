<?php

  // 単語インバースフィルター（仮）
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

  // ファイルに保存
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


  function curl_get_contents( $url, $timeout = 60 ){
    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    $result = curl_exec( $ch );
    curl_close( $ch );
    return $result;
  }

  // WebからHTMLを読み込む
  function getHtmlWeb($url)
  {
    $doc = new DOMDocument();

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_HEADER, false );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    // curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
    $result = curl_exec( $ch );
    curl_close( $ch );

    $doc->loadHTML($result);
    return $doc;
  }

  // ファイルからHTMLを読み込む
  function getHtmlFile($path)
  {
    $doc  = new DOMDocument();
    $doc->loadHTMLFile($path);
    return $doc;
  }

  // 入力されたURL
  // $url = $_POST['inputurl'];

  // HTMLファイル入力
  libxml_use_internal_errors(true);
  // $doc = getHtmlFile("test.html"); 
  // $doc = getHtmlWeb($url);
  $doc = getHtmlWeb("http://www.nicovideo.jp/");
  libxml_clear_errors();

  $xpath = new DOMXpath($doc);

  // ノード取り出し
  foreach($xpath->query('//a') as $node) {
    // $log .=  $node->getAttribute("href")."\n";
    // echo $node->nodeValue."<br/>\n";
    valueFilter($filter, $node);
  } 

  // ログ保存
  saveLogs($log);

?>
