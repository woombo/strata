<?php

declare(strict_types=1);

namespace Drupal\strata_base\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Helper service for Strata permissions.
 */
class StrataPermissionHelper {

  /**
   * The current user.
   */
  protected AccountInterface $currentUser;

  /**
   * The entity type manager.
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * Constructs a StrataPermissionHelper object.
   */
  public function __construct(
    AccountInterface $current_user,
    EntityTypeManagerInterface $entity_type_manager
  ) {
    $this->currentUser = $current_user;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * Checks if user can access Strata functionality.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return bool
   *   TRUE if user has Strata access.
   */
  public function hasStrataAccess(?AccountInterface $account = NULL): bool {
    $account = $account ?: $this->currentUser;
    
    $strata_roles = [
      'strata_admin',
      'strata_manager',
      'strata_council',
      'strata_staff',
      'strata_resident',
    ];

    foreach ($strata_roles as $role) {
      if ($account->hasRole($role)) {
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * Checks if user can manage building information.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return bool
   *   TRUE if user can manage building info.
   */
  public function canManageBuilding(?AccountInterface $account = NULL): bool {
    $account = $account ?: $this->currentUser;
    
    return $account->hasRole('strata_admin') || 
           $account->hasRole('strata_manager');
  }

  /**
   * Checks if user can manage finances.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return bool
   *   TRUE if user can manage finances.
   */
  public function canManageFinances(?AccountInterface $account = NULL): bool {
    $account = $account ?: $this->currentUser;
    
    return $account->hasRole('strata_admin') || 
           $account->hasRole('strata_manager');
  }

  /**
   * Checks if user can manage maintenance.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return bool
   *   TRUE if user can manage maintenance.
   */
  public function canManageMaintenance(?AccountInterface $account = NULL): bool {
    $account = $account ?: $this->currentUser;
    
    return $account->hasRole('strata_admin') || 
           $account->hasRole('strata_manager') ||
           $account->hasRole('strata_staff');
  }

  /**
   * Checks if user can view reports.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return bool
   *   TRUE if user can view reports.
   */
  public function canViewReports(?AccountInterface $account = NULL): bool {
    $account = $account ?: $this->currentUser;
    
    return $account->hasRole('strata_admin') || 
           $account->hasRole('strata_manager') ||
           $account->hasRole('strata_council') ||
           $account->hasRole('strata_staff');
  }

  /**
   * Checks if user can manage meetings.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return bool
   *   TRUE if user can manage meetings.
   */
  public function canManageMeetings(?AccountInterface $account = NULL): bool {
    $account = $account ?: $this->currentUser;
    
    return $account->hasRole('strata_admin') || 
           $account->hasRole('strata_manager') ||
           $account->hasRole('strata_council');
  }

  /**
   * Checks if user can communicate with residents.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return bool
   *   TRUE if user can communicate with residents.
   */
  public function canManageCommunications(?AccountInterface $account = NULL): bool {
    $account = $account ?: $this->currentUser;
    
    return $account->hasRole('strata_admin') || 
           $account->hasRole('strata_manager') ||
           $account->hasRole('strata_council');
  }

  /**
   * Gets permissions for a specific role.
   *
   * @param string $role_id
   *   The role ID.
   *
   * @return array
   *   Array of permission names.
   */
  public function getRolePermissions(string $role_id): array {
    $role_storage = $this->entityTypeManager->getStorage('user_role');
    $role = $role_storage->load($role_id);
    
    if (!$role) {
      return [];
    }
    
    return $role->getPermissions();
  }

}