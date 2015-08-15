<?php

/**
 * @file
 * Contains \Drupal\empty_page\EmptyPageInterface.
 */

namespace Drupal\empty_page;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

interface EmptyPageInterface extends ConfigEntityInterface {

  /**
   * Get the machine name of the empty page.
   *
   * @return string
   *   The empty page name.
   */
  public function getName();

  /**
   * Get the path of the empty page.
   *
   * @return string
   *   The url path for the empty page.
   */
  public function getPath();

  /**
   * Get the title of the empty page.
   *
   * @return string
   *   The title of the empty page.
   */
  public function getTitle();

  /**
   * Set the name for the empty page.
   *
   * @param string $name
   *
   * @return string
   */
  public function setName($name);

  /**
   * Set the path for the empty page.
   *
   * @param string $path
   *
   * @return string
   */
  public function setPath($path);

  /**
   * Set the title for the empty page.
   *
   * @param string $title
   *
   * @return string
   */
  public function setTitle($title);
}