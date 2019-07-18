<?php

namespace Drupal\hoa\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\hoa\Services\GoogleAPI\GoogleBookManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'GoogleBookBlock' block.
 *
 * @Block(
 *  id = "google_book_block",
 *  admin_label = @Translation("Google Book"),
 * )
 */
class GoogleBookBlock extends BlockBase implements BlockPluginInterface, ContainerFactoryPluginInterface {

	/**
	 * Google book manager.
	 * 
	 * @var \Drupal\hoa\Services\GoogleAPI\GoogleBookManagerInterface
	 */
	protected $googleBookManager;

	/**
	 * Google Book Block constructor.
	 * 
	 * @param \Drupal\hoa\Services\GoogleAPI\GoogleBookManagerInterface $google_book_manager
	 *   Google Book Manager Interface.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, GoogleBookManagerInterface $google_book_manager) {
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->googleBookManager = $google_book_manager;
	}

	/**
   * {@inheritdoc}
   */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static(
			$configuration,
			$plugin_id,
			$plugin_definition,
			$container->get('hoa.google_book_manager')
		);
	}

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['google_book_isbn'] = [
      '#type' => 'textfield',
      '#title' => $this->t('ISBN'),
      '#description' => $this->t('Google Book ISBN.'),
      '#default_value' => isset($config['google_book_isbn']) ? $config['google_book_isbn'] : '',
		];
    return $form;
	}
	
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('google_book_isbn', $form_state->getValue('google_book_isbn'));
	}
	
	/**
	 * Render block data.
	 * 
	 * @return array
	 *   build data.
	 */
  public function build() {
		$config = $this->getConfiguration();
		$isbn = $config['google_book_isbn'];
		$google_book_data = $this->googleBookManager->getBookDetails($isbn);
		if (is_object($google_book_data)) {
			$build['book_container'] = [
				'#type' => 'container',
				'#attributes' => [
					'class' => ['google-book-container'],
				],
			];

			$build['book_container']['book_thumb'] = [
				'#type' => 'html_tag',
				'#tag' => 'img',
				'#attributes' => [
					'class' => ['book_thumb'],
					'src' => $google_book_data->thumbnail,
				],	
			];

			$build['book_container']['book_title'] = [
				'#type' => 'html_tag',
				'#tag' => 'label',
				'#value' => $google_book_data->title,
				'#attributes' => [
					'class' => ['book_title'],
				],	
			];

			$build['book_container']['book_subtitle'] = [
				'#type' => 'html_tag',
				'#tag' => 'p',
				'#value' => $google_book_data->subtitle,
				'#attributes' => [
					'class' => ['book_subtitle'],
				],	
			];

			return $build;
		}
		return [
			'#markup' => $this->t('Book is not found for given ISPN.'),
		];
	}
	
}