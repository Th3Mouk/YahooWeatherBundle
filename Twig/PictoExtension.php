<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Twig;

use Th3Mouk\YahooWeatherBundle\Helper\PictogramInterface;

class PictoExtension extends \Twig_Extension
{
    /**
     * @var PictogramInterface
     */
    protected $helper;

    /**
     * PictoExtension constructor.
     *
     * @param PictogramInterface $helper
     */
    public function __construct(PictogramInterface $helper)
    {
        $this->helper = $helper;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('weather_pictogram', array($this, 'getPictogram'), array(
                'is_safe' => array('html'),
            )),
        );
    }

    public function getPictogram($code)
    {
        return $this->helper->getPictogram($code);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'th3mouk_weather_pictogram_extension';
    }
}
