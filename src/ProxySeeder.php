<?php namespace Proxier;

use Pehape\Bases\BaseEventClass;
use Pehape\Traits\HasDriverContext;

/**
 * Class ProxySeeder
 * @package Proxier
 */
class ProxySeeder extends BaseEventClass
{
    use HasDriverContext;

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->namespace = "\\Proxier\\Drivers";
        $this->directory = realpath(__DIR__) . "/Drivers";
    }

}
