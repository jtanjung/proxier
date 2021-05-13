<?php
require_once "../vendor/autoload.php";

use Proxier\ProxySeeder;
use Proxier\ProxyTester;

$seeder = new ProxySeeder();
// Try to get random proxy from the cache
echo "Get a random proxy....\n";
// Call Get function to get a random entry, or pass md5 value of IP:Port
$proxy = $seeder->Seed()->Get();

$tester = new ProxyTester();
//$tester->SetProxy($proxy);
$tester->Bind('OnProxy', function()use($proxy){
  return $proxy;
});
$tester->Bind('OnError', function($msg, $exc){
  echo "Message = '$msg'\n";
  // throw $exc;
});
$tester->Bind('OnComplete', function($info, $status, $error, $message){
  echo json_encode($info) . PHP_EOL;
  echo "Status Code = $status" . PHP_EOL;
  echo "Error Code = $error" . PHP_EOL;
  echo "Error Msg = '$message'" . PHP_EOL;
});
$tester->Run();
