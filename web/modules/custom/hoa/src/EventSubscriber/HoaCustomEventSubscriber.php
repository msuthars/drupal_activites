<?php

namespace Drupal\hoa\EventSubscriber;

use Drupal\Core\Url;
use Drupal\hoa\Event\HoaCustomEvent;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * HOA Custom Event Subscriber.
 * 
 * @package \Drupal\hoa\EventSubscriber
 */
class HoaCustomEventSubscriber implements EventSubscriberInterface {

  /**
   * The logger.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  protected $logger;

  /**
   * The HOA Custom Event Subscriber Constructor.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger
   *   The logger channel factory interface.
   */
  public function __construct(LoggerChannelFactoryInterface $logger) {
    $this->logger = $logger->get('hoa');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[HoaCustomEvent::NODE_INSERT][] = ['onEntityInsert'];
    return $events;
  }

  /**
   * Trigger this code on node.insert event.
   * 
   * @param \Drupal\hoa\Event\HoaCustomEvent $event
   *   Hoa Custom Event.
   */
  public function onEntityInsert(HoaCustomEvent $event) {
    $entity = $event->getEntity();
    $this->logger->info('New node @node_title inserted.', [
      '@node_title' => $entity->label(),
    ]);
  }

}