<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Th3Mouk\YahooWeatherBundle\DependencyInjection\Th3MoukYahooWeatherExtension;

class Th3MoukYahooWeatherBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new Th3MoukYahooWeatherExtension();
        }

        return $this->extension;
    }
}
