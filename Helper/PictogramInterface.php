<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Helper;

interface PictogramInterface
{
    /**
     * Function that retrieve the html string corresponding to a weather code.
     *
     * @param $code
     *
     * @return string|null
     */
    public function getPictogram($code);
}
