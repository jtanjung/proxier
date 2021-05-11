<?php namespace Proxier\Drivers;

use Pehape\Bases\BaseWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Pehape\Configs\ProxyConfig;
use Pehape\Helpers\Text;

/**
 * Class FreeProxyListNet
 * @package Proxier\Drivers
 */
class FreeProxyListNet extends BaseWebDriver
{

    /**
     * Class constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->endpoint = 'https://free-proxy-list.net/';
    }

    /**
     * A method to extract the seed data.
     *
     * @return self
     */
    protected function doseed()
    {
        $xpath = '//ul/li/a[@aria-controls="proxylisttable"]';

        // wait until the next page is loaded
        $this->instance->wait()->until(
          WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::xpath($xpath))
        );

        /** Fetch all page buttons **/
        $navs = $this->instance->findElements(WebDriverBy::xpath($xpath));

        // Extract all pages
        if (count($navs)) {
          array_pop($navs);
          array_pop($navs);
          // Get max page
          $maxpage = array_pop($navs);
          $pages = $maxpage->getText();
          if (!is_numeric($pages)) {
            // Notify event listener about process completion
            static::__trigger('OnComplete', [$this->cache]);
            return false;
          }

          $pages = (int)$pages;
          $counter = 1;
          // Extract proxy page by page
          while ($counter <= $pages) {
            $xpath = '//tbody/tr[@role="row"]';
            /** Fetch all proxy table row **/
            $rows = $this->instance->findElements(WebDriverBy::xpath($xpath));

            // Extract all rows
            if (count($rows)) {
              foreach ($rows as $row) {
                $cols = $row->findElements(WebDriverBy::tagName('td'));
                $ip = $cols[0]->getText();
                $port = $cols[1]->getText();
                $location = $cols[2]->getText();
                $type = $cols[6]->getText() == 'yes' ? 'HTTPS' : 'HTTP';

                $index = md5("$ip:$port");

                $this->cache->$index = new ProxyConfig([
                  "IP" => $ip,
                  "Port" => (int)$port,
                  "Type" => $type,
                  "Location" => $location
                ]);

                // Notify event listener for the new entry
                static::__trigger('OnSeeding', [$this->cache->$index]);
              }
            }

            // Refetch nav button to avoid losing context
            $xpath = '//ul/li/a[@aria-controls="proxylisttable"]';
            /** Fetch all page buttons **/
            $navs = $this->instance->findElements(WebDriverBy::xpath($xpath));
            // Get NEXT button
            array_pop($navs);
            $next = array_pop($navs);

            // Go to next table
            $next->click();
            $counter++;
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
