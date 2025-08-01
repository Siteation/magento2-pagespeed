<?php declare(strict_types=1);

/**
 * Core Web Vitals module for Magento
 *
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2021 Siteation (https://siteation.dev/)
 * @license MIT
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Siteation_Pagespeed',
    __DIR__
);
