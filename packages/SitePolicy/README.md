# site-policy



## 📝 Description

Enhance your website's compliance with data privacy regulations using the 'site-policy' Laravel package. This package provides a customizable cookie consent banner that seamlessly integrates into your Laravel application. Benefit from auto-loaded routes and views, simplifying the implementation process and allowing you to quickly deploy a user-friendly and legally compliant cookie consent solution.
![SitePolicy Banner](assets/preview.png)

## 📦 Installation

1. **Install the package via Composer:**

```bash
composer require saydum/site-policy
```

2. **Publish configuration and views:**
```bash
php artisan vendor:publish --tag=sitepolicy
```

3. **Include package routes in your web.php:**
```bash
echo "require __DIR__.'/sitepolicy.php';" >> routes/web.php
```

4. **Add the cookie banner to your Blade layout (e.g., before </body>):**
```bladehtml
@include('sitepolicy::modal')
```

## 📁 Project Structure

```
.
├── composer.json
├── config
│   └── police.php
├── resources
│   └── views
│       └── modal.blade.php
├── routes
│   └── sitepolicy.php
└── src
    └── SitePolicyServiceProvider.php
```

## 👥 Contributing

Contributions are welcome! Here's how you can help:

1. **Fork** the repository
2. **Clone** your fork: `git clone https://github.com/saydum/site-policy.git`
3. **Create** a new branch: `git checkout -b feature/your-feature`
4. **Commit** your changes: `git commit -am 'Add some feature'`
5. **Push** to your branch: `git push origin feature/your-feature`
6. **Open** a pull request

Please ensure your code follows the project's style guidelines and includes tests where applicable.

---
*This README was generated with ❤️ by ReadmeBuddy*
