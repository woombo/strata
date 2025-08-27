# Strata Drupal 11 Website

A Drupal 11 website with entities defined in code and managed via Composer.

## Requirements

- PHP 8.1 or higher
- Composer 2.0 or higher
- MySQL/MariaDB or PostgreSQL
- Web server (Apache/Nginx)

## Installation

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
   - Copy `web/sites/default/settings.local.php` and update database credentials if needed
   - The configuration management is set up to use `config/sync` directory

## Development Setup

### Configuration Management

This site uses Drupal's configuration management system:

- **Export configuration:** `drush config:export`
- **Import configuration:** `drush config:import`
- **Configuration directory:** `config/sync/`

### Custom Entities

All custom entities should be defined in code using:

1. **Custom modules** in `web/modules/custom/`
2. **Configuration YAML files** in module config directories
3. **Entity definitions** as PHP classes

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