<?php

namespace Drupal\first_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;


class StudentDetails extends FormBase
{
  public function getFormId()
  {
    return 'student_details';
  }

  public function buildForm(array $form , FormStateInterface $form_state , $data=NULL)
  {
  
  $form['rollno'] = [
  '#type' => 'textfield',
  '#title' => $this->t('RollNO'),
  '#required' => TRUE,
  '#default_value' => $data[0]->rollno ? $data[0]->rollno : '',
  ];

  $form['name'] = [
  '#type' => 'textfield',
  '#title' => $this->t('Name'),
  '#required' => TRUE,
  '#default_value' => $data[0]->name ? $data[0]->name : '',
  ];
  
  $form['email'] = [
  '#type' => 'email',
  '#title' => $this->t('Email'),
  '#required' => TRUE,
  '#default_value' => $data[0]->email ? $data[0]->email : '',
  ];

  $form['dob'] = [
  '#type' => 'date',
  '#title' => $this->t('Date of Birth'),
  '#default_value' => $data[0]->dob ? $data[0]->dob : '',
  '#required' => TRUE,
  ];
  
  $form['gender'] = [
  '#type' => 'select',
  '#title' => $this->t('Gender'),
  '#options' => [
      '0' => t('Male'),
      '1' => t('Female'),
    ],
  '#required' => TRUE,
  '#default_value' => $data[0]->gender ? $data[0]->gender : '',
  ];

 

  $form['standard'] = [
  '#type' => 'select',
  '#title' => $this->t('Standard'),
  '#options' => [
      '1' => t('1'),
      '2' => t('2'),
      '3' => t('3'),
      '4' => t('4'),
      '5' => t('5'),
    ],
  '#default_value' => $data[0]->standard ? $data[0]->standard : '',  
  '#required' => TRUE,
  ];

  $form['submit'] = [
  '#type' => 'submit',
  '#value' => $this->t('Save Student Details'),
  '#attribute' => [
    'class' => 'btn',
    ],
  ];
   return $form;
  }
  
  //validation of date of birth

  public function validateForm(array &$form, FormStateInterface $form_state)
  {
  	parent::validateForm($form , $form_state);
  	if(date('Y-m-d') < $form_state->getValue('dob'))
      {
  	  	$form_state->setErrorByName('dob' , $this->t('Date should be less than current date.'));
  	  }
      if(!is_numeric($form_state->getValue('rollno')))
      {
       $form_state->setErrorByName('rollno' , $this->t('Roll no should be number.')); 
      }

      
  }
 
  public function submitForm(array &$form, FormStateInterface $form_state , $data=NULL)
    {
    $values = $form_state->getValue();
    
    //creating connection
    $connection = Database::getConnection();
    $connection ->insert('student')->fields(
    	[
         'rollno' => $values['rollno'],
         'name' => $values['name'],
         'email' => $values['email'],
         'dob' => strtotime($values['dob']),
         'gender' => $values['gender'],
         'standard' => $values['standard'],
    	]
        )->execute();


   }

}






