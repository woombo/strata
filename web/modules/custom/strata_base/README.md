# Strata Base Module

The foundation module for all Strata community management functionality. This module provides common services, utilities, constants, and base configurations used by all other Strata modules.

## Overview

Strata Base serves as the core foundation module that other Strata modules depend on. It provides:

- **Common Services**: Utility, notification, permission helper, and building info services
- **Constants**: Centralized constants for roles, permissions, ticket statuses, etc.
- **Base Configurations**: Default settings and building information management
- **Helper Functions**: Global helper functions for common tasks
- **Activity Logging**: Optional database logging for audit trails

## Features

### Services

#### 1. StrataUtilityService (`strata_base.utility`)
Provides common utility functions for Strata modules:

- Role management and checking
- User permission validation  
- Date formatting
- Text sanitization
- Activity logging

```php
// Example usage
$utility = \Drupal::service('strata_base.utility');

// Check if user has any Strata role
if ($utility->userHasStrataRole()) {
  // User has a Strata role
}

// Get user's primary role
$role = $utility->getUserPrimaryStrataRole();

// Log activity
$utility->logActivity('Ticket created', ['ticket_id' => 123]);
```

#### 2. StrataNotificationService (`strata_base.notification`)
Handles notifications and messaging:

- Success, warning, error, and info messages
- Role-based notifications
- Logging integration

```php
// Example usage
$notification = \Drupal::service('strata_base.notification');

// Send notifications
$notification->success('Ticket created successfully');
$notification->error('Failed to save changes');

// Notify specific roles
$notification->notifyRoles(['strata_admin', 'strata_manager'], 'System maintenance scheduled');
```

#### 3. StrataBuildingInfoService (`strata_base.building_info`)
Manages building information and statistics:

- Building details (name, address, units, etc.)
- Statistics tracking
- Configuration management

```php
// Example usage
$building = \Drupal::service('strata_base.building_info');

// Get building info
$info = $building->getBuildingInfo();

// Update building info
$building->setBuildingInfo([
  'name' => 'Sunset Towers',
  'total_units' => 120,
  'floors' => 15
]);

// Get statistics
$stats = $building->getBuildingStats();
```

#### 4. StrataPermissionHelper (`strata_base.permission_helper`)
Provides permission checking utilities:

- Strata-specific permission checks
- Role-based access validation
- Feature access control

```php
// Example usage
$permissions = \Drupal::service('strata_base.permission_helper');

// Check permissions
if ($permissions->canManageBuilding()) {
  // User can manage building
}

if ($permissions->canViewReports()) {
  // User can view reports
}
```

### Constants

The `StrataConstants` class provides centralized constants:

```php
use Drupal\strata_base\Utility\StrataConstants;

// Role constants
StrataConstants::ROLE_ADMIN
StrataConstants::ROLE_MANAGER
StrataConstants::ALL_ROLES

// Ticket constants
StrataConstants::TICKET_STATUS_OPEN
StrataConstants::TICKET_PRIORITIES
StrataConstants::CATEGORIES

// Permission constants
StrataConstants::PERMISSION_MANAGE_BUILDING
StrataConstants::PERMISSION_VIEW_REPORTS
```

### Helper Functions

Global helper functions available throughout the site:

```php
// Check if user has Strata role
strata_base_user_has_role($account);

// Get user's primary role
strata_base_get_user_role($account);

// Get user's role label
strata_base_get_user_role_label($account);

// Get services
strata_base_utility();
strata_base_notification();
strata_base_building_info();
strata_base_permission_helper();
```

## Configuration

### Building Information
Configure via `strata_base.building_info`:

- **name**: Building name
- **address**: Street address
- **city**: City
- **postal_code**: Postal/ZIP code
- **province**: Province/state
- **country**: Country (defaults to Canada)
- **total_units**: Number of units
- **floors**: Number of floors
- **built_year**: Year built
- **property_manager**: Property manager contact
- **emergency_contact**: Emergency contact info

### General Settings
Configure via `strata_base.settings`:

- **timezone**: Default timezone
- **date_format**: Date display format
- **enable_logging**: Enable activity logging
- **enable_notifications**: Enable notifications
- **dashboard_refresh_interval**: Dashboard refresh rate
- **session_timeout**: User session timeout
- **max_login_attempts**: Maximum login attempts

## Database Schema

### Optional Activity Log Table
If enabled, creates `strata_activity_log` table:

- **id**: Primary key
- **uid**: User ID
- **action**: Action performed
- **entity_type**: Related entity type
- **entity_id**: Related entity ID
- **details**: JSON details
- **ip_address**: User IP address
- **timestamp**: When action occurred

## Installation

The module is automatically installed as a dependency when installing other Strata modules:

```bash
# Install with Lando
lando drush en strata_base -y

# Or traditional Drush
drush en strata_base -y
```

## Dependencies

### Required Modules
- drupal:user
- drupal:system  
- drupal:field
- drupal:text
- drupal:datetime
- drupal:options

### Dependent Modules
All other Strata modules depend on this base module:
- strata_roles
- strata_tickets
- (any future Strata modules)

## Usage Examples

### Using Services in Custom Code

```php
<?php

namespace Drupal\my_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\strata_base\Service\StrataUtilityService;
use Drupal\strata_base\Service\StrataNotificationService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MyController extends ControllerBase {

  protected $strataUtility;
  protected $strataNotification;

  public function __construct(
    StrataUtilityService $strata_utility,
    StrataNotificationService $strata_notification
  ) {
    $this->strataUtility = $strata_utility;
    $this->strataNotification = $strata_notification;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('strata_base.utility'),
      $container->get('strata_base.notification')
    );
  }

  public function myAction() {
    // Check user role
    if (!$this->strataUtility->userHasStrataRole()) {
      $this->strataNotification->error('Access denied');
      throw new AccessDeniedHttpException();
    }

    // Log activity
    $this->strataUtility->logActivity('Custom action performed');
    
    // Show success message
    $this->strataNotification->success('Action completed successfully');
    
    return ['#markup' => 'Content here'];
  }
}
```

### Using Helper Functions

```php
// In hooks or procedural code
function my_module_some_function() {
  // Quick role check
  if (!strata_base_user_has_role()) {
    return;
  }

  // Get user's role
  $role = strata_base_get_user_role_label();
  
  // Send notification
  strata_base_notification()->info("Welcome, $role!");
  
  // Log activity
  strata_base_utility()->logActivity('Function executed');
}
```

### Using Constants

```php
use Drupal\strata_base\Utility\StrataConstants;

// Check for specific role
if ($account->hasRole(StrataConstants::ROLE_ADMIN)) {
  // Admin logic
}

// Validate ticket status
if (in_array($status, StrataConstants::TICKET_STATUSES)) {
  // Valid status
}

// Check permission
if ($account->hasPermission(StrataConstants::PERMISSION_MANAGE_BUILDING)) {
  // User can manage building
}
```

## Hooks

### Hook Implementations

#### hook_user_login()
Logs login activity for Strata users.

#### hook_preprocess_page()
Adds Strata-specific variables to page templates:
- `strata_user_role`
- `strata_user_role_label`
- `strata_building_name`

### Available Hooks for Other Modules

Other modules can implement these hooks to integrate with Strata Base:

```php
// React to building info changes
function my_module_strata_building_info_update($old_info, $new_info) {
  // React to building info changes
}

// React to user role changes
function my_module_strata_user_role_changed($account, $old_role, $new_role) {
  // React to role changes
}
```

## Theme Integration

### Available Theme Functions

```php
// In templates
{{ strata_user_role_label }}
{{ strata_building_name }}
```

### Theme Templates

Create custom templates:
- `strata-dashboard.html.twig`
- `strata-building-info.html.twig`

## API Reference

### StrataUtilityService Methods

| Method | Description | Parameters | Return |
|--------|-------------|------------|--------|
| `getStrataRoles()` | Get all Strata role IDs | None | array |
| `userHasStrataRole()` | Check if user has any Strata role | AccountInterface|null | bool |
| `getUserPrimaryStrataRole()` | Get user's primary role | AccountInterface|null | string|null |
| `getUserStrataRoleLabel()` | Get user's role label | AccountInterface|null | string|null |
| `canUserManageEntity()` | Check entity management access | string, entity, string | bool |
| `formatDate()` | Format timestamp | int, string | string |
| `sanitizeText()` | Sanitize text | string | string |
| `logActivity()` | Log activity | string, array | void |

### StrataNotificationService Methods

| Method | Description | Parameters | Return |
|--------|-------------|------------|--------|
| `success()` | Success message | string, array | void |
| `warning()` | Warning message | string, array | void |
| `error()` | Error message | string, array | void |
| `info()` | Info message | string, array | void |
| `notifyRoles()` | Role-based notification | array, string, string | void |

### StrataBuildingInfoService Methods

| Method | Description | Parameters | Return |
|--------|-------------|------------|--------|
| `getBuildingInfo()` | Get all building info | None | array |
| `setBuildingInfo()` | Set building info | array | void |
| `getBuildingInfoValue()` | Get specific info value | string | mixed |
| `getBuildingStats()` | Get building statistics | None | array |
| `updateBuildingStats()` | Update statistics | array | void |

### StrataPermissionHelper Methods

| Method | Description | Parameters | Return |
|--------|-------------|------------|--------|
| `hasStrataAccess()` | Check Strata access | AccountInterface|null | bool |
| `canManageBuilding()` | Check building management | AccountInterface|null | bool |
| `canManageFinances()` | Check finance management | AccountInterface|null | bool |
| `canManageMaintenance()` | Check maintenance management | AccountInterface|null | bool |
| `canViewReports()` | Check report access | AccountInterface|null | bool |
| `canManageMeetings()` | Check meeting management | AccountInterface|null | bool |
| `canManageCommunications()` | Check communication management | AccountInterface|null | bool |
| `getRolePermissions()` | Get role permissions | string | array |

## Troubleshooting

### Common Issues

**Services not available**
```bash
# Clear cache
drush cr
```

**Configuration not saved**
```bash
# Check permissions on config directory
# Verify config/sync directory exists and is writable
```

**Constants not found**
```php
// Make sure to import the class
use Drupal\strata_base\Utility\StrataConstants;
```

### Debugging

```php
// Enable logging
$config = \Drupal::configFactory()->getEditable('strata_base.settings');
$config->set('enable_logging', TRUE)->save();

// Check activity logs
$query = \Drupal::database()->select('strata_activity_log', 'sal');
$query->fields('sal');
$results = $query->execute()->fetchAll();
```

## Contributing

When extending Strata Base:

1. **Add new services** to `strata_base.services.yml`
2. **Add new constants** to `StrataConstants` class
3. **Update schemas** in `config/schema/`
4. **Add helper functions** to `strata_base.module`
5. **Update documentation** in this README

## Version History

- **1.0.0**: Initial release with core services and utilities