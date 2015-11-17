<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Tests\Manager;

use Th3Mouk\YahooWeatherBundle\Manager\APIManager;
use Th3Mouk\YahooWeatherBundle\Manager\HistoryManager;

class HistoryManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var APIManager
     */
    protected $api;

    protected function setUp()
    {
        $this->api = new APIManager();
    }

    public function testGetForecast()
    {
        $cityWoeid = $this->getMock('\Th3Mouk\YahooWeatherBundle\Entity\City');
        $cityWoeid->expects($this->any())->method('getWoeid')->will($this->returnValue(12726473));

        $forecastRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->setMethods(array('findOneBy'))
            ->disableOriginalConstructor()
            ->getMock();
        $forecastRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->setMethods(array('getRepository', 'persist', 'flush'))
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($forecastRepository));
        $entityManager->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));
        $entityManager->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));

        $historyManager = new HistoryManager($this->api, $entityManager);

        $forecasts = $historyManager->getForecast($cityWoeid);

        $currentDate = new \DateTime();
        $dateInterval = new \DateInterval('P1D');

        $this->assertSame(count($forecasts), 5);
        foreach ($forecasts as $forecast) {
            $this->assertSame($forecast->getDate()->format('Y-m-d'), $currentDate->format('Y-m-d'));
            $this->assertNotNull($forecast->getCode());
            $this->assertNotNull($forecast->getLow());
            $this->assertNotNull($forecast->getHigh());
            $this->assertNotNull($forecast->getText());
            $this->assertNotNull($forecast->getUnit());
            $this->assertNotNull($forecast->getCity());
            $currentDate = $currentDate->add($dateInterval);
        }

        $cityName = $this->getMock('\Th3Mouk\YahooWeatherBundle\Entity\City');
        $cityName->expects($this->any())->method('getName')->will($this->returnValue('Clermont-Ferrand'));

        $historyManager = new HistoryManager($this->api, $entityManager);

        $forecasts = $historyManager->getForecast($cityName);

        $currentDate = new \DateTime();
        $dateInterval = new \DateInterval('P1D');

        $this->assertSame(count($forecasts), 5);
        foreach ($forecasts as $forecast) {
            $this->assertSame($forecast->getDate()->format('Y-m-d'), $currentDate->format('Y-m-d'));
            $this->assertNotNull($forecast->getCode());
            $this->assertNotNull($forecast->getLow());
            $this->assertNotNull($forecast->getHigh());
            $this->assertNotNull($forecast->getText());
            $this->assertNotNull($forecast->getUnit());
            $this->assertNotNull($forecast->getCity());
            $currentDate = $currentDate->add($dateInterval);
        }
    }

    public function testGetToday()
    {
        $cityWoeid = $this->getMock('\Th3Mouk\YahooWeatherBundle\Entity\City');
        $cityWoeid->expects($this->any())->method('getWoeid')->will($this->returnValue(12726473));

        $forecastRepository = $this
            ->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->setMethods(array('findOneBy'))
            ->disableOriginalConstructor()
            ->getMock();
        $forecastRepository
            ->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValue(null));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->setMethods(array('getRepository', 'persist', 'flush'))
            ->disableOriginalConstructor()
            ->getMock();

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($forecastRepository));
        $entityManager->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));
        $entityManager->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));

        $historyManager = new HistoryManager($this->api, $entityManager);

        $today = $historyManager->getToday($cityWoeid);

        $date = new \DateTime();

        $this->assertNotNull($today);
        $this->assertInstanceOf('Th3Mouk\YahooWeatherBundle\Entity\Forecast', $today);
        $this->assertTrue(is_int(intval($today->getLow())));
        $this->assertTrue(is_int(intval($today->getHigh())));
        $this->assertTrue(is_int(intval($today->getCode())));
        $this->assertSame($date->format('Y-m-d'), $today->getDate()->format('Y-m-d'));
    }
}
