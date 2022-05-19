<?php

/**
 * @file
 * Contains timezone  Service.
 */

namespace Drupal\timezone_handler\Services;

use Drupal\Core\Config\ConfigFactoryInterface;

class TimezoneService
{

    /**
     * The config name.
     *
     * @var string
     */
    protected $configName = 'timezone_handler.timezone_handler_settings';

    /**
     * The config factory object.
     *
     * @var \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;

    /**
     * Constructs a TimezoneService object.
     *
     * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
     *   A configuration factory instance.
     */
    public function __construct(ConfigFactoryInterface $config_factory)
    {
        $this->configFactory = $config_factory;
    }

    public function getCurrentTime()
    {
        \Drupal::service('cache.render')->invalidateAll();
        $config = $this->configFactory->get($this->configName);
        $timezone = $config->get('timezone_value');
        date_default_timezone_set($timezone);
        $dateTime =  date("dS M Y - g:i A");
        return $dateTime;
    }
}
