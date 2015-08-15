<?php namespace Drupal\empty_page\Routing;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\empty_page\EmptyPageManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CallbackRoutes implements ContainerInjectionInterface {

  /**
   * The empty page storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $emptyPageStorage;

  /**
   * @var EmptyPageManager
   */
  protected $manager;

  /**
   * Construct.
   *
   * @param EntityManagerInterface $entityManager
   * @param EmptyPageManager $manager
   */
  function __construct(EntityManagerInterface $entityManager, EmptyPageManager $manager) {
    $this->emptyPageStorage = $entityManager->getStorage('empty_page');
    $this->manager = $manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager'),
      $container->get('empty_page.manager')
    );
  }

  /**
   * Dynamically defines each route added.
   *
   * @return RouteCollection
   */
  public function routes() {
    $collection = new RouteCollection();

    // Get all the empty page callbacks.
    $callbackRoutes = $this->emptyPageStorage->loadMultiple();

    // Loop over all callbacks and create a new route for each callback.
    foreach ($callbackRoutes as $route) {

      // Route defaults.
      $defaults = array(
        '_controller' => '\Drupal\empty_page\Controller\EmptyPageController::callback',
        '_title' => $route->getTitle(),
      );

      // Route requirements.
      $requirements = array(
        '_permission' => 'access content',
      );

      $collection->add('empty_page.' . $route->getName(), new Route($route->getPath(), $defaults, $requirements));
    }

    return $collection;
  }
}
