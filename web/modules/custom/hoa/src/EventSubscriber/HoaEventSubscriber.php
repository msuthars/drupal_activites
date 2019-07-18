<?php

namespace Drupal\hoa\EventSubscriber;

use Drupal\Core\Url;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * HOA Event Subscriber.
 * 
 * @package \Drupal\hoa\EventSubscriber
 */
class HoaEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['onResponse'];
    return $events;
  }

  /**
   * Trigger this code on kernel.response event.
   * 
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   Filter Response Event.
   */
  public function onResponse(FilterResponseEvent $event) {
    // Add extra HTTP header.
    $current_path = Url::fromRoute('<current>');
    if (stristr($current_path->getInternalPath(), 'node')) {
      $response = $event->getResponse();
      $response->headers->set('access-control-allow-origin', '*');
    }
  }

}