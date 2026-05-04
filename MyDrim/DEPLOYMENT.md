# MyDrim Gallery - Deployment Guide

## Pre-Deployment Checklist

### Code Quality
- [x] Fixed broken links (Arstist-singles → artist-single)
- [x] Removed hardcoded paths (/MyDrim/)
- [x] Fixed undefined variables in mail.php
- [x] Removed console.log debug statements
- [x] Updated favicon references
- [x] Removed unused CSS files
- [x] Cleaned up development files

### Performance
- [ ] Validate image optimization (WebP format if possible)
- [ ] Minify CSS files (if using build process)
- [ ] Minify JavaScript files (if using build process)
- [ ] Test under poor network conditions
- [ ] Check Core Web Vitals

### Security
- [ ] Review .env configuration
- [ ] Update mail() function security in mail.php
- [ ] Validate and sanitize form inputs
- [ ] Implement reCAPTCHA on contact form (recommended)
- [ ] Set up SSL certificate
- [ ] Configure security headers in .htaccess
- [ ] Set file permissions correctly
- [ ] Hide sensitive files from web access

### Testing
- [ ] Test all page links
- [ ] Test contact form submission
- [ ] Test on mobile devices
- [ ] Test on different browsers
- [ ] Test form validation
- [ ] Check all images load correctly
- [ ] Verify video playback (if applicable)
- [ ] Test search functionality
- [ ] Cross-browser compatibility

## Deployment Steps

### 1. Prepare the Server

```bash
# SSH into your server
ssh user@your-domain.com

# Create project directory
mkdir -p /var/www/html/mydrim
cd /var/www/html/mydrim

# Set proper permissions (before uploading files)
chmod 755 /var/www/html/mydrim
```

### 2. Upload Files

```bash
# From your local machine
scp -r MyDrim/* user@your-domain.com:/var/www/html/mydrim/
```

Or use FTP/SFTP client:
- Connect to your server
- Upload all files from `MyDrim/` directory

### 3. Configure Environment

```bash
# SSH into server
ssh user@your-domain.com

# Navigate to project
cd /var/www/html/mydrim

# Create .env file (copy from .env template)
cp .env .env.production

# Edit with production values
nano .env.production
```

Update these values in `.env.production`:
```
CONTACT_EMAIL=your-actual-email@domain.com
SITE_URL=https://your-domain.com
SMTP_HOST=your-smtp-host
SMTP_USER=your-smtp-username
SMTP_PASS=your-smtp-password
DEBUG_MODE=false
```

### 4. Set File Permissions

```bash
# Set directory permissions
find /var/www/html/mydrim -type d -exec chmod 755 {} \;

# Set file permissions
find /var/www/html/mydrim -type f -exec chmod 644 {} \;

# Create logs directory (if needed)
mkdir -p /var/www/html/mydrim/logs
chmod 755 /var/www/html/mydrim/logs

# If you have PHP scripts that need write access
chmod 755 /var/www/html/mydrim/mail.php
```

### 5. Configure Web Server

#### Apache
1. Check if `.htaccess` is enabled:
   ```apache
   # In your Apache config or .htaccess
   <Directory /var/www/html/mydrim>
       AllowOverride All
   </Directory>
   ```

2. Restart Apache:
   ```bash
   sudo systemctl restart apache2
   # or sudo systemctl restart httpd (CentOS)
   ```

#### Nginx
Create `/etc/nginx/sites-available/mydrim`:
```nginx
server {
    listen 80;
    server_name your-domain.com www.your-domain.com;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com www.your-domain.com;

    ssl_certificate /path/to/your/certificate.crt;
    ssl_certificate_key /path/to/your/private.key;

    root /var/www/html/mydrim;
    index index.html index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    # Caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

Enable the site:
```bash
sudo ln -s /etc/nginx/sites-available/mydrim /etc/nginx/sites-enabled/
sudo systemctl restart nginx
```

### 6. Configure SSL

Using Let's Encrypt (recommended):
```bash
sudo apt-get install certbot python3-certbot-apache
sudo certbot certonly --apache -d your-domain.com -d www.your-domain.com
sudo systemctl restart apache2
```

Or for Nginx:
```bash
sudo apt-get install certbot python3-certbot-nginx
sudo certbot certonly --nginx -d your-domain.com -d www.your-domain.com
sudo systemctl restart nginx
```

### 7. Configure PHP (if applicable)

Edit `/etc/php/7.4/apache2/php.ini`:
```ini
; Security
display_errors = Off
log_errors = On
error_log = /var/www/html/mydrim/logs/php_errors.log
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT

; Mail function
SMTP = smtp.gmail.com
smtp_port = 587
sendmail_path = "/usr/sbin/sendmail -t -i"

; File upload
upload_max_filesize = 10M
post_max_size = 10M
```

### 8. Set Up Error Logging

```bash
# Create logs directory
mkdir -p /var/www/html/mydrim/logs

# Set permissions
chmod 755 /var/www/html/mydrim/logs
chown www-data:www-data /var/www/html/mydrim/logs

# Clear log files
echo "" > /var/www/html/mydrim/logs/errors.log
```

### 9. Test Deployment

1. **Check website loads**
   ```bash
   curl https://your-domain.com
   ```

2. **Test contact form**
   - Navigate to contact page
   - Submit a test message
   - Verify email is received

3. **Check HTTPS**
   - Visit https://your-domain.com
   - Verify SSL certificate is valid
   - Check browser shows secure connection

4. **Test all pages**
   - Homepage
   - Artist pages
   - Gallery pages
   - News/Blog pages
   - About page
   - Contact page

5. **Performance check**
   - Use Google PageSpeed Insights
   - Check Core Web Vitals
   - Monitor server resources

### 10. Post-Deployment

1. **Backup**
   ```bash
   tar -czf mydrim-backup-$(date +%Y%m%d).tar.gz /var/www/html/mydrim
   ```

2. **Monitor**
   - Set up uptime monitoring
   - Monitor server resources
   - Check error logs regularly

3. **Update DNS records** (if needed)
   - Point domain to server IP
   - Update DNS A records
   - Wait for DNS propagation

## Troubleshooting

### Contact Form Not Sending
1. Check PHP mail configuration
2. Verify SMTP credentials in .env
3. Check email logs
4. Test with simple mail script
5. Check hosting provider's email policies

### Images Not Loading
1. Check file paths are relative (not `/MyDrim/`)
2. Verify image files are uploaded
3. Check file permissions (644)
4. Check browser console for issues

### 404 Errors
1. Check .htaccess is working
2. Verify file names match links
3. Check case sensitivity (Linux is case-sensitive)
4. Clear browser cache

### SSL Certificate Issues
1. Verify certificate is installed
2. Check certificate domain matches
3. Renew certificate before expiration
4. Force HTTPS redirect in .htaccess

### Performance Issues
1. Enable caching headers
2. Optimize image sizes
3. Minify CSS/JS
4. Enable GZIP compression
5. Use CDN for static files

## Security Hardening

1. **Disable directory listing**
   - Already configured in .htaccess

2. **Hide application files**
   - .env files cannot be accessed via web

3. **Update dependencies**
   ```bash
   npm update
   ```

4. **Regular backups**
   ```bash
   # Create daily backup script
   0 2 * * * tar -czf /backup/mydrim-$(date +\%Y\%m\%d).tar.gz /var/www/html/mydrim
   ```

5. **Monitor security**
   - Check access logs for suspicious activity
   - Monitor for failed login attempts
   - Review error logs

## Maintenance

### Regular Tasks
- [ ] Update dependencies monthly
- [ ] Review error logs weekly
- [ ] Backup database/files daily
- [ ] Monitor SSL certificate expiration (30 days before)
- [ ] Test disaster recovery monthly

### Performance Optimization
- [ ] Monitor page load times
- [ ] Check Core Web Vitals
- [ ] Optimize images as needed
- [ ] Update caching headers
- [ ] Monitor database queries

### Content Updates
- [ ] Update artist portfolios
- [ ] Add new exhibitions
- [ ] Post blog updates
- [ ] Update contact information

## Support

For deployment issues:
1. Check error logs first
2. Review this guide
3. Contact hosting provider support
4. Reach out to development team

## Version History

- **v1.0** (April 2025) - Initial deployment documentation
