<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forecast.
 *
 * @ORM\Table("weather__forecast")
 * @ORM\Entity(repositoryClass="Th3Mouk\YahooWeatherBundle\Entity\ForecastRepository")
 */
class Forecast
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=3)
     */
    private $code;

    /**
     * @var int
     *
     * @ORM\Column(name="low", type="integer")
     */
    private $low;

    /**
     * @var int
     *
     * @ORM\Column(name="high", type="integer")
     */
    private $high;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=1)
     */
    private $unit = 'c';

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Forecast
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set low.
     *
     * @param int $low
     *
     * @return Forecast
     */
    public function setLow($low)
    {
        $this->low = $low;

        return $this;
    }

    /**
     * Get low.
     *
     * @return int
     */
    public function getLow()
    {
        return $this->low;
    }

    /**
     * Set high.
     *
     * @param int $high
     *
     * @return Forecast
     */
    public function setHigh($high)
    {
        $this->high = $high;

        return $this;
    }

    /**
     * Get high.
     *
     * @return int
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * Set text.
     *
     * @param string $text
     *
     * @return Forecast
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Forecast
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set unit.
     *
     * @param string $unit
     *
     * @return Forecast
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit.
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set city.
     *
     * @param \Th3Mouk\YahooWeatherBundle\Entity\City $city
     *
     * @return Forecast
     */
    public function setCity(\Th3Mouk\YahooWeatherBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return \Th3Mouk\YahooWeatherBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }
}
