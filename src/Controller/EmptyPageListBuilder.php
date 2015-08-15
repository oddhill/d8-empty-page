<?php

/**
 * @file
 * Contains Drupal\empty_page\Controller\EmptyPageListBuilder.
 */

namespace Drupal\empty_page\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

class EmptyPageListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $build['table']['#empty'] = $this->t('There are no empty page callbacks yet.');

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = array(
      'title' => array(
        'data' => $this->t('Page title'),
      ),
      'name' => array(
        'data' => $this->t('Machine name'),
      ),
      'path' => array(
        'data' => $this->t('Path'),
      ),
      'operations' => array(
        'data' => $this->t('Operations'),
      ),
    );

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $links = array(
      'edit' => array(
        'title' => t('Edit'),
        'url' => Url::fromRoute('entity.empty_page.edit_form', [
          'empty_page' => $entity->getName(),
        ]),
      ),
      'delete' => array(
        'title' => t('Delete'),
        'url' => Url::fromRoute('entity.empty_page.delete_form', [
          'empty_page' => $entity->getName(),
        ]),
      ),
    );

    $row = array(
      'title' => array(
        'data' => $entity->getTitle(),
      ),
      'name' => array(
        'data' => $entity->getName(),
      ),
      'path' => array(
        'data' => array(
          '#type' => 'link',
          '#title' => $entity->getPath(),
          '#url' => Url::fromUri('base://' . $entity->getPath()),
          '#options' => array(
            'html' => TRUE,
          ),
        ),
      ),
      'operations' => array(
        'data' => array(
          '#type' => 'operations',
          '#links' => $links,
        ),
      ),
    );

    return $row + parent::buildRow($entity);
  }
}