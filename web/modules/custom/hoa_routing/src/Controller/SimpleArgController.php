<?php

namespace Drupal\hoa_routing\Controller;

use Drupal\node\NodeInterface;
/**
 * Simple Arg Controller class.
 * 
 * @package \Drupal\hoa_routing\Controller
 */
class SimpleArgController {

  /**
   * Argument in this can be added as testArgFun($arg2, $arg1)
   */
  public function testArgFun($arg1, $arg2) {
    return [
      '#markup' => 'Arg1: ' . $arg1 . ' & Arg2: ' . $arg2
    ];
  }

  public function testNodeArg(NodeInterface $node) {
    return [
      '#markup' => 'Node title: ' . $node->label(),
    ];
  }

}