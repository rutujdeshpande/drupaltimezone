<?php

namespace Drupal\timezone_handler\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class TimezoneConfigForm extends ConfigFormBase
{

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'timezone_handler_settings';
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return [
        'timezone_handler.timezone_handler_settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('timezone_handler.timezone_handler_settings');
        $timezone_options = array("America/Chicago" , "America/New_York" , "Asia/Tokyo" , "Asia/Dubai" , "Asia/Kolkata", "Europe/Amsterdam", "Europe/Oslo", "Europe/London");
        $form['country'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Country'),
        '#default_value' => $config->get('country'),
        );
        $form['city'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('City'),
        '#default_value' => $config->get('city'),
        );
        $form['timezone'] = array(
        '#weight' => '1',
        '#type' => 'select',
        '#options' => $timezone_options,
        '#title' => 'Timezone',
        '#default_value' => $config->get('timezone'),
        );
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $timezone_value = $form['timezone']['#options'][$form_state->getValue('timezone')];
        $this->config('timezone_handler.timezone_handler_settings')
            ->set('country', $form_state->getValue('country'))
            ->set('city', $form_state->getValue('city'))
            ->set('timezone_value', $timezone_value)
            ->set('timezone', $form_state->getValue('timezone'))
            ->save();
        parent::submitForm($form, $form_state);
    }

}
