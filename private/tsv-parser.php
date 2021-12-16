<?php

$shops = array('https://docs.google.com/spreadsheets/d/e/2PACX-1vTz_RXZmroLmYqtaf24_dR7uI5slgIpn7nVbWR5D3A1umwWkrEsJcVsdzVNSUNYlGA6fd5ynw3twFrV/pub?output=tsv', 
'https://docs.google.com/spreadsheets/d/e/2PACX-1vTbAbduYyb76lbRwTXuocCDuxgDhgp9dmjQJNdewvzujaWjJY_ESYNFFQOGctqtdnmsvkx9gGgOijKo/pub?output=tsv');

$out = [];

foreach ($shops as $shop) {
  $data = file_get_contents($shop);
  // Break lines
  $lines = explode("\n", $data);
  $keys = explode("\t", $lines[0]);
  
  for($i = 1; $i < count($lines); $i++){
    $data = explode("\t", $lines[$i]);
    $item = [];
    for($j = 0; $j < count($data); $j++){
      $data[$j] = str_replace("\r", "", $data[$j]);
      $keys[$j] = str_replace("\r", "", $keys[$j]);
      $item[$keys[$j]]=$data[$j];
    }
    array_push($out, $item);
  }
}
file_put_contents("otherItems.txt", json_encode($out));
?>