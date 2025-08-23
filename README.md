# Siteation - Magento 2 Pagespeed

[![Packagist Version](https://img.shields.io/packagist/v/siteation/magento2-pagespeed?style=for-the-badge)](https://packagist.org/packages/siteation/magento2-pagespeed)
[![License](https://img.shields.io/github/license/Siteation/magento2-pagespeed?color=%23234&style=for-the-badge)](/LICENSE)
![Supported Magento Versions](https://img.shields.io/badge/magento-%202.4-brightgreen.svg?logo=magento&longCache=true&style=for-the-badge)
[![Hyvä Supported](https://img.shields.io/badge/Hyva-Supported-3df0af.svg?longCache=true&style=for-the-badge)](https://hyva.io/)
[![Breeze Supported](https://img.shields.io/badge/Breeze-Supported-b10005.svg?longCache=true&style=for-the-badge)](https://hyva.io/)


A Magento 2 module that leverages modern web performance technologies including Back/Forward Cache (bfcache), Page Prerendering, and View Transitions API to dramatically improve Core Web Vitals and overall page speed performance.

This module provides optimizations to enhance your store's loading times and create seamless user experiences.

## Installation

Install the package via;

```sh
composer require siteation/magento2-pagespeed
bin/magento module:enable Siteation_Pagespeed
```

## How to use

The Pagespeed has the bfcache feature enabled by default.

For the speculation rules and view transitions you need to enable them from the configuration.

each option can be found in the Magento admin panel under Stores > Configuration > Siteation > Pagespeed.

### Use with Hyvä Themes

This module is fully compatible with Hyvä Themes, allowing you to take advantage of its performance optimizations while using this modern frontend solution.

But do note Hyvä Themes has its own speculation rules and view transitions,
so for Hyvä it is best to disable the default speculation rules and view transitions provided by Hyvä in favor of this module.

### Improved UX with bfcache

While this module makes sure to reload the customer data, it can not close the menus and other modals automatically.

This requires a update in the code of this component to handle the closing of these elements when the page is restored from the bfcache.

For this you can use the following snippets, based on the menu in Hyvä themes.

<details><summary>Hyvä Code Snippet</summary>

In your copy of `vendor/hyva-themes/magento2-default-theme/Magento_Theme/templates/html/header/menu/mobile.phtml` edit the follwing:

```diff
<nav
    x-data="initMenuMobile<?= $escaper->escapeHtml($uniqueId) ?>()"
    @keydown.window.escape="closeMenu()"
    class="z-20 order-2 sm:order-1 lg:order-2 navigation lg:hidden w-12 h-12"
    aria-label="<?= $escaper->escapeHtmlAttr(__('Site navigation')) ?>"
    role="navigation"
+++ x-bind="eventListeners"
>
```

```diff
const initMenuMobile<?= $escaper->escapeHtml($uniqueId) ?> = () => {
    return {
        mobilePanelActiveId: null,
        open: false,
        init() {
            this.setActiveMenu(this.$root);
        },
+++     eventListeners: {
+++		    ['@pageshow.window'](event) {
+++             if (event.persisted) {
+++                 this.open = false
+++             };
+++         }
+++     },
```

</details>

<details><summary>Breeze Code Snippet</summary>

In your copy of `vendor/swissup/module-breeze/view/frontend/web/js/components/menu.js` edit the follwing:

```diff
    this._on(document, 'keydown', e => {
        if (e.key === 'Escape' && $('html').hasClass('nav-open')) {
            this.close();
        }
    });

+++ this._on(window, "pageshow", e => {
+++     if (e.persisted) {
+++         this.close();
+++     }
+++ });
},
```

</details>

For Luma sadly we have no equivalent solution available at this time.