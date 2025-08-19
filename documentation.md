# Siteation Magento 2 Pagespeed Module - Documentation

## Overview

The **Siteation Magento 2 Pagespeed** module is designed to dramatically improve your Magento store's Core Web Vitals and overall page speed performance by leveraging modern web performance technologies. Specifically, it implements:

- [View Transitions API](https://web.dev/view-transitions/)
- [Speculation Rules (Page Prerendering)](https://web.dev/speculation-rules/)
- [Back/Forward Cache (bfcache)](https://web.dev/bfcache/)

These techniques help to enhance loading times, create seamless navigation, and deliver a smooth, app-like user experience for your customers.

---

## Functionalities and Implementation Details

### 1. View Transitions

#### What it is
The [View Transitions API](https://web.dev/view-transitions/) allows for smooth animated transitions between different DOM states or pages, creating visually appealing navigation without abrupt content changes.

#### How it's implemented in Magento 2

- The module injects view transition logic via frontend template files such as `view-transition.phtml` and `hyva/view-transition.phtml`.
- For **Hyvä Themes**, there is additional logic to smoothly animate transitions between product gallery and product list items, as seen in the script section of `view/frontend/templates/page/js/hyva/view-transition.phtml`. It checks for `prefers-reduced-motion` and sets a `viewTransitionName` on navigation events:
  ```javascript
  const setTransitionNameBetweenGallery = async (url, promise) => {
      // ...logic to handle view transitions
  };
  window.addEventListener('pageswap', async (e) => {
      if (!e.viewTransition) return;
      // ...trigger transition
  });
  ```
- In the **Luma theme**, only the CSS @view-transition rule is injected because of JavaScript loading limitations.

**References:**  
- [web.dev - View Transitions](https://web.dev/view-transitions/)
- [MDN - View Transitions API](https://developer.mozilla.org/en-US/docs/Web/API/View_Transitions_API)

---

### 2. Speculation Rules (Page Prerendering)

#### What it is
[Speculation Rules](https://web.dev/speculation-rules/) is a browser feature that allows for prefetching or prerendering of pages based on navigation predictions, thus speeding up perceived load times for users.

#### How it's implemented in Magento 2

- The module injects a `<script type="speculationrules">` block into the page. This script defines which URLs should be prerendered, leveraging the [Speculation Rules API](https://web.dev/speculation-rules/).
- Exclusion rules are configurable (default excludes customer/account, checkout, wishlist, search, etc.) to avoid prerendering sensitive or dynamic areas:
  ```php
  public function getExcludeList(): string
  {
      $value = $this->config->getArrayConfig('exclude_list');
      if (empty($value)) {
          $value[] = "/customer/*";
          $value[] = "/checkout/*";
          // ...other exclusions
      }
      return json_encode($value, JSON_UNESCAPED_SLASHES);
  }
  ```
- The rendered script in the frontend (see `speculationrules.phtml` and `hyva/speculationrules.phtml`) looks like:
  ```html
  <script type="speculationrules">
  {
      "tag": "siteation_pagespeed",
      "prerender": [{
          "source": "document",
          "where": {
              "and": [
                  { "href_matches": "/*" },
                  { "not": { "href_matches": [exclusions...] } },
                  { "not": { "selector_matches": ".do-not-prerender" } },
                  { "not": { "selector_matches": "[download]" } },
                  { "not": { "selector_matches": "[rel~=nofollow]" } }
              ]
          },
          "eagerness": "moderate"
      }]
  }
  </script>
  ```
- This ensures that only safe, cacheable, and frequently accessed URLs are prerendered, making navigation between pages nearly instant.

**References:**  
- [web.dev - Speculation Rules](https://web.dev/speculation-rules/)
- [Speculation Rules API explainer (Google Chrome Docs)](https://github.com/WICG/nav-speculation)

---

### 3. Back Forward Cache (bfcache)

#### What it is
The [Back/Forward Cache (bfcache)](https://web.dev/bfcache/) is a browser feature that allows instant restoration of pages when users navigate with the browser's back or forward buttons, by storing a full snapshot of the page in memory.

#### How it's implemented in Magento 2

- The module ensures that Magento's HTTP responses do not contain headers that would block bfcache. It does so by overriding the default "no-cache" headers on eligible pages using the `DisableNoCache` plugin.
  ```php
  public function aroundSetNoCacheHeaders(Http $subject, \Closure $proceed): void
  {
      if ($this->config->isEnabled() && !$this->shouldSkip()) {
          $subject->setHeader('cache-control', 'public, max-age=5', true);
      } else {
          $proceed();
      }
  }
  ```
- It uses configuration to determine which URLs should be excluded from bfcache, e.g., AJAX requests or certain routes.
- To ensure dynamic content like the minicart stays up-to-date when a page is restored from bfcache, the module adds a `pageshow` event listener. If the page is loaded from bfcache, it refreshes customer-related sections:
  ```javascript
  window.addEventListener('pageshow', (event) => {
      if (event.persisted) {
          require(['Magento_Customer/js/customer-data'], function (customerData) {
              const sections = ['cart'];
              customerData.invalidate(sections);
              customerData.reload(sections, true);
          });
      }
  });
  ```
- For Hyvä theme, a similar event is used to trigger data refresh.

**References:**  
- [web.dev - Back/Forward Cache](https://web.dev/bfcache/)

---

## Summary

The Siteation Magento 2 Pagespeed module brings cutting-edge web performance features to Magento by integrating View Transitions, Speculation Rules, and Back/Forward Cache support. Each of these features is thoughtfully implemented to maximize performance while maintaining Magento’s flexibility and security.

If you want the fastest, most seamless Magento store navigation possible—leveraging browser-native optimizations—this module is a modern solution, with configuration options to tailor it to your needs.

---
**For more information, see:**
- [Siteation Pagespeed on GitHub](https://github.com/Siteation/magento2-pagespeed)
- [web.dev Core Web Vitals](https://web.dev/vitals/)