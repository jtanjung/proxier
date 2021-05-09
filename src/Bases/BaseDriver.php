<?php namespace Proxier\Bases;

use Pehape\Bases\BaseEventClass;
use Pehape\Traits\HasCache;
use Pehape\Configs\ProxyConfig;
use Pehape\Models\Option;

/**
 * Class BaseDriver
 * @package Proxier\Bases
 */
abstract class BaseDriver extends BaseEventClass
{

    use HasCache;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->cache_dir = realpath( __DIR__ . '/../..' ) . "/cache/";

        /** Load and reconstruct cache object **/
        if ($this->LoadCache()->cache) {
          foreach ($this->cache as &$value) {
            $value = new ProxyConfig($value);
          }
        }
        else {
          $this->cache = new Option();
        }
    }

}
