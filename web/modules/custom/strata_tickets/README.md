# Strata Tickets Module

A comprehensive ticketing system for strata community management that allows residents to submit complaints, requests, and comments.

## Overview

The Strata Tickets module provides a custom entity type "Ticket" with three distinct bundles to handle different types of community communications:

- **Complain**: For resident complaints about building issues, noise, violations, or other concerns
- **Request**: For maintenance requests, improvements, or service requests  
- **Comments**: For general feedback, suggestions, or community discussions

## Features

### Entity Structure
- **Custom Entity**: `ticket` with bundles for different ticket types
- **Base Fields**: Title, description, status, priority, created/changed timestamps
- **Custom Fields**: Location and category fields for complaints and requests
- **User Integration**: Each ticket is associated with the creating user

### Ticket Status Options
- Open
- In Progress  
- Resolved
- Closed
- Cancelled

### Priority Levels
- Low
- Medium
- High 
- Urgent

### Category Options
- Maintenance
- Noise
- Parking
- Security
- Cleanliness
- Common Areas
- Building Facilities
- Bylaw Violation
- Plumbing
- Electrical
- HVAC
- Landscaping
- Other

## Bundle Details

### 1. Complain Bundle
**Purpose**: Handle resident complaints and issues
**Additional Fields**:
- Location (optional) - Specify where the complaint occurred
- Category (required) - Categorize the type of complaint

**Use Cases**:
- Noise complaints
- Bylaw violations
- Maintenance issues
- Security concerns
- Cleanliness problems

### 2. Request Bundle  
**Purpose**: Handle maintenance and service requests
**Additional Fields**:
- Location (optional) - Specify where work is needed
- Category (required) - Categorize the type of request

**Use Cases**:
- Maintenance requests
- Facility improvements
- Service requests
- Equipment repairs

### 3. Comments Bundle
**Purpose**: General feedback and community discussions
**Additional Fields**: None (uses base fields only)

**Use Cases**:
- General feedback
- Suggestions for improvement
- Community discussions
- Compliments or appreciation

## Installation

1. **Enable the module:**
   ```bash
   drush en strata_tickets -y
   ```

2. **Verify installation:**
   - Visit `/admin/structure/ticket_type` to see the three ticket types
   - Visit `/admin/content/tickets` to view tickets
   - Visit `/ticket/add` to create new tickets

## Permissions

The module provides comprehensive permissions:

### Administrative
- `administer ticket entities` - Full admin access
- `view unpublished ticket entities` - View unpublished tickets

### General Permissions  
- `view published ticket entities` - View published tickets
- `view own ticket entities` - View own tickets only
- `create ticket entities` - Create any ticket type
- `edit any ticket entities` - Edit any tickets
- `edit own ticket entities` - Edit own tickets only
- `delete any ticket entities` - Delete any tickets  
- `delete own ticket entities` - Delete own tickets only

### Bundle-Specific Creation
- `create complain ticket entities` - Create complaint tickets
- `create request ticket entities` - Create request tickets
- `create comments ticket entities` - Create comment tickets

## Usage

### Creating Tickets
1. Navigate to `/ticket/add`
2. Select the appropriate ticket type (Complain, Request, or Comments)
3. Fill in the required information:
   - Title (required)
   - Description (optional but recommended)
   - Category (required for Complain/Request)
   - Location (optional for Complain/Request)  
   - Priority (defaults to Medium)
   - Status (defaults to Open)

### Managing Tickets
- **View All**: `/admin/content/tickets`
- **Edit**: `/ticket/{id}/edit`
- **Delete**: `/ticket/{id}/delete`
- **View**: `/ticket/{id}`

### Role Integration
The module integrates with the Strata Roles module permissions:

- **Residents**: Can create and view their own tickets
- **Staff**: Can manage maintenance-related tickets
- **Council**: Can view and respond to tickets
- **Manager/Admin**: Full ticket management access

## Technical Details

### Entity Definition
```php
// Entity machine name: ticket
// Bundle entity: ticket_type
// Base table: ticket
// Translatable: Yes
// Revisionable: No
```

### Database Schema
The module creates the following tables:
- `ticket` - Main ticket storage
- `ticket_type` - Ticket type/bundle configuration

### Routes
- `/ticket/{ticket}` - View ticket
- `/ticket/add` - Add ticket page
- `/ticket/add/{ticket_type}` - Add specific ticket type
- `/ticket/{ticket}/edit` - Edit ticket
- `/ticket/{ticket}/delete` - Delete ticket
- `/admin/content/tickets` - Ticket listing
- `/admin/structure/ticket_type` - Manage ticket types

## Customization

### Adding Fields
1. Navigate to `/admin/structure/ticket_type`
2. Click "Manage fields" for the desired ticket type
3. Add custom fields as needed

### Modifying Categories
Edit the field storage configuration in:
`config/install/field.storage.ticket.field_category.yml`

### Custom Templates
Override the default template by creating:
`ticket.html.twig` in your theme's templates directory

## Integration

### With Strata Roles Module
- Automatic permission integration
- Role-based access control
- User assignment capabilities

### With Views Module  
- Create custom ticket listings
- Filter by type, status, priority
- Export capabilities

### With Rules/Workflow Modules
- Automated status changes
- Email notifications
- Escalation processes

## Troubleshooting

### Common Issues

**Tickets not appearing**: Check permissions and publication status

**Cannot create tickets**: Verify user has appropriate create permissions

**Fields not showing**: Clear cache and check field configuration

### Debugging
```bash
# Clear cache
drush cr

# Check entity info
drush eval "print_r(\Drupal::entityTypeManager()->getDefinition('ticket'));"

# List ticket types
drush eval "print_r(\Drupal::entityTypeManager()->getStorage('ticket_type')->loadMultiple());"
```

## Development

### Extending the Module
- Add new bundles via configuration
- Create custom field types
- Implement workflow integrations
- Add notification systems

### API Usage
```php
// Load ticket
$ticket = \Drupal::entityTypeManager()->getStorage('ticket')->load($id);

// Create ticket
$ticket = \Drupal::entityTypeManager()->getStorage('ticket')->create([
  'type' => 'complain',
  'title' => 'Sample Complaint',
  'description' => 'Description here',
  'ticket_status' => 'open',
  'priority' => 'medium',
]);
$ticket->save();
```

## Uninstalling

The module automatically cleans up all ticket entities when uninstalled:

```bash
drush pmu strata_tickets -y
```

**Warning**: This will permanently delete all ticket data!