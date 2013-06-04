<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$conn = "host=localhost dbname=PHPTEST user=postgres password=xxx";
$link = pg_connect($conn);
if (!$link) {
    die('接続失敗です。'.pg_last_error());
}

print('接続に成功しました。<br>');

pg_set_client_encoding('UTF-8');

$result = pg_query('SELECT id, mtext, count FROM ma');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}

for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    print('id='.$rows['id']);
    print(',mtext='.$rows['mtext'].'<br>');
    print(',count='.$rows['count'].'<br>');
}

print('<br>データを追加します。<br><br>');

$sql = "INSERT INTO ma (id, mtext, count) VALUES (2, '東', 0)";
$result_flag = pg_query($sql);

if (!$result_flag) {
    die('INSERTクエリーが失敗しました。'.pg_last_error());
}

print('<br>追加後のデータを取得します。<br><br>');

$result = pg_query('SELECT id, mtext, count FROM ma');
if (!$result) {
    die('クエリーが失敗しました。'.pg_last_error());
}

for ($i = 0 ; $i < pg_num_rows($result) ; $i++){
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    print('id='.$rows['id']);
    print(',mtext='.$rows['mtext'].'<br>');
    print(',count='.$rows['count'].'<br>');
}

$close_flag = pg_close($link);

if ($close_flag){
    print('切断に成功しました。<br>');
}

?>
</body>
</html>
