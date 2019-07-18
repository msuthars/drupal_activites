<?php

namespace Drupal\hoa\Plugin\Block;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'LatestArticleBlock' block.
 *
 * @Block(
 *  id = "latest_article_block",
 *  admin_label = @Translation("Latest Article"),
 * )
 */
class LatestArticleBlock extends BlockBase implements BlockPluginInterface, ContainerFactoryPluginInterface {

	/**
	 * The Entity Type Manager.
	 * 
	 * @var \Drupal\Core\Entity\EntityTypeManagerInterface
	 */
	protected $entityTypeManager;

	/**
	 * The account.
	 * 
	 * @var \Drupal\Core\Session\AccountProxyInterface
	 */
	protected $account;

	/**
	 * Latest Article block constructor.
	 * 
	 * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
	 *   Entity Type Manager Interface.
	 * @param \Drupal\Core\Session\AccountProxyInterface $account
	 *   Entity Type Manager Interface.
	 */
	public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entity_type_manager, AccountProxyInterface $account) {
		parent::__construct($configuration, $plugin_id, $plugin_definition);
		$this->entityTypeManager = $entity_type_manager;
		$this->account = $account;
	}

	/**
   * {@inheritdoc}
   */
	public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
		return new static(
			$configuration,
			$plugin_id,
			$plugin_definition,
			$container->get('entity_type.manager'),
			$container->get('current_user')
		);
	}
	
	/**
	 * Render block data.
	 * 
	 * @return array
	 *   build data.
	 */
  public function build() {
		$query = $this->entityTypeManager->getStorage('node');
    $query_result = $query->getQuery()
      ->condition('status', 1)
			->condition('type', 'article')
			->sort('created', 'DESC')
			->range(0, 3)
			->execute();

		$article_data = $this->entityTypeManager->getStorage('node')->loadMultiple($query_result);
		$article_titles = NULL;
		foreach ($article_data as $article) {
			$article_titles[] = $article->label();
			$tags[] = 'node:' . $article->id();
		}

		$user = $this->entityTypeManager->getStorage('user')->load($this->account->id());

		return [
			'#theme' => 'hoa-article',
			'#block_data' => [
				'currentUserEmail' => $user->get('mail')->getString(),
				'article_titles' => $article_titles,
			],
			'#cache' => [
				'tags' => Cache::mergeTags(parent::getCacheTags(), $tags),
				'contexts' => Cache::mergeContexts(parent::getCacheContexts(), ['user']),
				'max-age' => Cache::PERMANENT,
			],
		];
	}
	
}