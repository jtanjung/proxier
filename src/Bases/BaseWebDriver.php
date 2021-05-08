<?php namespace Proxier\Bases;

use Pehape\Bases\BaseEventClass;
use Pehape\Services\WebPageService;

/**
 * Class BaseWebDriver
 * @package Proxier\Bases
 */
abstract class BaseWebDriver extends BaseEventClass
{

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->instance = new WebPageService();
    }

}
