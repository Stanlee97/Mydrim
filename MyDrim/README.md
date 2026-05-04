# MyDrim Gallery Website

A modern, responsive website for MyDrim Gallery - showcasing contemporary African art and artists based in Lagos, Nigeria.

## 📋 Project Overview

MyDrim Gallery was established in 1992 to focus on the wealth, beauty, and message of African art in general and Nigerian art in particular. This website serves as the digital presence for the gallery, featuring:

- Artist directories and individual artist portfolios
- Exhibition galleries and collections
- Blog/news section
- Contact and information pages
- Responsive design for all devices

## 🎨 Features

- **Artist Portfolios**: Dedicated pages for featured artists (Abiodun Olaku, Bruce Onobrakpeya, Fidelis Odogwu, Wallace Ejor)
- **Gallery Views**: Exhibition and artwork collections
- **News/Blog**: Latest gallery news and artist features
- **Contact Forms**: Email integration for inquiries
- **Responsive Design**: Mobile-first approach using Bootstrap
- **Performance Optimized**: Minified assets and optimized images

## 📁 Project Structure

```
MyDrim/
├── index.html               # Homepage
├── artist.html              # Artist directory
├── artist-*.html            # Individual artist pages
├── exhibition.html          # Exhibitions gallery
├── Frame.html              # Artworks/frames collection
├── news.html               # Blog/news listing
├── blog-single.html        # Blog post template
├── about.html              # About the gallery
├── contact.html            # Contact page
├── category.html           # Category filtering
├── mail.php                # Contact form backend
│
├── css/                    # Stylesheets
│   ├── bootstrap.css       # Bootstrap framework
│   ├── main.css            # Main styles
│   ├── pages.css           # Page-specific styles
│   └── ...                 # Other vendor CSS files
│
├── js/                     # JavaScript files
│   ├── main.js             # Main application logic
│   ├── mail-script.js      # Contact form handler
│   └── ...                 # Libraries and utilities
│
├── scss/                   # SCSS source files (if customizing)
│   ├── main.scss
│   ├── bootstrap.scss
│   └── theme/
│
├── assets/                 # Static assets
│   ├── fonts/             # Custom fonts
│   └── img/               # Images
│       ├── Artists/       # Artist portfolio images
│       ├── blog/          # Blog post images
│       ├── pages/         # Page-specific images
│       └── frames/        # Artwork frames and images
│
├── .env                    # Configuration file (create from .env.example)
├── .gitignore             # Git ignore file
└── README.md              # This file

```

## 🚀 Getting Started

### Development

1. **Clone/Download the project**
   ```bash
   git clone https://github.com/yourusername/mydrim-gallery.git
   cd mydrim-gallery/MyDrim
   ```

2. **Install dependencies** (if using npm)
   ```bash
   npm install
   ```

3. **Configure environment variables**
   ```bash
   cp .env .env.local
   # Edit .env.local with your configuration
   ```

4. **Start a local server**
   - Using Python: `python -m http.server 8000`
   - Using Node: `npx http-server`
   - Or use your preferred local server

5. **Open in browser**
   - Navigate to `http://localhost:8000`

### Deployment

#### Prerequisites
- PHP 7.4+ (for contact form)
- Web server (Apache/Nginx)
- SSL certificate (HTTPS)

#### Steps

1. **Prepare files**
   ```bash
   # Remove development files
   rm -rf .env.local node_modules/ logs/
   
   # Upload to server
   scp -r ./* username@server:/var/www/html/mydrim/
   ```

2. **Configure server**
   - Create `.env` file with production values
   - Set proper file permissions:
     ```bash
     chmod 755 .
     chmod 644 *.html *.php
     chmod 644 css/* js/* assets/*
     chmod 755 logs/  # if using error logging
     ```

3. **Update mail configuration** in `mail.php`
   - Set `$to` email address
   - Configure SMTP settings if needed

4. **Test**
   - Verify all pages load correctly
   - Test contact form functionality
   - Check images and assets are loading
   - Test on multiple devices/browsers

#### Apache Configuration (`.htaccess`)
```apache
# Redirect HTTP to HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Remove .html extension
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^.]+)$ $1.html [L,R=301]
```

## 🛠️ Technologies Used

- **Frontend**
  - HTML5
  - CSS3 with SCSS
  - JavaScript (jQuery)
  - Bootstrap 4
  - Font Awesome Icons
  - Owl Carousel
  - Animate.css

- **Backend**
  - PHP 7.4+
  - Email forms

- **Build Tools**
  - npm
  - SCSS compiler

## 📧 Contact Form

The contact form is handled by `mail.php`. To enable:

1. Update the `$to` email address in `mail.php`
2. Configure SMTP settings in `.env`
3. Ensure PHP mail() function or SMTP access is available

### Form Fields
- Full Name (fname)
- Email (email)
- Phone (phone)
- Message (message)

## 🔒 Security Considerations

- [ ] Validate and sanitize all form inputs
- [ ] Use HTTPS only
- [ ] Restrict API keys (Google Maps) in Cloud Console
- [ ] Keep .env file with environment variables out of version control
- [ ] Implement rate limiting on contact form
- [ ] Use strong headers (CSP, X-Frame-Options, etc.)
- [ ] Regular security updates for dependencies

## 📱 Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers iOS Safari and Chrome

## 🤝 Contributing

For contributions:
1. Create a feature branch
2. Make your changes
3. Test thoroughly
4. Submit a pull request

## 📄 License

© 2025 MyDrim Gallery. All rights reserved.

## 📞 Support

For inquiries about the gallery:
- Email: lilarmani25@gmail.com
- Address: 74B Norman Williams Street, S.W Ikoyi, Lagos, Nigeria
- Website: https://mydrimgallery.com

## ✅ Deployment Checklist

- [ ] All links verified and working
- [ ] Images optimized and loading correctly
- [ ] Contact form tested and functional
- [ ] SSL certificate installed
- [ ] Environment variables configured
- [ ] Error logging enabled
- [ ] Minified assets in production
- [ ] Analytics configured (if applicable)
- [ ] Backup strategy in place
- [ ] Monitoring and alert system set up

---

**Last Updated**: April 2025
