<?php

namespace Drupal\hoa\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\hoa\Services\Form\FormDataManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * State Demo Form.
 * 
 * @package Drupal\hoa\From
 */
class StateDemoForm extends FormBase {
	
	/**
	 * The Messenger.
	 * 
	 * @var \Drupal\Core\Messenger\MessengerInterface
	 */
	protected $messenger;

	/**
	 * The Form Data Manager.
	 * 
	 * @var \Drupal\hoa\Services\FormDataManagerInterface
	 */
	protected $formDataManager;

	/**
	 * The state.
	 * 
	 * @var \Drupal\Core\State\StateInterface
	 */
	protected $state;

	/**
	 * State Demo Form Constructor.
	 * 
	 * @param \Drupal\Core\Messenger\MessengerInterface $messenger
	 *   The messenger interface.
	 * @param \Drupal\hoa\Services\FormDataManagerInterface $form_data_manager
	 *   The Form data manager interface.
	 * @param \Drupal\Core\State\StateInterface $state
	 *   The State interface.
	 */
	public function __construct(MessengerInterface $messenger, FormDataManagerInterface $form_data_manager, StateInterface $state) {
		$this->messenger = $messenger;
		$this->formDataManager = $form_data_manager;
		$this->state = $state;
	}

	/**
   * {@inheritdoc}
   */
	public static function create(ContainerInterface $container) {
		return new static(
			$container->get('messenger'),
			$container->get('hoa.form_data_manager'),
			$container->get('state')
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
		$form['qualification'] = [
			'#type' => 'select',
			'#title' => $this->t('Qualification'),
			'#required' => TRUE,
			'#options' => [
				'ug' => 'U.G',
				'pg' => 'P.G',
				'other' => 'Other',
			],
			'#default_value' => NULL,
		];

		$form['qualification_other'] = [
			'#type' => 'textfield',
			'#title' => $this->t('If others, please specify:'),
			'#states' => [
				'visible' => [
					':input[name="qualification"]' => ['value' => 'other'],
				],
			],
		];

		$form['country'] = [
			'#type' => 'select',
			'#title' => $this->t('Country'),
			'#required' => TRUE,
			'#options' => [
				'IN' => 'India',
				'GB' => 'United Kingdom',
			],
			'#default_value' => NULL,
			'#ajax' => [
				'callback' => [$this, 'loadStatesByCountry'],
				'wrapper' => 'state_wrapper',
			],
		];

		$form['state'] = [
			'#prefix' => '<div id="state_wrapper">',
			'#suffix' => '</div>',
			'#validated' => TRUE,
			'#type' => 'select',
			'#title' => $this->t('State'),
			'#states' => [
				'visible' => [
					':input[name="country"]' => [
						['value' => 'IN'],
						['value' => 'GB'],
					],
				],
			],
		];

		$last_submission = ($this->state->get('last_state_demo_form_submit')) ? date('Y-m-d H:i:s', $this->state->get('last_state_demo_form_submit')): $this->t('Never');
		$form['last_submitted'] = [
			'#type' => 'html_tag',
			'#tag' => 'h3',
			'#value' => $this->t('Last Form Submission : ') . $last_submission, 
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
	public function validateForm(array &$form, FormStateInterface $form_state) {}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->state->set('last_state_demo_form_submit', time());
		$this->messenger->addStatus($this->t('Form successfully submitted.'));
	}

	/**
	 * Load state field according country selection.
	 * 
	 * @param array $form
	 *   Form Data.
	 * @param \Drupal\Core\Form\FormStateInterface $form_state
	 *   Form state interface.
	 * 
	 * @return array
	 *   Form data.
	 */
	public function loadStatesByCountry(array &$form, FormStateInterface $form_state) {
		$states = $this->formDataManager->getStateList();
		unset($form['state']['#options']);
		if (isset($states[$form_state->getValue('country')]) && !empty($states[$form_state->getValue('country')])) {
			$form['state']['#options'] = $states[$form_state->getValue('country')];
			return $form['state'];
		}
	}
}