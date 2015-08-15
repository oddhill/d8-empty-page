<?php namespace Drupal\empty_page;

use Drupal\Core\Routing\RouteBuilderInterface;
use Drupal\Core\Routing\RouteProviderInterface;

/**
 * @file
 */

class EmptyPageManager {

  /**
   * @var \Drupal\Core\Routing\RouteProviderInterface
   */
  private $routeProvider;

  /**
   * @var \Drupal\Core\Routing\RouteBuilder
   */
  private $routeBuilder;

  /**
   * @param \Drupal\Core\Routing\RouteProviderInterface $routeProvider
   * @param \Drupal\Core\Routing\RouteBuilderInterface $routeBuilder
   */
  function __construct(RouteProviderInterface $routeProvider, RouteBuilderInterface $routeBuilder) {
    $this->routeBuilder = $routeBuilder;
    $this->routeProvider = $routeProvider;
  }

  /**
   * Check if a route with the given path exists.
   *
   * @param  string $path
   * @return int
   */
  public function routeExists($path) {
    return $this->routeProvider->getRoutesByPattern('/' . $path)->count();
  }

  /**
   * Run the Drupal route rebuild.
   */
  public function rebuildRoutes() {
    $this->routeBuilder->rebuild();
  }
}
