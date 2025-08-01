<?php declare(strict_types=1);

/**
 * Siteation - https://siteation.dev/
 * Copyright © Siteation. All rights reserved.
 * See LICENSE file for details.
 */

namespace Siteation\Pagespeed\Config;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class SpeculatonConfig
{
    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function getConfig(string $attribute): mixed
    {
        $path = sprintf('siteation_pagespeed/speculation_rules/%s', $attribute);
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE);
    }

    public function getArrayConfig(string $attribute, string $savedKey = 'path'): array
    {
        $value = $this->getConfig($attribute);
        $flatArray = [];

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $value = $decoded;
            }
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if (is_array($item) && isset($item[$savedKey])) {
                    $flatArray[] = $item[$savedKey];
                }
            }
        }

        return $flatArray;
    }
}
