<?php

declare(strict_types=1);

namespace Drupal\strata_base\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\UserInterface;

/**
 * Utility service for common Strata functionality.
 */
class StrataUtilityService {

  /**
   * The entity type manager.
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * The current user.
   */
  protected AccountInterface $currentUser;

  /**
   * The logger channel.
   */
  protected LoggerChannelInterface $logger;

  /**
   * Constructs a StrataUtilityService object.
   */
  public function __construct(
    EntityTypeManagerInterface $entity_type_manager,
    AccountInterface $current_user,
    LoggerChannelFactoryInterface $logger_factory
  ) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
    $this->logger = $logger_factory->get('strata_base');
  }

  /**
   * Gets all available Strata roles.
   *
   * @return array
   *   Array of role IDs.
   */
  public function getStrataRoles(): array {
    return [
      'strata_admin',
      'strata_manager',
      'strata_council',
      'strata_staff',
      'strata_resident',
    ];
  }

  /**
   * Checks if user has any Strata role.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return bool
   *   TRUE if user has any Strata role.
   */
  public function userHasStrataRole(?AccountInterface $account = NULL): bool {
    $account = $account ?: $this->currentUser;
    $strata_roles = $this->getStrataRoles();

    foreach ($strata_roles as $role) {
      if ($account->hasRole($role)) {
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * Gets user's primary Strata role.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return string|null
   *   The primary role ID, or NULL if none found.
   */
  public function getUserPrimaryStrataRole(?AccountInterface $account = NULL): ?string {
    $account = $account ?: $this->currentUser;
    
    // Role hierarchy (highest to lowest priority)
    $role_hierarchy = [
      'strata_admin',
      'strata_manager',
      'strata_council',
      'strata_staff',
      'strata_resident',
    ];

    foreach ($role_hierarchy as $role_id) {
      if ($account->hasRole($role_id)) {
        return $role_id;
      }
    }

    return NULL;
  }

  /**
   * Gets user's Strata role label.
   *
   * @param \Drupal\Core\Session\AccountInterface|null $account
   *   The user account, or NULL for current user.
   *
   * @return string|null
   *   The role label, or NULL if none found.
   */
  public function getUserStrataRoleLabel(?AccountInterface $account = NULL): ?string {
    $role_id = $this->getUserPrimaryStrataRole($account);
    
    if (!$role_id) {
      return NULL;
    }

    $role_labels = [
      'strata_admin' => 'Admin',
      'strata_manager' => 'Manager',
      'strata_council' => 'Council Member',
      'strata_staff' => 'Staff',
      'strata_resident' => 'Resident',
    ];

    return $role_labels[$role_id] ?? NULL;
  }

  /**
   * Checks if current user can manage entity.
   *
   * @param string $entity_type
   *   The entity type.
   * @param mixed $entity
   *   The entity object.
   * @param string $operation
   *   The operation (view, update, delete).
   *
   * @return bool
   *   TRUE if user can perform operation.
   */
  public function canUserManageEntity(string $entity_type, $entity, string $operation = 'view'): bool {
    if (!$entity) {
      return FALSE;
    }

    // Admin can do everything
    if ($this->currentUser->hasRole('strata_admin')) {
      return TRUE;
    }

    // Check entity access
    $access = $entity->access($operation, $this->currentUser);
    return $access;
  }

  /**
   * Formats date for display.
   *
   * @param int $timestamp
   *   The Unix timestamp.
   * @param string $format
   *   The date format.
   *
   * @return string
   *   The formatted date.
   */
  public function formatDate(int $timestamp, string $format = 'Y-m-d H:i:s'): string {
    return date($format, $timestamp);
  }

  /**
   * Sanitizes text for safe output.
   *
   * @param string $text
   *   The text to sanitize.
   *
   * @return string
   *   The sanitized text.
   */
  public function sanitizeText(string $text): string {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
  }

  /**
   * Logs activity for auditing.
   *
   * @param string $action
   *   The action performed.
   * @param array $context
   *   Additional context information.
   */
  public function logActivity(string $action, array $context = []): void {
    $context['user_id'] = $this->currentUser->id();
    $context['user_role'] = $this->getUserPrimaryStrataRole();
    
    $this->logger->info('Strata activity: @action', [
      '@action' => $action,
      'context' => $context,
    ]);
  }

}