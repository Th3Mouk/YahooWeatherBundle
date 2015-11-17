<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Helper;

use Th3Mouk\YahooWeatherBundle\Entity\City;
use Th3Mouk\YahooWeatherBundle\Manager\HistoryManager;

class WeatherHelper
{
    /**
     * @var HistoryManager
     */
    protected $history_manager;

    /**
     * @var array
     */
    protected $templates;

    /**
     * WeatherHelper constructor.
     *
     * @param HistoryManager $history_manager
     */
    public function __construct(HistoryManager $history_manager)
    {
        $this->history_manager = $history_manager;
    }

    public function getForecast(City $city, $unit = 'c')
    {
        return $this->history_manager->getForecast($city, $unit);
    }

    public function getToday(City $city, $unit = 'c')
    {
        return $this->history_manager->getToday($city, $unit);
    }

    public function setTemplates($templates)
    {
        $this->templates = $templates;
    }

    public function getTodayTemplate()
    {
        return $this->templates['today'];
    }

    public function getForecastTemplate()
    {
        return $this->templates['forecast'];
    }
}
