<?php

namespace Drupal\hoa\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Email Config Form.
 * 
 * @package Drupal\hoa\Form
 */
class EmailConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'email_config_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'hoa.email_configuration',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
		$config = $this->config('hoa.email_configuration');
    $form['emails'] = [
      '#type' => 'textfield',
			'#title' => $this->t('Email Addresses'),
      '#required' => TRUE,
      '#attributes' => [
        'placeholder' => $this->t('email1,email2,email3....'),
      ],
      '#default_value' => implode(',', $config->get('emails')),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('hoa.email_configuration')
      ->set('emails', explode(',', trim($form_state->getValue('emails'))))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
