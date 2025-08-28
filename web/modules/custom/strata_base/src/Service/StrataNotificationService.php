<?php

declare(strict_types=1);

namespace Drupal\strata_base\Service;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Notification service for Strata modules.
 */
class StrataNotificationService {

  use StringTranslationTrait;

  /**
   * The messenger service.
   */
  protected MessengerInterface $messenger;

  /**
   * The logger channel.
   */
  protected LoggerChannelInterface $logger;

  /**
   * The current user.
   */
  protected AccountInterface $currentUser;

  /**
   * Constructs a StrataNotificationService object.
   */
  public function __construct(
    MessengerInterface $messenger,
    LoggerChannelFactoryInterface $logger_factory,
    AccountInterface $current_user
  ) {
    $this->messenger = $messenger;
    $this->logger = $logger_factory->get('strata_notifications');
    $this->currentUser = $current_user;
  }

  /**
   * Sends a success notification.
   *
   * @param string $message
   *   The message to display.
   * @param array $context
   *   Additional context for logging.
   */
  public function success(string $message, array $context = []): void {
    $this->messenger->addStatus($this->t($message));
    $this->logNotification('success', $message, $context);
  }

  /**
   * Sends a warning notification.
   *
   * @param string $message
   *   The message to display.
   * @param array $context
   *   Additional context for logging.
   */
  public function warning(string $message, array $context = []): void {
    $this->messenger->addWarning($this->t($message));
    $this->logNotification('warning', $message, $context);
  }

  /**
   * Sends an error notification.
   *
   * @param string $message
   *   The message to display.
   * @param array $context
   *   Additional context for logging.
   */
  public function error(string $message, array $context = []): void {
    $this->messenger->addError($this->t($message));
    $this->logNotification('error', $message, $context);
  }

  /**
   * Sends an informational notification.
   *
   * @param string $message
   *   The message to display.
   * @param array $context
   *   Additional context for logging.
   */
  public function info(string $message, array $context = []): void {
    $this->messenger->addMessage($this->t($message));
    $this->logNotification('info', $message, $context);
  }

  /**
   * Sends a notification to specific Strata roles.
   *
   * @param array $roles
   *   Array of role IDs to notify.
   * @param string $message
   *   The notification message.
   * @param string $type
   *   The notification type (success, warning, error, info).
   */
  public function notifyRoles(array $roles, string $message, string $type = 'info'): void {
    // For now, just log the role-based notification
    // In future, this could integrate with email or other notification systems
    $context = [
      'target_roles' => $roles,
      'notification_type' => $type,
    ];
    
    $this->logNotification('role_notification', $message, $context);
    
    // Also show message to current user if they have one of the target roles
    $user_roles = $this->currentUser->getRoles();
    $has_target_role = !empty(array_intersect($roles, $user_roles));
    
    if ($has_target_role) {
      switch ($type) {
        case 'success':
          $this->success($message);
          break;
        case 'warning':
          $this->warning($message);
          break;
        case 'error':
          $this->error($message);
          break;
        default:
          $this->info($message);
          break;
      }
    }
  }

  /**
   * Logs a notification for auditing.
   *
   * @param string $type
   *   The notification type.
   * @param string $message
   *   The notification message.
   * @param array $context
   *   Additional context information.
   */
  protected function logNotification(string $type, string $message, array $context = []): void {
    $context['user_id'] = $this->currentUser->id();
    $context['timestamp'] = time();
    
    $this->logger->info('Strata notification [@type]: @message', [
      '@type' => $type,
      '@message' => $message,
      'context' => $context,
    ]);
  }

}