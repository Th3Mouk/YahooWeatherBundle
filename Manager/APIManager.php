<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Manager;

use Th3Mouk\YahooWeatherAPI\YahooWeatherAPI;
use Th3Mouk\YahooWeatherAPI\YahooWeatherAPIInterface;

class APIManager implements YahooWeatherAPIInterface
{
    /**
     * @var YahooWeatherAPIInterface
     */
    protected $api;

    /**
     * APIManager constructor.
     */
    public function __construct()
    {
        $this->api = new YahooWeatherAPI();
    }

    /**
     * {@inheritdoc}
     */
    public function callApiWoeid($woeid = null, $unit = 'c')
    {
        return $this->api->callApiWoeid($woeid, $unit);
    }

    /**
     * {@inheritdoc}
     */
    public function callApiCityName($name = null, $unit = 'c')
    {
        return $this->api->callApiCityName($name, $unit);
    }

    /**
     * {@inheritdoc}
     */
    public function callApi($yql = null)
    {
        return $this->api->callApi($yql);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocation()
    {
        return $this->api->getLocation();
    }

    /**
     * {@inheritdoc}
     */
    public function getTemperature($with_unit = false)
    {
        return $this->api->getTemperature($with_unit);
    }

    /**
     * {@inheritdoc}
     */
    public function getForecast()
    {
        return $this->api->getForecast();
    }
}
