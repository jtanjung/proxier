<?php namespace Proxier\Bases;

use Proxier\Bases\BaseDriver;
use Pehape\Services\WebPageService;
use Pehape\Traits\HasWebPageService;
use Pehape\Traits\HasSeedLoader;

/**
 * Class BaseWebDriver
 * @package Proxier\Bases
 */
abstract class BaseWebDriver extends BaseDriver
{

    use HasWebPageService, HasSeedLoader;

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
