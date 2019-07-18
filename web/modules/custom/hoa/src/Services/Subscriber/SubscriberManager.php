<?php

namespace Drupal\hoa\Services\Subscriber;

use Drupal\Core\Database\Connection;
use Drupal\hoa\Services\Notifier\NotifierInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;

/**
 * Subscriber Manager service.
 * 
 * @package Drupal\hoa\Services\Subscriber
 */
class SubscriberManager implements SubscriberManagerInterface {

	use StringTranslationTrait;

	/**
	 * Database Connection.
	 * 
	 * @var \Drupal\Core\Database\Connection
	 */
	protected $connection;

	/**
	 * Notifier Service.
	 * 
	 * @var \Drupal\hoa\Services\Notifier\NotifierInterface
	 */
	protected $notifier;

	/**
	 * Form Data Manager Constructor.
	 * 
	 * @param \Drupal\Core\Database\Connection $connection
	 *   Database connection.
	 * @param \Drupal\hoa\Services\Notifier\NotifierInterface $notifier
	 *   Notifier Interface.
	 * @param \Drupal\Core\StringTranslation\TranslationInterface $string_translation
	 *   Translation Interface.
	 */
	public function __construct(Connection $connection, NotifierInterface $notifier, TranslationInterface $string_translation) {
		$this->connection = $connection;
		$this->notifier = $notifier;
		$this->stringTranslation = $string_translation;
	}

	/**
	 * Get Subscribers.
	 * 
	 * @return array
	 *   Subscriber List.
	 */
	public function getSubscribers() {
		$query = $this->connection->select('d8_demo', 'd8d');
		$query->fields('d8d', ['id', 'email', 'first_name', 'last_name']);
		$result = $query->execute()->fetchAllAssoc('id');
		return $result;
	}

	/**
   * Notify subscribers about new content.
   */
  public function notifySubscribers() {
		foreach ($this->getSubscribers() as $subscriber) {
			$this->notifier->notify(
				$subscriber->email,
				$this->t('New Article alert for you!'),
				$this->t('Hello @name ! A new article has been published in the domain you have subscribed for. You can visit the link below to read the article below. To unsubscribe, browse to our website, login & click on unsubscribe button!.', [
					'@name' => $subscriber->first_name
				]),
				'no-reply@blogtrottr.com'
			);
		}
	}

}