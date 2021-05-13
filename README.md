# Proxier

Free proxy seeder for PHP

## Install

Via Composer

```
composer require jtanjung/proxier
```

## How to use


### Seeding Proxy

Fetch proxy IPs from a free proxy sites:

```php
use Proxier\ProxySeeder;

$seeder = new ProxySeeder();
$proxy = $seeder->FreeProxyListNet();
$proxy->SetTimeOut(60);
$proxy->Seed();
```

### Get a Random Proxy

Get a random proxy information from the cache:

```php
use Proxier\ProxySeeder;

$seeder = new ProxySeeder();
// Try to get random proxy from the cache
echo "Get a random proxy....\n";
// Call Get function to get a random entry, or pass md5 value of IP:Port
$proxy = $seeder->Seed()->Get();
echo json_encode($proxy) . "\n";
```

### Using Event Listener

Easy coding by binding event listeners to the seeder:

```php
use Proxier\ProxySeeder;

$seeder = new ProxySeeder();
$seeder->Bind('OnLoading', function(){
  echo "Start seeding, please wait...\n";
});
$seeder->Bind('OnSeeding', function($value){
  echo json_encode($value) . "\n";
  // You can put block code here to insert the new proxy to database
  /** ->Save([
   *   "ip" => $value->IP,
   *   "port" => $value->Port
   *   "location" => $value->Location
   * ]);
   */
});
$seeder->Bind('OnComplete', function($value){
  echo "\nComplete...\n";
  echo $value->count() ." proxy found.";
});
$seeder->Bind('OnError', function($msg, $exc){
  echo "Message = '$msg'\n";
  // throw $exc;
});
```

### More options

Testing proxy using ProxyTester:

``` php
$tester = new Proxier\ProxyTester();
$tester->SetProxy("<IP>", "<PORT>");
$tester->Bind('OnError', function($msg, $exc){
  echo "Message = '$msg'\n";
  // throw $exc;
});
$tester->Run();
```
See more examples [here](https://github.com/jtanjung/proxier/tree/main/tests)

## Credits

- [Julian](https://github.com/jtanjung)
