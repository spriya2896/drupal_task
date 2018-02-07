<?php

namespace Drupal\first_form\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;



class CollegeDetails extends ConfigFormBase{

  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  public function getFormId(){
    return 'college_details';
  }
  
  protected function getEditableConfigNames() {
    return ['config.college_details'];
  }

  public function buildForm(array $form , FormStateInterface $form_state)
  {
  
  $config = $this->config('config.college_details');


  $form['name'] = [
  '#type' => 'textfield',
  '#title' => $this->t('College Name'),
  '#default_value' => $config->get('name') ? $config->get('name') : '',
  '#required' => TRUE,
  ];
  
  $form['email'] = [
  '#type' => 'email',
  '#title' => $this->t('Email'),
  '#default_value' => $config->get('email') ? $config->get('email') : '',
  '#required' => TRUE,
  ];

  $form['location'] = [
  '#type' => 'select',
  '#options' => [
      '0' => t('Mumbai'),
      '1' => t('Delhi'),
    ],
  '#title' => $this->t('Location'),
  '#default_value' => $config->get('location') ? $config->get('location') : '',
  '#required' => TRUE,
  ];

  return parent::buildForm($form, $form_state);
  }

    public function submitForm(array &$form, FormStateInterface $form_state){
    parent::submitForm($form, $form_state);
  
    $values = $form_state->getValues();
    
    $this->config('config.college_details')
      ->set('name', $values['name'])
      ->set('email', $values['email'])
      ->set('location', $values['location'])
      ->save();
    }
}






