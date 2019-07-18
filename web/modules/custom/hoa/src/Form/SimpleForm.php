<?php

namespace Drupal\hoa\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Simple Form
 * 
 * @package Drupal\hoa\Form
 */
class SimpleForm extends FormBase {

	/**
	 * The Messenger.
	 * 
	 * @var \Drupal\Core\Messenger\MessengerInterface
	 */
	protected $messenger;

	/**
	 * Simple Form Constructor.
	 * 
	 * @param \Drupal\Core\Messenger\MessengerInterface $messenger
	 *   The messenger interface.
	 */
	public function __construct(MessengerInterface $messenger) {
		$this->messenger = $messenger;
	}

	/**
   * {@inheritdoc}
   */
	public static function create(ContainerInterface $container) {
		return new static(
			$container->get('messenger')
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFormId() {
		return 'simple_form';
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {
		$form['name'] = [
			'#type' => 'textfield',
			'#required' => TRUE,
			'#attributes' => [
				'placeholder' => $this->t('Your Name'),
			],
		];

		$form['form_submit'] = [
			'#type' => 'submit',
			'#value' => $this->t('Submit'),
		];

		return $form;
	}

	/**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
		if (strlen($form_state->getValue('name')) < 5) {
			$form_state->setErrorByName('name', $this->t('Minimum Name length should be 5 character.'));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->messenger->addStatus($form_state->getValue('name'));
	}

}