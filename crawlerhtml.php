<?php

  $filter = array("★");
  function selecter($filter, $value)
  {
      foreach($filter as $word) {
          if (strstr($value, $word)) {
              echo $value."<br>\n";
          }
      }
  }

  $file = "C:/Doc/asahi.html";
  $doc  = new DOMDocument();

  $doc->loadHTMLFile($file);
  $xpath = new DOMXpath($doc);

  foreach($xpath->query('//a') as $node) {
      // echo $node->getAttribute("href")." ";
        echo $node->nodeValue."<br/>\n";
      // selecter($filter, $node->nodeValue);
  } 
?>
