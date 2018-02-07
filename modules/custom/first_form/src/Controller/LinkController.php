

<?php

namespace Drupal\first_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;

class LinkController extends ControllerBase {

 /**
  * Display markup.
  *
  * @return array
  */
 public function content($first) {
   $current_path = \Drupal::service('path.current')->getPath();
   /*print '<pre>'; print_r($current_path); print '</pre>';*/
   $path_args = explode('/', $current_path);
   /*print '<pre>'; print_r($path_args); print '</pre>';*/
   $id = $path_args[2];
   $data = getData($id);

   //print '<pre>'; print_r($data); print '</pre>';exit;
   $form = \Drupal::formBuilder()->getForm('Drupal\first_form\Form\StudentDetails', $data);
   //print '<pre>'; print_r($form); print '</pre>';exit;
   return $form;
   // return [
   //   '#markup' => $id
   // ];
 } 
}