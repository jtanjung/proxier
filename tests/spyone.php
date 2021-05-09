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
  echo $value->count() ." proxy found.\n";
});
$spyone = $seeder->SpyOne();
$spyone->Seed();
echo "\n";
