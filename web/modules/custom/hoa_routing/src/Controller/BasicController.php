<?php

namespace Drupal\hoa_routing\Controller;

use Symfony\Component\Routing\Route;

/**
 * Basic Controller class.
 * 
 * @package \Drupal\hoa_routing\Controller
 */
class BasicController {

  public function testPage() {
    return [
      '#markup' => 'This is Basic Routing Example.'
    ];
  }

  public function routes() {
    $routes['hoa_routing.dynamic_route_1'] = new Route(
      '/dynamic-route-1/{arg1}',
      [
        '_controller' => '\Drupal\hoa_routing\Controller\BasicController::testArgPage',
        '_title' => 'Test Page',
      ],
      [
        '_permission' => 'access content',
      ]
    );
    return $routes;
  }

  public function testArgPage($arg1) {
    return [
      '#markup' => 'ARG1: ' . $arg1
    ];
  }


}