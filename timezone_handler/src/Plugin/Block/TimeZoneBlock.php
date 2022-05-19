<?php

/**
 * @file
 * Contains timezone  block.
 */

namespace Drupal\timezone_handler\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'TimeZoneBlock' block.
 *
 * @Block(
 *  id = "time_zone_block",
 *  admin_label = @Translation("Time zone block"),
 * )
 */
class TimeZoneBlock extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * Drupal\timezone_handler\Services\TimezoneService definition.
     *
     * @var \Drupal\timezone_handler\Services\TimezoneService
     */
    protected $timezoneHandlerTimezoneService;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        $instance = new static($configuration, $plugin_id, $plugin_definition);
        $instance->timezoneHandlerTimezoneService = $container->get('timezone_handler.timezone_service');
        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
      $timezone_config = \Drupal::config('timezone_handler.timezone_handler_settings');
      $country =  $timezone_config->get('country');
      $city =  $timezone_config->get('city');
      $timezone =  $timezone_config->get('timezone_value');
      $time = $this->timezoneHandlerTimezoneService->getCurrentTime();
      $build = [];
      $build['#theme'] = 'time_zone_block';
      $build['#content'] = array('country' => $country,'city' => $city, 'time' => $time);
      return $build;
    }
}
