<?php declare(strict_types=1);

/**
 * Siteation - https://siteation.dev/
 * Copyright © Siteation. All rights reserved.
 * See LICENSE file for details.
 */

namespace Siteation\Pagespeed\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class BfcacheConfig
{
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig) {
    }

    public function getConfig(string $attribute): mixed
    {
        $path = sprintf('siteation_pagespeed/bfcache/%s', $attribute);
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    public function isEnabled(): bool
    {
        return (bool) $this->getConfig('enable');
    }

    public function getMaxAge(): int
    {
        return (int) $this->getConfig('max_age');
    }
}
