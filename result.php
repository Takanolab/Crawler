<?php
	$url = $_POST["inpurl"];	//入力されたURL
	$csv_data = "";			//格納するデータ
	$csv_name = "crawl_result.csv"; //csvのファイル名

	//description,keywords,author情報を取得
	$metas = get_meta_tags($url);
	$csv_data = $metas['description'].",";
	$csv_data .= $metas['keywords'].",";
	$csv_data .= $metas['author'].",";

	//URL先のHTML情報を取得
	$html = file_get_contents($url);
	//正規表現でタイトルタグを取得
	preg_match('/<title>(.*?)<\/title>/',$html,$matches);
	$csv_data .= $matches[1]."\n";

	//文字化け対策 UTF8にする
	mb_language('japanese');
	$csv_data = mb_convert_encoding($csv_data,"UTF-8","auto");

	//csvファイルの作成
	$fp = fopen($csv_name,'ab');			//追記モード
	flock($fp,LOCK_EX);				//排他ロック
	fwrite($fp, pack('C*',0xEF,0xBB,0xBF));		//BOM対策
	fwrite($fp,$csv_data);
	fclose($fp);

	//ファイルの出力
	header('Content-Type: application/octet-stream'); 
	header('Content-Disposition: attachment; filename="'.$csv_name.'"'); 
	readfile($csv_name);

	//作成したファイルを削除する
	unlink($csv_name);

?>
