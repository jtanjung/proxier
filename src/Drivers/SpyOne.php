<?php namespace Proxier\Drivers;

use Pehape\Bases\BaseWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Pehape\Configs\ProxyConfig;
use Pehape\Helpers\Text;

/**
 * Class SpyOne
 * @package Proxier\Drivers
 */
class SpyOne extends BaseWebDriver
{

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->endpoint = 'https://spys.one/squid-proxy/';
    }

    /**
     * A method to extract informations from the page dom/response.
     *
     * @return self
     */
    protected function doextract()
    {
        /** Find select field to change proxy count **/
        $this->instance->findElement(WebDriverBy::id('xpp'))
             ->findElement(WebDriverBy::cssSelector('option[value="5"]'))
             ->click();

        $xpath = '//tr[@class="spy1x"][@onmouseover="this.style.background=\'#002424\'"]';

        // wait until the next page is loaded
        $this->instance->wait()->until(
          WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath($xpath))
        );

        /** Fetch all proxy table row **/
        $rows = $this->instance->findElements(WebDriverBy::xpath($xpath));

        // Extract all rows
        if (count($rows)) {
          foreach ($rows as $row) {
            $cols = $row->findElements(WebDriverBy::tagName('td'));
            $host = $cols[0]->findElement(WebDriverBy::cssSelector('font[class="spy14"]'))->getText();
            $host = Text::CleanWhiteSpace($host);

            $type = $cols[1]->findElement(WebDriverBy::cssSelector('font[class="spy1"]'))->getText();
            $location = Text::CleanWhiteSpace($cols[3]->getText());
            $hostname = Text::CleanWhiteSpace($cols[4]->getText());
            $latency = Text::CleanWhiteSpace($cols[5]->getText());

            $index = md5($host);
            $host = explode(':', $host);

            $this->cache->$index = new ProxyConfig([
              "IP" => $host[0],
              "Port" => (int)$host[1],
              "Type" => strtoupper($type),
              "HostName" => $hostname,
              "Location" => $location,
              "Latency" => (float)$latency
            ]);

            // Notify event listener for the new entry
            static::__trigger('OnSeeding', [$this->cache->$index]);
          }
        }

        // Save cache if not empty
        if (! $this->cache->is_empty()) {
          $this->SaveCache();
        }

        // Notify event listener about process completion
        static::__trigger('OnComplete', [$this->cache]);
    }

}
