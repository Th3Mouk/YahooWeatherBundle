<?php

/*
 * (c) Jérémy Marodon <marodon.jeremy@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Th3Mouk\YahooWeatherBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateWeatherCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('weather:update')
            ->setDescription('Update all the forecasts of cities in database. Be careful with the limit API.')
            ->addArgument(
                'unit',
                InputArgument::OPTIONAL,
                'Celsius (c) by default or Fahrenheit (f)'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $unit = $input->getArgument('unit');

        if (!$unit || !in_array($unit, array('c', 'f'))) {
            $unit = 'c';
        }

        $this->getContainer()->get('th3mouk_yahoo_weather.history.manager')->updateAllCitiesForecast($unit);

        $output->writeln('<info>Roger Over</info>');
    }
}
