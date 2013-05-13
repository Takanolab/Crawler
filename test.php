<?php

$f=get_defined_functions();
echo join("\n",$f["internal"]);
printf(" ");

?>
