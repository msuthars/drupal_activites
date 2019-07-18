<?php

namespace Drupal\hoa\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\hoa\Services\Clock\ClockManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'ClockBlock' block.
 *
 * @Block(
 *  id = "clock_block",
 *  admin_label = @Translation("Clock"),
 * )
 */
class ClockBlock extends BlockBase implements BlockPluginInterface, ContainerFactoryPluginInterface {

	/**
	 * Clock manager.
	 * 
	 * @var \Drupal\hoa\Services\Clock\ClockManager
	 */
	protected $clockManager;

	/**
	 * Clock Block constructor.
	 * 
	 * @param \Drupal\hoa\Services\Clock\ClockManager $clock_manager
	 *   Clock Manager.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, ClockManager $clock_manager) {
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->clockManager = $clock_manager;
	}

	/**
   * {@inheritdoc}
   */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static(
			$configuration,
			$plugin_id,
			$plugin_definition,
			$container->get('hoa.clock_manager')
		);
	}

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['clock_timezone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Timezone'),
      '#description' => $this->t('Time zone (i.e. UTC, EST)'),
      '#default_value' => isset($config['clock_timezone']) ? $config['clock_timezone'] : '',
		];
    return $form;
	}
	
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('clock_timezone', $form_state->getValue('clock_timezone'));
	}
	
	/**
	 * Render block data.
	 * 
	 * @return array
	 *   build data.
	 */
  public function build() {
		$config = $this->getConfiguration();
		$clock_timezone = $config['clock_timezone'];
		$clock_data = $this->clockManager->getClockDetails($clock_timezone);
		if ($clock_data['status'] == 200) {
			return [
				'#theme' => 'hoa-clock',
				'#attached' => [
					'library' => [
						'hoa/clock_block',
					],
				],
				'#clock_data' => [
					'date' => $clock_data['date'],
					'time' => $clock_data['time'],
					'timezone' => $clock_data['timeZoneName'],
				],
			];
		}
		return [
			'#markup' => $this->t('Date Time service currently not available.'),
		];
	}
	
}