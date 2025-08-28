# Strata Drupal 11 Website

A Drupal 11 website with entities defined in code and managed via Composer.

## Requirements

- PHP 8.1 or higher
- Composer 2.0 or higher
- MySQL/MariaDB or PostgreSQL
- Web server (Apache/Nginx)

## Installation

### Option 1: Lando Development Environment (Recommended)

1. **Prerequisites:**
   - Install [Lando](https://docs.lando.dev/getting-started/installation.html)
   - Install [Docker](https://docs.docker.com/get-docker/)

2. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd strata
   ```

3. **Quick setup with Lando:**
   ```bash
   chmod +x scripts/lando-setup.sh
   ./scripts/lando-setup.sh
   ```

4. **Manual Lando setup:**
   ```bash
   lando start
   lando install-site
   lando enable-modules
   ```

5. **Access your site:**
   - **Website:** https://strata.lndo.site
   - **MailHog:** https://mail.strata.lndo.site  
   - **Admin:** Username: `admin`, Password: `admin`

### Option 2: Traditional Local Development

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd strata
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Create database:**
   Create a MySQL database named `strata_drupal` (or update database settings in `web/sites/default/settings.local.php`)

4. **Install Drupal:**
   ```bash
   cd web
   php core/scripts/drupal quick-start
   ```
   
   Or use Drush:
   ```bash
   vendor/bin/drush site:install --db-url=mysql://root@localhost/strata_drupal
   ```

5. **Configure local development:**
   - The database settings automatically detect Lando environment
   - The configuration management is set up to use `config/sync` directory

## Development Setup

### Configuration Management

This site uses Drupal's configuration management system:

- **Export configuration:** `drush config:export`
- **Import configuration:** `drush config:import`
- **Configuration directory:** `config/sync/`

### Strata Modules

The system includes several custom modules:

#### 1. Strata Base (`strata_base`)
Foundation module providing:
- Common services and utilities
- Role management helpers
- Building information management  
- Notification system
- Constants and helper functions

#### 2. Strata Roles (`strata_roles`)
Role management system with 5 roles:
- **Admin**: Full system control
- **Manager**: Day-to-day management
- **Council**: Meeting and communication management
- **Staff**: Maintenance and support
- **Resident**: Basic access and ticket submission

#### 3. Strata Tickets (`strata_tickets`)
Comprehensive ticketing system with 3 bundles:
- **Complain**: For issues and violations
- **Request**: For maintenance and service requests
- **Comments**: For general feedback and discussions

### Custom Entities

All custom entities are defined in code using:

1. **Custom modules** in `web/modules/custom/`
2. **Configuration YAML files** in module config directories
3. **Entity definitions** as PHP classes
4. **Base module dependencies** for common functionality

### Directory Structure

```
├── config/sync/           # Configuration management files
├── web/                   # Drupal docroot
│   ├── modules/custom/    # Custom modules
│   ├── themes/custom/     # Custom themes
│   └── sites/default/     # Site-specific settings
├── vendor/               # Composer dependencies
└── composer.json         # Composer configuration
```

### Useful Commands

#### Lando Commands (Recommended)

```bash
# Lando environment management
lando start                    # Start the development environment
lando stop                     # Stop the development environment
lando restart                  # Restart the development environment
lando destroy                  # Destroy the development environment

# Drupal site management
lando install-site            # Install fresh Drupal site
lando enable-modules          # Enable custom Strata modules
lando drush uli               # Get admin login link
lando drush status            # Check Drupal status

# Configuration management
lando config-export           # Export site configuration
lando config-import           # Import site configuration
lando cc                      # Clear all caches

# Development tools
lando composer require drupal/module_name  # Install new modules
lando composer update                      # Update dependencies
lando phpcs                                # Run code sniffer
lando phpcbf                              # Fix code style issues
lando phpstan                             # Run static analysis

# Database operations
lando db-export               # Export database
lando db-import dump.sql      # Import database
lando ssh                     # SSH into app container

# Mail testing
# MailHog available at: https://mail.strata.lndo.site
```

#### Traditional Commands

```bash
# Install new modules
composer require drupal/module_name

# Update Drupal core
composer update drupal/core-recommended --with-dependencies

# Run Drush commands
vendor/bin/drush status
vendor/bin/drush cache:rebuild

# Export site configuration
vendor/bin/drush config:export

# Import site configuration  
vendor/bin/drush config:import
```

## Best Practices

1. **Always use Composer** to manage modules and dependencies
2. **Define entities in code** using configuration YAML files
3. **Use configuration management** to track changes
4. **Keep custom code** in version control
5. **Exclude user-generated content** from version control

## Contributing

1. Create feature branches from `main`
2. Export configuration changes: `drush config:export`
3. Commit both code and configuration changes
4. Test configuration import on clean environments
5. Submit pull requests for review