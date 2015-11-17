<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Tests\Manager;

use Th3Mouk\YahooWeatherBundle\Manager\APIManager;

class APIManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var APIManager
     */
    protected $api;

    protected function setUp()
    {
        $this->api = new APIManager();
    }

    public function testCallApiWoeid()
    {
        $this->api->callApiWoeid(12726473);
        $this->assertSame('Clermont-Ferrand', $this->api->getLocation());
    }

    public function testCallApiCityName()
    {
        $this->api->callApiCityName('Clermont-Ferrand');
        $this->assertSame('Clermont-Ferrand', $this->api->getLocation());
    }

    public function testTemperature()
    {
        $this->api->callApiWoeid(12726473);
        $this->assertInternalType('int', intval($this->api->getTemperature()));
    }

    public function testTemperatureF()
    {
        $this->api->callApiCityName('Clermont-Ferrand', 'f');
        $this->assertInternalType('int', intval($this->api->getTemperature()));
    }

    public function testTemperatureUnit()
    {
        $this->api->callApiWoeid(12726473);
        $this->assertRegExp('/^(-)?[0-9]+ C$/', $this->api->getTemperature(true));
    }

    public function testTemperatureUnitF()
    {
        $this->api->callApiCityName('Clermont-Ferrand', 'f');
        $this->assertRegExp('/^(-)?[0-9]+ F$/', $this->api->getTemperature(true));
    }
}
