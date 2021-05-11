<?php namespace Proxier;

use Pehape\Bases\BaseEventClass;
use Pehape\Services\CURLService;
use Pehape\Configs\ProxyConfig;
use Pehape\Traits\HasProxyConfig;

/**
 * Class ProxySeeder
 * @package Proxier
 */
class ProxyTester extends BaseEventClass
{

    use HasProxyConfig;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->instance = new CURLService();
        $this->instance->Listener(true);
        $this->instance->SetTimeOut(10);
    }

    /**
     * Run proxy test
     *
     * @return void
     */
    protected function Run()
    {
        /** Set google.com as testing domain **/
        $this->instance->SetUrl('https://www.google.com');
        /** Send request **/
        $this->instance->Execute();
        /** Trigger on complete event listener **/
        static::__trigger('OnComplete', [
          $this->instance->GetProxy(),
          $this->instance->GetHTTPCode(),
          $this->instance->GetErrorCode(),
          $this->instance->GetErrorMessage()
        ]);
    }

}
