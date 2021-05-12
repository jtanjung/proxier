<?php
require_once "../vendor/autoload.php";

use Proxier\ProxySeeder;

$seeder = new ProxySeeder();
$seeder->Bind('OnLoading', function(){
  echo "Start seeding, please wait...\n";
});
$seeder->Bind('OnSeeding', function($value){
  echo json_encode($value) . "\n";
});
$seeder->Bind('OnComplete', function($value){
  echo "\nComplete...\n";
  echo $value->count() ." proxy found.";
});
$seeder->Bind('OnError', function($msg, $exc){
  echo "Message = '$msg'\n";
  // throw $exc;
});
$spyone = $seeder->FreeProxyListNet();
$spyone->SetTimeOut(60);
$spyone->Seed();
echo "\n";

// Try to get random proxy from the cache
echo "Get a random proxy....\n";
// Call Get function to get a random entry, or pass md5 value of IP:Port
$proxy = $spyone->Get();
echo json_encode($proxy) . "\n";
