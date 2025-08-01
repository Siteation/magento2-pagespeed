# Magento 2 - Core Web Vitals & Page Speed Optimization

[![Packagist Version](https://img.shields.io/packagist/v/siteation/magento2-pagespeed?style=for-the-badge)](https://packagist.org/packages/siteation/magento2-pagespeed)
[![Packagist Downloads](https://img.shields.io/packagist/dt/siteation/magento2-pagespeed.svg?style=for-the-badge)](https://packagist.org/packages/siteation/magento2-pagespeed)
[![Packagist License](https://img.shields.io/packagist/l/siteation/magento2-pagespeed.svg?style=for-the-badge)](https://github.com/Siteation/magento2-pagespeed/blob/main/LICENSE)

---

A Magento 2 module that leverages modern web performance technologies including Back/Forward Cache (bfcache), Page Prerendering, and View Transitions API to dramatically improve Core Web Vitals and overall page speed performance. This module provides cutting-edge optimizations to enhance your store's loading times and create seamless user experiences.

---

## 📦 Installation

```bash
# Install via composer
composer require siteation/magento2-pagespeed

# Enable the module
php bin/magento module:enable Siteation_Pagespeed

# Run setup upgrade
php bin/magento setup:upgrade

# Compile DI (if needed)
php bin/magento setup:di:compile

# Deploy static content (if needed)
php bin/magento setup:static-content:deploy
```

---

## ⚙️ Configuration

The module configuration can be found in:
**Stores > Configuration > Siteation > Page Speed**

### Configuration Sections

#### Back/Forward Cache (bfcache)
Configure browser cache optimization for instant back/forward navigation:
- Enable bfcache compatibility
- Optimize page lifecycle events
- Prevent cache eviction scenarios
- Configure unload handlers properly

#### Specialization Rules (Prerendering Rules)
Set up intelligent page prerendering for faster navigation:
- Configure speculation rules for link prerendering
- Target high-traffic pages for prerendering
- Optimize prerender triggers and conditions
- Manage resource usage during prerendering

#### View Transitions API
Enable smooth visual transitions between page views:
- Configure seamless page transitions
- Customize transition animations and effects
- Optimize for single-page app-like experiences
- Handle cross-document transitions

---

## 🚀 Features

### Core Web Vitals Optimization
- **Largest Contentful Paint (LCP)** improvements through prerendering
- **First Input Delay (FID)** optimization via bfcache instant navigation
- **Cumulative Layout Shift (CLS)** reduction with smooth view transitions

### Modern Web Performance Technologies

#### Back/Forward Cache (bfcache)
- **Instant Navigation**: Pages load instantly when using back/forward buttons
- **Cache Optimization**: Intelligent page lifecycle management
- **Resource Efficiency**: Preserve JavaScript state and reduce network requests
- **Event Handling**: Proper pageshow/pagehide event management

#### Page Prerendering
- **Speculation Rules API**: Intelligent prerendering based on user intent
- **Link Prerendering**: Prerender likely navigation targets
- **Resource Management**: Efficient prerender resource allocation
- **Conditional Loading**: Smart prerender triggers based on user behavior

#### View Transitions API
- **Smooth Transitions**: Native browser transitions between pages
- **Custom Animations**: Configure transition effects and timing
- **Cross-Document Support**: Seamless transitions across different pages
- **Performance Optimized**: Hardware-accelerated animations

### Advanced Configuration
- Multiple configuration sections for granular control
- Enable/disable specific optimizations per page type
- Fine-tune performance settings based on store requirements
- Real-time performance monitoring and optimization suggestions

---

## 🏆 About Siteation

We're a Dutch Magento agency dedicated to creating high-quality, performance-focused e-commerce solutions.

- 🌐 **Website**: [siteation.dev](https://siteation.dev/)
- 📧 **Email**: [info@siteation.dev](mailto:info@siteation.dev)
- 🐦 **Twitter**: [@Siteation](https://twitter.com/Siteation)

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🤝 Contributing

We welcome contributions! Please feel free to submit a Pull Request.

---

## 🐛 Issues

If you encounter any issues, please [create an issue](https://github.com/Siteation/magento2-pagespeed/issues) on GitHub.