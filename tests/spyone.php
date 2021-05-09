<?php
date_default_timezone_set( "Asia/Jakarta" );
require_once "../vendor/autoload.php";

use Proxier\ProxySeeder;

$seeder = new ProxySeeder();
$seeder->Bind('OnLoading', function(){
  echo "Start seeding, please wait...\n";
});
$seeder->Bind('OnSeeding', function($value){
  echo "\r" . json_encode($value);
});
$seeder->Bind('OnComplete', function($value){
  echo "\nComplete...\n";
  echo $value->count() ." proxy found.";
});
$spyone = $seeder->SpyOne();
$spyone->Seed();
echo "\n";

// Try to get random proxy from the cache
echo "Get a random proxy....\n";
// Call Get function to get a random entry, or pass md5 value of IP:Port
$proxy = $spyone->Get();
echo json_encode($proxy) . "\n";
