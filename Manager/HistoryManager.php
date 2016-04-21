<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Manager;

use Doctrine\ORM\EntityManager;
use Th3Mouk\YahooWeatherBundle\Entity\CityInterface;
use Th3Mouk\YahooWeatherBundle\Entity\Forecast;

class HistoryManager
{
    /**
     * @var APIManager
     */
    protected $api;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * HistoryManager constructor.
     *
     * @param APIManager    $api
     * @param EntityManager $em
     */
    public function __construct(APIManager $api, EntityManager $em)
    {
        $this->api = $api;
        $this->em = $em;
    }

    /**
     * @param $city
     * @param string $unit
     *
     * @return array
     */
    public function getForecast($city, $unit = 'c')
    {
        $dateForecast = new \DateTime();
        $dateForecast = $dateForecast->add(new \DateInterval('P9D'));

        $lastDayForecast = $this->getForecastRepository()->findOneBy(array(
            'city' => $city,
            'date' => $dateForecast,
        ));

        if (!$lastDayForecast) {
            $datas = $this->downloadForecast($city, $unit);

            return $this->updateForecast($city, $datas, $unit);
        }

        return $this->getForecastRepository()->getForecasts($city);
    }

    /**
     * @param $city
     * @param string $unit
     *
     * @return null|object
     */
    public function getToday($city, $unit = 'c')
    {
        $dateForecast = new \DateTime();

        $today = $this->getForecastRepository()->findOneBy(array(
            'city' => $city,
            'date' => $dateForecast,
        ));

        if (!$today) {
            $datas = $this->downloadForecast($city, $unit);

            $forecasts = $this->updateForecast($city, $datas, $unit);

            return current($forecasts);
        }

        return $today;
    }

    /**
     * @param CityInterface $city
     * @param string        $unit
     *
     * @return array
     */
    protected function downloadForecast(CityInterface $city, $unit = 'c')
    {
        if ($city->getWoeid()) {
            $this->api->callApiWoeid($city->getWoeid(), $unit);
        } else {
            $this->api->callApiCityName($city->getName(), $unit);
        }

        return $this->api->getForecast();
    }

    /**
     * @param $city
     * @param $datas
     * @param string $unit
     *
     * @return array
     */
    protected function updateForecast($city, $datas, $unit = 'c')
    {
        $currentDate = new \DateTime();
        $dateInterval = new \DateInterval('P1D');
        $forecasts = array();

        foreach ($datas as $data) {
            $forecast = $this->createUpdateForecastEntity($city, clone $currentDate, $data, $unit);
            $forecasts[] = $forecast;
            $currentDate = $currentDate->add($dateInterval);
        }

        return $forecasts;
    }

    /**
     * @param $city
     * @param $currentDate
     * @param $data
     * @param string $unit
     *
     * @return null|object|Forecast
     */
    protected function createUpdateForecastEntity($city, $currentDate, $data, $unit = 'c')
    {
        $forecastEntity = $this->getForecastRepository()->findOneBy(array(
            'city' => $city,
            'date' => $currentDate,
        ));

        if (!$forecastEntity) {
            $forecastEntity = new Forecast();
        }

        $forecastEntity->setCity($city);
        $forecastEntity->setCode($data['code']);
        $forecastEntity->setLow($data['low']);
        $forecastEntity->setHigh($data['high']);
        $forecastEntity->setText($data['text']);
        $forecastEntity->setDate($currentDate);
        $forecastEntity->setUnit($unit);

        $this->em->persist($forecastEntity);
        $this->em->flush();

        return $forecastEntity;
    }

    /**
     * Update the forecasts of all the cities.
     *
     * @param string $unit
     *
     * @return array
     */
    public function updateAllCitiesForecast($unit = 'c')
    {
        $cities = $this->getCityRepository()->findAll();

        foreach ($cities as $city) {
            $datas = $this->downloadForecast($city, $unit);

            return $this->updateForecast($city, $datas, $unit);
        }
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getCityRepository()
    {
        return $this->em->getRepository('Th3MoukYahooWeatherBundle:City');
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getForecastRepository()
    {
        return $this->em->getRepository('Th3MoukYahooWeatherBundle:Forecast');
    }
}
