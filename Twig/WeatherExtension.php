<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Twig;

use Th3Mouk\YahooWeatherBundle\Entity\City;
use Th3Mouk\YahooWeatherBundle\Helper\WeatherHelper;

class WeatherExtension extends \Twig_Extension
{
    /**
     * @var WeatherHelper
     */
    protected $helper;

    /**
     * WeatherExtension constructor.
     *
     * @param WeatherHelper $helper
     */
    public function __construct(WeatherHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('weather_forecast', array($this, 'getForecast'), array(
                'is_safe' => array('html'),
                'needs_environment' => true,
            )),
            new \Twig_SimpleFunction('weather_today', array($this, 'getToday'), array(
                'is_safe' => array('html'),
                'needs_environment' => true,
            )),
        );
    }

    public function getForecast(\Twig_Environment $twig, City $city, $unit = 'c')
    {
        $forecasts = $this->helper->getForecast($city, $unit);

        return $twig->render($this->helper->getForecastTemplate(), array(
            'forecasts' => $forecasts,
        ));
    }

    public function getToday(\Twig_Environment $twig, City $city, $unit = 'c')
    {
        $today = $this->helper->getToday($city, $unit);

        return $twig->render($this->helper->getTodayTemplate(), array(
            'today' => $today,
        ));
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        'th3mouk_weather_extension';
    }
}
