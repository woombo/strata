# Strata Roles Module

This module manages roles and permissions for a Strata community management system.

## Roles

The module creates five distinct roles with specific permissions:

### 1. Strata Admin (`strata_admin`)
- **Weight:** -8 (highest priority)
- **Is Admin:** Yes
- **Purpose:** Complete system administration
- **Permissions:** Full administrative access including:
  - All core Drupal admin permissions
  - All custom strata permissions
  - Building and financial management
  - User and system administration

### 2. Strata Manager (`strata_manager`) 
- **Weight:** -6
- **Purpose:** Day-to-day strata management
- **Permissions:**
  - Content and menu management
  - Building and financial management
  - Resident communications
  - Maintenance coordination
  - Report access

### 3. Strata Council (`strata_council`)
- **Weight:** -4  
- **Purpose:** Council member with meeting and communication responsibilities
- **Permissions:**
  - Meeting management
  - Resident communications
  - View reports and documents
  - Submit maintenance requests

### 4. Strata Staff (`strata_staff`)
- **Weight:** -3
- **Purpose:** Maintenance and support staff
- **Permissions:**
  - Maintenance request management
  - Dashboard access
  - View building documents
  - Basic report access

### 5. Strata Resident (`strata_resident`)
- **Weight:** -2 (lowest admin priority)
- **Purpose:** Building residents
- **Permissions:**
  - Dashboard access
  - View building documents
  - Submit maintenance requests
  - Basic content creation

## Custom Permissions

The module defines these strata-specific permissions:

- `manage strata building` - Building information management
- `manage strata finances` - Financial reports and budgets
- `manage strata maintenance` - Maintenance requests and work orders
- `view strata reports` - Access to various reports
- `manage strata meetings` - AGM and committee meetings
- `access strata dashboard` - Main dashboard access
- `manage resident communications` - Notices and communications
- `manage building documents` - Document management
- `view building documents` - Read-only document access
- `submit maintenance request` - Submit maintenance requests

## Installation

1. Enable the module: `drush en strata_roles`
2. All roles and permissions are automatically created
3. Assign users to appropriate roles via Admin → People

## Role Hierarchy

The module enforces a single primary strata role per user:
1. Admin (highest priority)
2. Manager
3. Council Member  
4. Staff
5. Resident (lowest priority)

If a user is assigned multiple strata roles, only the highest priority role is retained.

## Usage

```php
// Check if user has any strata role
if (strata_roles_user_has_strata_role($user)) {
  // User has a strata role
}

// Get user's primary strata role
$role = strata_roles_get_primary_role($user);
if ($role) {
  $role_id = $role['id'];
  $role_label = $role['label'];
}
```

## Uninstalling

When the module is uninstalled, all strata-specific roles are automatically removed.