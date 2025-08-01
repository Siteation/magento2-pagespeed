<?php declare(strict_types=1);

/**
 * Core Web Vitals module for Magento
 *
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2021 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\Pagespeed\ViewModel;

use Siteation\Pagespeed\Config\SpeculatonConfig;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class SpeculationRules implements ArgumentInterface
{
    /**
     * @var SpeculatonConfig
     */
    private SpeculatonConfig $config;

    public function __construct(SpeculatonConfig $config)
    {
        $this->config = $config;
    }

    public function getExcludeList(): string
    {
        $value = $this->config->getArrayConfig('exclude_list');

        if (empty($value)) {
            $value[] = "/customer/*";
            $value[] = "*/customer/*";
            $value[] = "/search/*";
            $value[] = "*/search/*";
            $value[] = "/wishlist/*";
            $value[] = "*/wishlist/*";
            $value[] = "/checkout/*";
            $value[] = "*/checkout/*";
            $value[] = "/paypal/*";
            $value[] = "*/paypal/*";
            $value[] = "*.pdf";
        }

        return json_encode($value, JSON_UNESCAPED_SLASHES);
    }

    public function getEagerness(): string
    {
        return $this->config->getConfig('eagerness');
    }
}