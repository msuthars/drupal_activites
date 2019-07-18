<?php

namespace Drupal\hoa\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ApiSiteInformationForm extends SiteInformationForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $site_config = $this->config('system.site');
    $form =  parent::buildForm($form, $form_state);
    $form['site_information']['apikey'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Key'),
      '#default_value' => ($site_config->get('apikey')) ? $site_config->get('apikey') : '',
    ];

    $form['actions']['submit']['#value'] = $this->t('Submit');
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('system.site')
    ->set('apikey', $form_state->getValue('apikey'))
    ->save();
    parent::submitForm($form, $form_state);
  }
}