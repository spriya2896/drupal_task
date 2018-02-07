<?php

namespace Drupal\menu_item_role_access;

use Drupal\Core\Menu\DefaultMenuLinkTreeManipulators;
use Drupal\Core\Menu\MenuLinkInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\menu_link_content\Entity\MenuLinkContent;

/**
 * Defines the access control handler for the menu item.
 */
class MenuItemRoleAccessLinkTreeManipulator extends DefaultMenuLinkTreeManipulators {

  /**
   * Checks access for one menu link instance.
   *
   * This function adds to the checks provided by
   * DefaultMenuLinkTreeManipulators to allow us to check any roles which
   * have been added to a menu item to allow or deny access.
   *
   * @param \Drupal\Core\Menu\MenuLinkInterface $instance
   *   The menu link instance.
   *
   * @return \Drupal\Core\Access\AccessResult
   *   The access result.
   */
  protected function menuLinkCheckAccess(MenuLinkInterface $instance) {
    $access_result = parent::menuLinkCheckAccess($instance);
    if (!$this->account->hasPermission('link to any page')) {
      $url = $instance->getUrlObject();
      $metadata = $instance->getMetaData();
      // When no route name is specified, this must be an external link.
      if (!$url->isRouted() && isset($metadata['entity_id'])) {
        // Load the entity of the menu item so we can get the roles.
        $menu_link_item = MenuLinkContent::load($metadata['entity_id']);
        // Now make sure the module has been enabled and installed correctly.
        if ($menu_link_item->hasField('menu_item_roles')) {
          $allowed_roles = $menu_link_item->menu_item_roles->getValue();
          if (!empty($allowed_roles)) {
            // Set the access result as forbidden in case the user does not
            // have a role required.
            $access_result = AccessResult::forbidden();

            // Find out about our users roles.
            $users_roles = \Drupal::currentUser()->getRoles();

            // Check to see if the user has any roles that we have allowed.
            foreach ($allowed_roles as $role) {
              if (in_array($role['target_id'], $users_roles)) {
                $access_result = AccessResult::allowed();
              }
            }
          }
        }
      }
    }

    return $access_result->cachePerPermissions();
  }

}
