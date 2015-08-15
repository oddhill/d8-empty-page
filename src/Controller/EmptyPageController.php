<?php namespace Drupal\empty_page\Controller;

use Drupal\Core\Controller\ControllerBase;

class EmptyPageController extends ControllerBase {

  /**
   * Empty page callback.
   *
   * @return array
   */
  public function callback() {
    return array();
  }
}
