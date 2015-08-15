<?php

namespace Drupal\empty_page\Form;


use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Form\FormStateInterface;
use Drupal\empty_page\EmptyPageManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EmptyPageForm extends EntityForm {

  /**
   * @var QueryFactory
   */
  protected $entityQuery;

  /**
   * @var EmptyPageManager
   */
  protected $emptyPageManager;

  /**
   * @param EmptyPageManager $emptyPageManager
   * @param QueryFactory $entityQuery
   */
  function __construct(EmptyPageManager $emptyPageManager, QueryFactory $entityQuery) {
    $this->entityQuery = $entityQuery;
    $this->emptyPageManager = $emptyPageManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('empty_page.manager'),
      $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $formState) {
    $emptyPage = $this->entity;

    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Page title'),
      '#default_value' => $emptyPage->getTitle(),
      '#required' => TRUE,
      '#description' => $this->t('Enter the page title to be used for the empty page.'),
    );

    $form['name'] = array(
      '#type' => 'machine_name',
      '#title' => $this->t('Machine name'),
      '#default_value' => $emptyPage->getName(),
      '#machine_name' => array(
        'source' => array('title'),
        'exists' => array($this, 'emptyPageExists'),
      ),
    );

    $form['path'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Path'),
      '#default_value' => $emptyPage->getPath(),
      '#required' => TRUE,
      '#description' => 'The path you wish to create an empty page for',
      '#element_validate' => array(
        array($this, 'validateUniquePathName'),
      ),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $formState) {
    $emptyPage = $this->entity;

    $status = $emptyPage->save();

    if ($status) {
      drupal_set_message($this->t('Saved the empty page callback.'));
    }
    else {
      drupal_set_message($this->t('The empty page callback was not saved.'));
    }

    $this->emptyPageManager->rebuildRoutes();

    $formState->setRedirect('empty_page.list');
  }

  /**
   * Check if a empty page exists with the supplied machine name.
   *
   * @param string $machineName
   *
   * @return bool
   */
  public function emptyPageExists($machineName) {
    $entity = $this->entityQuery->get('empty_page')
      ->condition('name', $machineName)
      ->execute();

    return (bool) $entity;
  }

  /**
   * Validate the path to make sure it does not already exist.
   *
   * @param array $element
   *   The form element to validate.
   *
   * @param FormStateInterface $formState
   *   The form state.
   */
  public function validateUniquePathName(array &$element, FormStateInterface $formState) {
    $path = $formState->getValue('path');

    // If the path is the same as the current path on the entity there is no
    // need to validate.
    if ($this->entity->getPath() === $path) {
      return;
    }

    if ($this->emptyPageManager->routeExists($path)) {
      $formState->setError($element, $this->t('A route with this path already exists.'));
    }
  }
}