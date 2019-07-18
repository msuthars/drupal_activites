<?php

namespace Drupal\hoa\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\hoa\Services\Weather\WeatherManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'WeatherBlock' block.
 *
 * @Block(
 *  id = "weather_block",
 *  admin_label = @Translation("Weather Service"),
 * )
 */
class WeatherBlock extends BlockBase implements BlockPluginInterface, ContainerFactoryPluginInterface {

	/**
	 * Weather manager.
	 * 
	 * @var \Drupal\hoa\Services\Weather\WeatherManagerInterface
	 */
	protected $weatherManager;

	/**
	 * Weather Block constructor.
	 * 
	 * @param \Drupal\hoa\Services\Weather\WeatherManagerInterface $weather_manager
	 *   Weather Manager Interface.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, WeatherManagerInterface $weather_manager) {
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->weatherManager = $weather_manager;
	}

	/**
   * {@inheritdoc}
   */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static(
			$configuration,
			$plugin_id,
			$plugin_definition,
			$container->get('hoa.weather_manager')
		);
	}

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['city_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City Name'),
      '#description' => $this->t('Name of the city for the weather details.'),
      '#default_value' => isset($config['city_name']) ? $config['city_name'] : '',
		];
    return $form;
	}
	
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('city_name', $form_state->getValue('city_name'));
	}
	
	/**
	 * Render block data.
	 * 
	 * @return array
	 *   build data.
	 */
  public function build() {
		$config = $this->getConfiguration();
		$city_name = $config['city_name'];
		$weather_data = $this->weatherManager->getWeatherDetails($city_name);
		if ($weather_data['status'] == 200) {
			return [
				'#theme' => 'hoa-template',
				'#attached' => [
					'library' => [
						'hoa/weather_block',
					],
				],
				'#weather_data' => [
					'city' => $city_name,
					'temp_min' => $weather_data['main']['temp_min'],
					'temp_max' => $weather_data['main']['temp_max'],
					'pressure' => $weather_data['main']['pressure'],
					'humidity' => $weather_data['main']['humidity'],
					'wind' => [
						'speed' => $weather_data['wind']['speed'],
					],
				],
			];
		}
		return [
			'#markup' => $this->t('Weather service currently not available.'),
		];
	}
	
}