<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$conn = "host=localhost dbname=PHPTEST user=postgres password=xxx";
$link = pg_connect($conn);
if (!$link) {
    die('�ڑ����s�ł��B'.pg_last_error());
}

print('�ڑ��ɐ������܂����B<br>');

// PostgreSQL�ɑ΂��鏈��

$close_flag = pg_close($link);

if ($close_flag){
    print('�ؒf�ɐ������܂����B<br>');
}

?>
</body>
</html>
