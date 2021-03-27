<?php

namespace Drupal\exsismodule\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\exsismodule\Ajax\OpenModalAjaxCommand;
use Drupal\exsismodule\Services\UserService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ExsisUserForm.
 */
class ExsisUserForm extends FormBase {

  protected UserService $userService;

  /**
   * Class constructor.
   *
   * @param \Drupal\exsismodule\Services\UserService $userService
   */
  public function __construct(UserService $userService) {
    $this->userService = $userService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('exsismodule.user'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'exsis_user_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['exsis_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Insert name.'),
      '#maxlength' => 64,
      '#size' => 64,
      '#required' => TRUE,
      '#field_suffix' => '<div class="name-validation"></div>',
    ];
    $form['exsis_identification'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Identification'),
      '#description' => $this->t('Insert identification.'),
      '#maxlength' => 64,
      '#size' => 64,
      '#required' => TRUE,
      '#field_suffix' => '<div class="identification-validation"></div>',
    ];
    $form['exsis_birthday'] = [
      '#type' => 'date',
      '#title' => $this->t('Birthday'),
      '#description' => $this->t('Insert birthday.'),
    ];
    $form['exsis_position'] = [
      '#type' => 'select',
      '#title' => $this->t('Position'),
      '#description' => $this->t('Select position.'),
      '#options' => [
        '' => $this->t('Select a position'),
        'Administrator' => $this->t('Administrator'),
        'Webmaster' => $this->t('Webmaster'),
        'Developer' => $this->t('Developer')
      ],
      '#size' => 1,
    ];
    $form['exsis_submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#attributes' => [
        'class' => ['is-disabled'],
        'disabled' => TRUE,
      ],
      '#ajax' => [
        'callback' => '::submitModalFormAjax',
        'progress' => [
          'type' => 'throbber',
          'message' => 'in progress ...',
        ],
      ],
    ];

    return $form;
  }


  /**
   * AJAX callback handler that displays any errors or a success message.
   */
  public function submitModalFormAjax(array $form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();

    $name = $form_state->getValues()['exsis_name'];
    $identification = $form_state->getValues()['exsis_identification'];
    $birthday = $form_state->getValues()['exsis_birthday'];
    $position = $form_state->getValues()['exsis_position'];
    $status = $position == 'Administrator' ? 1 : 0;

    if($name == '') {
      $msg_strlen = '<label class="error">The name is required</label>';
      $response->addCommand(new HtmlCommand('.name-validation', $msg_strlen));
    }

    if($name == '') {
      $msg_strlen = '<label class="error">The identification is required</label>';
      $response->addCommand(new HtmlCommand('.identification-validation', $msg_strlen));
    }

    if (!preg_match('/^[a-zA-Z0-9]*$/', $name)) {
      $msg_strlen = '<label class="error">The name must only be made up of alphanumeric characters</label>';
      $response->addCommand(new HtmlCommand('.name-validation', $msg_strlen));

      return $response;
    }
    if (!preg_match('/^[0-9]*$/', $identification)) {
      $msg_unique = '<label class="error">The identifier must only be composed of numeric characters</label>';
      $response->addCommand(new HtmlCommand('.identification-validation', $msg_unique));

      return $response;
    }

        try {

          $user = $this->userService->saveUser($name, $identification, $birthday, $position, $status);
        }
        catch (\Exception $e) {
          \Drupal::messenger()->addMessage('The name could not be saved. Try again');
        }
    //
        if ((!$form_state->hasAnyErrors() || empty($form_state->getErrors())) && !empty($user)) {
          $response->addCommand(new InvokeCommand('#edit-exsis-name', 'val', ['']));
          $response->addCommand(new InvokeCommand('#edit-exsis-identification', 'val', ['']));
          $response->addCommand(new InvokeCommand('#edit-exsis-birthday', 'val', ['']));
          $response->addCommand(new InvokeCommand('#edit-exsis-position', 'val', ['']));
          $response->addCommand(new openModalAjaxCommand($name, $identification, $birthday, $position, $status));
        }

    return $response;
  }



  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }

}
