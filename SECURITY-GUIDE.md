# Security Best Practices Guide

## Overview

This guide provides security best practices for deploying and maintaining the Faveo Invoicing application. Following these guidelines will help protect your application and user data.

## Table of Contents

1. [Initial Setup](#initial-setup)
2. [Environment Configuration](#environment-configuration)
3. [Web Server Configuration](#web-server-configuration)
4. [Database Security](#database-security)
5. [File Permissions](#file-permissions)
6. [SSL/TLS Configuration](#ssltls-configuration)
7. [Authentication & Authorization](#authentication--authorization)
8. [Regular Maintenance](#regular-maintenance)
9. [Incident Response](#incident-response)

---

## Initial Setup

### 1. Generate Application Key

**CRITICAL:** Always generate a unique application key before deployment:

```bash
php artisan key:generate
```

Never use the default or example keys in production. The application key is used for:
- Encrypting session data
- Encrypting sensitive database fields
- Generating secure tokens

### 2. Set Environment to Production

In your `.env` file:

```env
APP_ENV=production
APP_DEBUG=false
```

**WARNING:** Never set `APP_DEBUG=true` in production. This exposes:
- Stack traces with file paths
- Database queries
- Configuration values
- Potentially sensitive data

### 3. Disable Error Reporting to Bugsnag (Optional)

If you're not using Bugsnag for error monitoring:

```env
APP_BUGSNAG=false
```

---

## Environment Configuration

### Required Security Settings

Create or update your `.env` file with these minimum security settings:

```env
# Application
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATE_THIS_WITH_php_artisan_key:generate
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=strong_password_here

# Session Security
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=true
SESSION_DOMAIN=.yourdomain.com

# Cache
CACHE_DRIVER=redis
QUEUE_DRIVER=redis

# Mail (use TLS encryption)
MAIL_DRIVER=smtp
MAIL_HOST=smtp.yourmailserver.com
MAIL_PORT=587
MAIL_USERNAME=your_email@yourdomain.com
MAIL_PASSWORD=your_mail_password
MAIL_ENCRYPTION=tls

# Content Security Policy
CSP_ENABLED=true
CSP_NONCE_ENABLED=true

# Security
DB_INSTALL=1
```

### Password Requirements

The application supports configurable password policies. Add to `.env`:

```env
PASSWORD_MIN_LENGTH=12
PASSWORD_REQUIRE_UPPERCASE=true
PASSWORD_REQUIRE_LOWERCASE=true
PASSWORD_REQUIRE_NUMBERS=true
PASSWORD_REQUIRE_SPECIAL_CHARS=true
```

### Rate Limiting Configuration

Protect against brute force attacks:

```env
LOGIN_MAX_ATTEMPTS=5
LOGIN_DECAY_MINUTES=15
REGISTRATION_MAX_ATTEMPTS=3
REGISTRATION_DECAY_MINUTES=60
API_MAX_ATTEMPTS=60
API_DECAY_MINUTES=1
```

---

## Web Server Configuration

### Apache

Ensure your virtual host configuration includes:

```apache
<VirtualHost *:443>
    ServerName yourdomain.com
    DocumentRoot /path/to/faveo/public

    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    SSLCertificateChainFile /path/to/chain.crt

    # Security Headers
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"

    <Directory /path/to/faveo/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Deny access to sensitive directories
    <DirectoryMatch "^/path/to/faveo/(storage|vendor|config|database)">
        Require all denied
    </DirectoryMatch>
</VirtualHost>

# Redirect HTTP to HTTPS
<VirtualHost *:80>
    ServerName yourdomain.com
    Redirect permanent / https://yourdomain.com/
</VirtualHost>
```

### Nginx

Sample Nginx configuration:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com;
    root /path/to/faveo/public;

    # SSL Configuration
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\. {
        deny all;
    }

    # Deny access to sensitive directories
    location ~* /(storage|vendor|config|database) {
        deny all;
        return 404;
    }
}
```

---

## Database Security

### 1. Use Separate Database User

Create a dedicated MySQL user with minimal privileges:

```sql
CREATE USER 'faveo_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, INDEX, ALTER, DROP 
ON faveo_database.* TO 'faveo_user'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Regular Backups

Set up automated database backups:

```bash
# Add to crontab
0 2 * * * mysqldump -u faveo_user -p'password' faveo_database > /backup/faveo_$(date +\%Y\%m\%d).sql
```

### 3. Enable SSL for Database Connections

In `.env`:

```env
DB_SSL_CA=/path/to/ca-cert.pem
DB_SSL_CERT=/path/to/client-cert.pem
DB_SSL_KEY=/path/to/client-key.pem
```

---

## File Permissions

Set proper file permissions to prevent unauthorized access:

```bash
cd /path/to/faveo

# Set ownership
chown -R www-data:www-data .

# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make storage and cache writable
chmod -R 775 storage bootstrap/cache

# Protect sensitive files
chmod 600 .env
chmod 644 composer.json composer.lock
```

### Files to Protect

Ensure these files are NOT publicly accessible:
- `.env`
- `composer.json` and `composer.lock`
- `phpunit.xml`
- Any `.log` files
- `storage/` directory
- `vendor/` directory
- `config/` directory
- `database/` directory

---

## SSL/TLS Configuration

### 1. Obtain SSL Certificate

Use Let's Encrypt for free SSL certificates:

```bash
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com
```

Or for Nginx:

```bash
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

### 2. Force HTTPS

In `.env`:

```env
APP_URL=https://yourdomain.com
SESSION_SECURE_COOKIE=true
```

### 3. Test SSL Configuration

Use SSL Labs to test your configuration:
https://www.ssllabs.com/ssltest/

Aim for an A+ rating.

---

## Authentication & Authorization

### 1. Enable Two-Factor Authentication

Require 2FA for admin accounts:

```env
2FA_ENFORCE_ADMINS=true
```

### 2. Strong Password Policy

Enforce strong passwords using the configuration in `config/security.php`.

### 3. Session Management

- Use secure session settings (already configured)
- Implement session timeout
- Regenerate session IDs after login

### 4. API Security

If using the API:
- Always use HTTPS
- Implement API rate limiting
- Use token-based authentication
- Rotate API keys regularly

---

## Regular Maintenance

### 1. Keep Software Updated

Regularly update:
- PHP version
- Laravel framework
- Composer dependencies
- Web server software
- Operating system

```bash
# Update composer dependencies
composer update

# Check for security vulnerabilities
composer audit
```

### 2. Monitor Logs

Regularly review:
- Application logs (`storage/logs/`)
- Web server access/error logs
- Database logs
- Authentication logs

### 3. Security Scanning

Run regular security scans:

```bash
# Check for known vulnerabilities in dependencies
composer audit

# Run static analysis
./vendor/bin/phpstan analyse

# Check code style and potential issues
./vendor/bin/phpcs
```

### 4. Backup Strategy

Implement 3-2-1 backup strategy:
- 3 copies of data
- 2 different storage media
- 1 off-site backup

---

## Incident Response

### If You Suspect a Security Breach

1. **Immediate Actions:**
   - Take the site offline if necessary
   - Change all passwords
   - Review access logs
   - Check for unauthorized changes

2. **Investigation:**
   - Review `storage/logs/` for suspicious activity
   - Check database for unauthorized changes
   - Review file system for unauthorized files
   - Examine web server logs

3. **Recovery:**
   - Restore from clean backup if compromised
   - Apply security patches
   - Review and strengthen security measures
   - Document the incident

4. **Reporting:**
   - Report to security@faveohelpdesk.com
   - Notify affected users if data was compromised
   - Document lessons learned

---

## Security Checklist

Before going live, verify:

- [ ] Application key generated
- [ ] `APP_DEBUG=false` in production
- [ ] HTTPS/SSL enabled
- [ ] Secure session settings configured
- [ ] File permissions properly set
- [ ] Database user has minimal privileges
- [ ] Regular backups configured
- [ ] Security headers enabled
- [ ] `.env` file protected
- [ ] Sensitive files not publicly accessible
- [ ] 2FA enabled for admin accounts
- [ ] Strong password policy enforced
- [ ] Rate limiting configured
- [ ] CSP policy enabled
- [ ] Error reporting to Bugsnag disabled (or configured)
- [ ] All dependencies updated
- [ ] Security audit completed

---

## Additional Resources

- [Laravel Security Best Practices](https://laravel.com/docs/security)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [OWASP Cheat Sheet Series](https://cheatsheetseries.owasp.org/)
- [SSL Labs](https://www.ssllabs.com/)
- [Mozilla SSL Configuration Generator](https://ssl-config.mozilla.org/)

---

## Support

For security-related questions or to report vulnerabilities:
- Email: security@faveohelpdesk.com
- Report vulnerabilities responsibly following our security policy

---

**Last Updated:** November 15, 2025  
**Version:** 1.0
