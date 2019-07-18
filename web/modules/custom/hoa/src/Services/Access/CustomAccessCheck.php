<?php

namespace Drupal\hoa\Services\Access;
 
use Drupal\node\NodeInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\Access\AccessInterface;

 
/**
 * Class CustomAccessCheck.
 *
 * @package Drupal\hoa\Access
 */
class CustomAccessCheck implements AccessInterface {
 
  /**
   * Custom access check for node.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Current logged in user account.
   * @param \Drupal\code\NodeInterface $node;
   *   Node.
   * 
   * @return \Drupal\Core\Access\AccessResult
   *   The access result.
   */
  public function access(NodeInterface $node, AccountInterface $account) {
    // Check current user with node author.
    if ($account->id() == $node->uid->getString()) {
      // If the current user match with node author, give them access.
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }
 
}