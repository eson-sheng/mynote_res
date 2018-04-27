<?php

$function=$_GET['callback'];

$result=$_GET['data'];

echo $function."($result)";