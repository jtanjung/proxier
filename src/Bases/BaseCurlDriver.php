<?php namespace Proxier\Bases;

use Pehape\Bases\BaseEventClass;
use Pehape\Services\CURLService;

/**
 * Class BaseCurlDriver
 * @package Proxier\Bases
 */
abstract class BaseCurlDriver extends BaseEventClass
{

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->instance = new CURLService();
    }

}
