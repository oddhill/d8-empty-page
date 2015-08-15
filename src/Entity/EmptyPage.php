<?php

/**
 * @file
 * Contains \Drupal\empty_page\Entity\EmptyPage
 */

namespace Drupal\empty_page\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\empty_page\EmptyPageInterface;

/**
 * Defines the EmptyPage entity.
 *
 * @ConfigEntityType(
 *   id = "empty_page",
 *   label = @Translation("Empty Page"),
 *   handlers = {
 *     "list_builder" = "Drupal\empty_page\Controller\EmptyPageListBuilder",
 *     "form" = {
 *       "add" = "Drupal\empty_page\Form\EmptyPageForm",
 *       "edit" = "Drupal\empty_page\Form\EmptyPageForm",
 *       "delete" = "Drupal\empty_page\Form\EmptyPageDeleteForm",
 *     }
 *   },
 *   links = {
 *     "edit-form" = "/admin/config/structure/empty_page/{empty_page}",
 *     "delete-form" = "/admin/config/structure/empty_page/{empty_page}/delete",
 *     "collection" = "/admin/config/structure/empty_page",
 *   },
 *   config_prefix = "callback",
 *   admin_permission = "administer empty page callbacks",
 *   entity_keys = {
 *     "id" = "name",
 *     "label" = "title",
 *   },
 *   config_export = {
 *     "name",
 *     "title",
 *     "path",
 *   }
 * )
 */
class EmptyPage extends ConfigEntityBase implements EmptyPageInterface {

  /**
   * The machine name of the empty page.
   *
   * @var string
   */
  protected $name;

  /**
   * The title of the empty page.
   *
   * @var string
   */
  protected $title;

  /**
   * The path of the empty page callback.
   *
   * @var string
   */
  protected $path;

  /**
   * Overrides Drupal\Core\Entity\Entity::id().
   */
  public function id() {
    return $this->name;
  }

  /**
   * Get the machine name of the empty page.
   *
   * @return string
   *   The empty page name.
   */
  public function getName() {
    return $this->name;
  }

  /**
   * Get the path of the empty page.
   *
   * @return string
   *   The url path for the empty page.
   */
  public function getPath() {
    return $this->path;
  }

  /**
   * Get the title of the empty page.
   *
   * @return string
   *   The title of the empty page.
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * Set the name for the empty page.
   *
   * @param string $name
   *
   * @return string
   */
  public function setName($name) {
    $this->set('name', $name);

    return $this;
  }

  /**
   * Set the path for the empty page.
   *
   * @param string $path
   *
   * @return string
   */
  public function setPath($path) {
    $this->set('path', $path);

    return $this;
  }

  /**
   * Set the title for the empty page.
   *
   * @param string $title
   *
   * @return string
   */
  public function setTitle($title) {
    $this->set('title', $title);

    return $this;
  }
}