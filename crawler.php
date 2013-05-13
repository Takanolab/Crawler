<?php
  $url = $_POST["inpurl"];

  libxml_use_internal_errors(true);
  $doc = new DOMDocument();
  $doc->loadHTML(file_get_contents($url));
  libxml_clear_errors();

  $xpath  = new DOMXPath($doc);

  foreach($xpath->query('//a') as $node){
    echo $node->getAttribute("href")." ";
    echo $node->nodeValue."<br/>\n";
  }
?>
