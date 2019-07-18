<?php

namespace Drupal\hoa\Event;

use Drupal\Core\Entity\EntityInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Hoa Custom Event.
 * 
 * @package \Drupal\hoa\Event
 */
class HoaCustomEvent extends Event {

  const NODE_INSERT = 'node.insert';

  /**
   * Node entity.
   *
   * @var \Drupal\Core\Entity\EntityInterface
   */
  protected $entity;

  /**
   * Hoa Custom Event Constructor.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The Entity.
   */
  public function __construct(EntityInterface $entity) {
    $this->entity = $entity;
  }

  /**
   * Get inserted entity.
   * 
   * @return \Drupal\Core\Entity\EntityInterface
   *   Return Entity.
   */
  public function getEntity() {
    return $this->entity;
  }

}