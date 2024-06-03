<?php

$config = include ('config.php');
//Returning datas includes in config.php
//Retornando os dados que foi definido em config.php
define('DB_HOSTNAME', $config['DB_HOSTNAME']);
define('DB_USERNAME', $config['DB_USERNAME']);
define('DB_PASSWORD', $config['DB_PASSWORD']);
define('DB_DATABASE', $config['DB_DATABASE']);
?>