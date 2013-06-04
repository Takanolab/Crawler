<html>
<head><title>PHP TEST</title></head>
<body>

<?php

$conn = "host=localhost dbname=PHPTEST user=postgres password=xxx";
$link = pg_connect($conn);
if (!$link) {
    die('Ú‘±¸”s‚Å‚·B'.pg_last_error());
}

print('Ú‘±‚É¬Œ÷‚µ‚Ü‚µ‚½B<br>');

// PostgreSQL‚É‘Î‚·‚éˆ—

$close_flag = pg_close($link);

if ($close_flag){
    print('Ø’f‚É¬Œ÷‚µ‚Ü‚µ‚½B<br>');
}

?>
</body>
</html>
