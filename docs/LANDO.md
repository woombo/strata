# Lando Development Environment

This document provides detailed information about using Lando for Strata Drupal development.

## Overview

Lando provides a consistent, reproducible development environment using Docker containers. The Strata project is configured with:

- **PHP 8.3** with Apache 2.4
- **MariaDB 10.6** database
- **MailHog** for email testing
- **Node 18** for front-end development
- **Custom tooling** for Drupal development

## Quick Start

```bash
# Start the environment
lando start

# Run the setup script
./scripts/lando-setup.sh

# Access your site
open https://strata.lndo.site
```

## Services

### Web Server (appserver)
- **Type**: PHP 8.3 with Apache 2.4
- **Webroot**: `web/`
- **URL**: https://strata.lndo.site
- **Custom Configuration**: `.lando/php.ini`

### Database (database)
- **Type**: MariaDB 10.6
- **Database**: `strata_drupal`
- **Username**: `drupal`
- **Password**: `drupal`
- **Custom Configuration**: `.lando/my.cnf`

### Mail Testing (mailhog)
- **Type**: MailHog
- **URL**: https://mail.strata.lndo.site
- **Purpose**: Catch and display outgoing emails

### Node Service
- **Type**: Node 18
- **Global Packages**: gulp-cli, yarn
- **Purpose**: Front-end asset compilation

## Custom Tooling

### Site Management
```bash
lando install-site          # Install Drupal with admin/admin credentials
lando enable-modules        # Enable strata_roles and strata_tickets modules
```

### Drush Commands
```bash
lando drush status          # Check Drupal status
lando drush uli             # Get one-time login URL
lando drush cr              # Clear caches
lando drush cex             # Export configuration
lando drush cim             # Import configuration
```

### Development Tools
```bash
lando phpcs                 # Run PHP CodeSniffer
lando phpcbf               # Fix PHP coding standards
lando phpstan              # Run PHPStan static analysis
lando generate-content     # Generate sample content
```

### Database Operations
```bash
lando db-export            # Export database to stdout
lando db-export > backup.sql  # Export to file
lando db-import backup.sql # Import database
```

## Configuration Files

### .lando.yml
Main Lando configuration file defining:
- Services and their versions
- Custom tooling commands
- Proxy URLs
- Build steps

### .lando/php.ini
Custom PHP configuration for development:
- Increased memory limits
- Error reporting
- File upload settings
- OPcache configuration

### .lando/my.cnf
MariaDB optimization for development:
- Performance tuning
- Character sets
- Query cache settings

### .lando/xdebug.ini
Xdebug configuration (commented out by default):
- Debug mode settings
- Client configuration
- IDE integration

## Development Workflow

### 1. Starting Development
```bash
# Start Lando
lando start

# SSH into container (if needed)
lando ssh

# Check Drupal status
lando drush status
```

### 2. Installing Modules
```bash
# Install via Composer
lando composer require drupal/admin_toolbar

# Enable the module
lando drush en admin_toolbar -y
```

### 3. Configuration Management
```bash
# Export changes
lando config-export

# Commit to git
git add config/
git commit -m "Add admin toolbar configuration"

# On another environment, import
lando config-import
```

### 4. Database Workflow
```bash
# Create backup before major changes
lando db-export > before-changes-$(date +%Y%m%d).sql

# Make changes via UI or drush

# If something goes wrong, restore
lando db-import before-changes-20240127.sql
```

## Debugging

### Enabling Xdebug
1. Uncomment Xdebug lines in `.lando/xdebug.ini`
2. Restart Lando: `lando restart`
3. Configure your IDE to listen on port 9003

### Common Issues

**Site not accessible**
```bash
lando restart
lando rebuild -y  # If restart doesn't work
```

**Database connection errors**
```bash
# Check database service
lando logs -s database

# Restart database
lando restart -s database
```

**Permission errors**
```bash
lando ssh -c "chmod -R 777 /app/web/sites/default/files"
```

**Module not found after composer install**
```bash
lando drush cr  # Clear caches
lando rebuild   # Rebuild containers if needed
```

## File Permissions

Lando automatically handles most file permission issues, but you may occasionally need:

```bash
# Fix file permissions
lando ssh -c "chown -R www-data:www-data /app/web/sites/default/files"
lando ssh -c "chmod -R 755 /app/web/sites/default/files"

# Make settings writable temporarily
lando ssh -c "chmod 644 /app/web/sites/default/settings.php"
```

## Performance Optimization

### Database Tuning
The `.lando/my.cnf` file includes optimized settings for development:
- Increased buffer sizes
- Disabled binary logging
- Query cache enabled

### PHP Tuning
The `.lando/php.ini` file includes:
- OPcache enabled for better performance
- Increased memory limits
- Optimized for development

### Clearing Caches
```bash
# Drupal caches
lando cc

# Rebuild everything
lando rebuild -y
```

## Environment Variables

Available environment variables in Lando containers:
- `LANDO=ON` - Indicates running in Lando
- `DRUPAL_HASH_SALT` - Drupal hash salt
- `ENVIRONMENT=local` - Environment identifier

## Integration with IDEs

### VS Code
1. Install PHP Intelephense extension
2. Configure Xdebug as described above
3. Use integrated terminal: `lando ssh`

### PhpStorm
1. Configure PHP interpreter to use Lando
2. Set up path mappings for debugging
3. Configure Xdebug connection

## Stopping and Cleanup

```bash
# Stop services
lando stop

# Destroy environment (keeps code, removes containers)
lando destroy

# Complete cleanup (removes everything)
lando destroy -y
rm -rf ~/.lando/cache
```

## Troubleshooting

### Rebuild Issues
```bash
# Clear Lando cache
rm -rf ~/.lando/cache

# Rebuild from scratch
lando destroy -y
lando start
```

### Port Conflicts
If you have port conflicts, Lando will automatically assign different ports. Check with:
```bash
lando info
```

### Docker Issues
```bash
# Reset Docker
docker system prune

# Restart Docker service
# (Method varies by OS)
```

## Additional Resources

- [Lando Documentation](https://docs.lando.dev/)
- [Drupal with Lando](https://docs.lando.dev/drupal/)
- [Docker Best Practices](https://docs.docker.com/develop/best-practices/)