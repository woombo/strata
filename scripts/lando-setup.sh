#!/bin/bash

# Lando setup script for Strata Drupal project
# This script sets up the development environment

echo "🚀 Setting up Strata Drupal development environment with Lando..."

# Check if Lando is installed
if ! command -v lando &> /dev/null; then
    echo "❌ Lando is not installed. Please install Lando first:"
    echo "   https://docs.lando.dev/getting-started/installation.html"
    exit 1
fi

# Start Lando
echo "📦 Starting Lando containers..."
lando start

# Install Drupal site
echo "🏗️  Installing Drupal site..."
lando install-site

# Enable custom modules
echo "🔧 Enabling custom Strata modules..."
echo "   - strata_base (Base functionality)"
echo "   - strata_roles (Role management)"
echo "   - strata_tickets (Ticket system)"
lando enable-modules

# Set file permissions
echo "📝 Setting proper file permissions..."
lando ssh -s appserver -c "chmod 755 /app/web/sites/default"
lando ssh -s appserver -c "chmod 644 /app/web/sites/default/settings.php"
lando ssh -s appserver -c "mkdir -p /app/web/sites/default/files"
lando ssh -s appserver -c "chmod 777 /app/web/sites/default/files"

# Create private files directory
lando ssh -s appserver -c "mkdir -p /app/web/sites/default/files/private"
lando ssh -s appserver -c "chmod 777 /app/web/sites/default/files/private"

# Clear cache
echo "🧹 Clearing caches..."
lando cc

# Display URLs
echo ""
echo "✅ Setup complete!"
echo ""
echo "🌐 Your Drupal site is available at:"
echo "   https://strata.lndo.site"
echo ""
echo "📧 MailHog (email testing) is available at:"
echo "   https://mail.strata.lndo.site"
echo ""
echo "👤 Admin login:"
echo "   Username: admin"
echo "   Password: admin"
echo ""
echo "🔧 Useful Lando commands:"
echo "   lando drush status     - Check Drupal status"
echo "   lando drush uli        - Get admin login link"
echo "   lando ssh              - SSH into app container"
echo "   lando config-export    - Export configuration"
echo "   lando config-import    - Import configuration"
echo "   lando cc               - Clear cache"
echo "   lando db-export        - Export database"
echo "   lando phpcs            - Run code sniffer"
echo "   lando stop             - Stop containers"
echo "   lando destroy          - Destroy containers"
echo ""
echo "Happy coding! 🎉"