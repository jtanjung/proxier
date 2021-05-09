<?php
date_default_timezone_set( "Asia/Jakarta" );
require_once "../vendor/autoload.php";

use Proxier\ProxySeeder;

$seeder = new ProxySeeder();
// Try to get random proxy from the cache
echo "Get a random proxy....\n";
// Call Get function to get a random entry, or pass md5 value of IP:Port
$proxy = $seeder->Seed()->Get();
echo json_encode($proxy) . "\n";
