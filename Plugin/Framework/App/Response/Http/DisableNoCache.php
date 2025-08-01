<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2021 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\Pagespeed\Plugin\Framework\App\Response\Http;

use Siteation\Pagespeed\Config\BfcacheConfig;
use Magento\Catalog\Model\Indexer\Product\Price\AbstractAction;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http;

class DisableNoCache
{
    /**
     * @var BfcacheConfig
     */
    private BfcacheConfig $config;

    /**
     * @var HttpRequest
     */
    private HttpRequest $request;

    public function __construct(
        BfcacheConfig $config,
        HttpRequest $request
    ) {
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param AbstractAction $subject
     * @param array|int|null $ids
     *
     * @return array|null
     */
    public function aroundSetNoCacheHeaders(Http $subject, \Closure $proceed): void
    {
        if ($this->config->isEnabled() && !$this->shouldSkip()) {
            $subject->setHeader('cache-control', 'public, max-age=5', true);
        } else {
            $proceed();
        }
    }

    private function shouldSkip(): bool
    {
        if ($this->request->isAjax()) {
            return false;
        }

        $uriPath = $this->request->getUri()->getPath();
        $excludeRoutes = $this->config->getArrayConfig('exclude_list');

        foreach ($excludeRoutes as $ignoreRoute) {
            if (strpos($uriPath, $ignoreRoute) !== false) {
                return true;
            }
        }

        return false;
    }
}
