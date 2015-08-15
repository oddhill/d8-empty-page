<?php

namespace Drupal\empty_page\Form;


use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\empty_page\EmptyPageManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class EmptyPageDeleteForm extends EntityConfirmFormBase {

  /**
   * @var EmptyPageManager
   */
  protected $emptyPageManager;

  /**
   * @param EmptyPageManager $emptyPageManager
   */
  function __construct(EmptyPageManager $emptyPageManager) {
    $this->emptyPageManager = $emptyPageManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('empty_page.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the empty page callback for %title?', array(
      '%title' => $this->entity->getTitle(),
    ));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('empty_page.list');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $formState) {
    $this->entity->delete();

    drupal_set_message($this->t('The empty page callback for %title has been deleted.', array(
      '%title' => $this->entity->getTitle(),
    )));

    $this->emptyPageManager->rebuildRoutes();

    $formState->setRedirectUrl($this->getCancelUrl());
  }
}