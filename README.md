Yahoo Weather Bundle
====================

This [Symfony](http://symfony.com/) bundle providing communication and historian of [Yahoo Weather API](https://developer.yahoo.com/weather/).

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/83b59961-89a2-47a0-8496-67eea3294b6f/mini.png)](https://insight.sensiolabs.com/projects/83b59961-89a2-47a0-8496-67eea3294b6f) [![Latest Stable Version](https://poser.pugx.org/th3mouk/yahoo-weather-bundle/v/stable)](https://packagist.org/packages/th3mouk/yahoo-weather-bundle) [![Total Downloads](https://poser.pugx.org/th3mouk/yahoo-weather-bundle/downloads)](https://packagist.org/packages/th3mouk/yahoo-weather-bundle) [![Latest Unstable Version](https://poser.pugx.org/th3mouk/yahoo-weather-bundle/v/unstable)](https://packagist.org/packages/th3mouk/yahoo-weather-bundle) [![License](https://poser.pugx.org/th3mouk/yahoo-weather-bundle/license)](https://packagist.org/packages/th3mouk/yahoo-weather-bundle)

## Installation

`composer require th3mouk/yahoo-weather-bundle ^1.0@dev`

Add to the `appKernel.php`:

```php
// Weather Bundle
new Th3Mouk\YahooWeatherBundle\Th3MoukYahooWeatherBundle(),
```

Full configuration of `config.yml`

```yml
th3mouk_yahoo_weather:
    templates:
        today:     Th3MoukYahooWeatherBundle:Default:today.html.twig
        forecast:  Th3MoukYahooWeatherBundle:Default:forecast.html.twig
            
    pictograms:
        helper: ImplementsYourOwn
        extension: Th3Mouk\YahooWeatherBundle\Twig\PictoExtension
```

## Usage

This bundle provides two entities: `Th3Mouk\YahooWeatherBundle\Entity\City` and `Th3Mouk\YahooWeatherBundle\Entity\Forecast`.

The first one is relative to communication with the API, city object must have the name of the city like in the Yahoo Weather Documentation, or a WOEID code.
The second is for data persistence and history retrieve.

Extends them or feel free to hack it !

### Twig Extensions

#### Weather

You have two extensions to draw the forecasts, they use templates defined in configuration.
Feel free to to implements or add your own !

```twig
{{ weather_forecast(city, unit = 'c') }}
{{ weather_today(city, unit = 'c') }}
```

#### Icons

You can add a pictogram helper in the configuration that activate this extension, that must implement `Th3Mouk\YahooWeatherBundle\Helper\PictogramInterface`.
```twig
{{ code|weather_pictogram }}
```

This is an exemple of PictogramHelper :

```php
namespace AppBundle\Helper;

use Th3Mouk\YahooWeatherBundle\Helper\PictogramInterface;

class WeatherPictogramHelper implements PictogramInterface
{
    /**
     * Function that retrieve the html string corresponding to a weather code.
     *
     * @param $code
     *
     * @return string|null
     */
    public function getPictogram($code)
    {
        return "<img src='favicon.ico'/>";
    }
}
```

### Sonata Integration Exemple

This bundle automatically provide an administration for cities.

The service is named `th3mouk_yahoo_weather.admin.city`.

```yml
th3mouk_yahoo_weather.admin.city:
    class: Th3Mouk\YahooWeatherBundle\Admin\CityAdmin
    arguments: [~, Th3Mouk\YahooWeatherBundle\Entity\City, SonataAdminBundle:CRUD]
    tags:
        - {name: sonata.admin, manager_type: orm, group: weather, label: city}
```

Add the admin group on the dashboard:

```yml
sonata.admin.group.weather:
    label:           weather
    label_catalogue: messages
    icon:            '<i class="fa fa-sun-o"></i>'
    items:
        - th3mouk_yahoo_weather.admin.city
    roles: [ ROLE_ADMIN ]
```

Don't forget to add this group on a block:
```yml
sonata_admin:
    dashboard:
        blocks:
            - { position: left, type: sonata.admin.block.admin_list, settings: { groups: [...sonata.admin.group.weather...] }}
```

You're done! :+1:

## TODO

- Add template option on weather twig extension
- Add today forecast without city object
- Remove sonata configuration in the bundle
- Add weather extension configuration
- Add twig extension of history
- Add twig extension for comparison of weather (today and Y-1)
- Add twig extension for comparison of weather (forecast and Y-1)

## Please

Feel free to improve this bundle.
