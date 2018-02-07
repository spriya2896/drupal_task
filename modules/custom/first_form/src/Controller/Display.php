<?php


namespace Drupal\first_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Class Display.
 *
 * @package Drupal\my_custom\Controller
 */
class Display extends ControllerBase {

  /**
   * showdata.
   *
   * @return string
   *   Return Table format data.
   */
  public function showdata() {

// you can write your own query to fetch the data I have given my example.

    $header_table = array(
     'rollno'=>    t('Rollno'),
      'name' => t('Name'),
      'email'=>t('Email'),
      'dob' => t('Date of Birth'),
        'gender' => t('Gender'),
        'standard' => t('standard'),
        'opt' => t('Edit'),
        
    );



    $result = \Drupal::database()->select('student', 'n')
            ->fields('n', array('id','rollno', 'name', 'email' , 'dob', 'gender', 'standard'))
            ->execute()->fetchAllAssoc('rollno');
// Create the row element.
    $rows = array();
    foreach ($result as $row => $content) {
                $url = Url::fromUri('internal:/student-form/' . $content->id);
                $edit = Link::fromTextAndUrl('Edit', $url);
      $rows[] = array(
        'data' => array($content->rollno, $content->name, $content->email, $content->dob, $content->gender, $content->standard, $edit));

    }
    

    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
        return $form;
  }
}
