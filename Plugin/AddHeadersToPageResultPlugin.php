<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2021 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\Pagespeed\Plugin;

use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\Response\Http;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\Page;
use Siteation\Pagespeed\Config\BfcacheConfig;

class AddHeadersToPageResultPlugin
{
    public function __construct(
        private BfcacheConfig $config,
        private HttpRequest $request,
    ) {
    }

    public function afterRenderResult(
        Page $subject,
        Page $return,
        ResponseInterface $httpResponse
    ): Page {
        if (false === $this->config->isEnabled()) {
            return $return;
        }

        if (true === $this->shouldSkip($subject)) {
            return $return;
        }

        /** @var Http $httpResponse */
        $maxAge = $this->config->getMaxAge();
        $httpResponse->setHeader('cache-control', 'public, max-age='.$maxAge, true);

        return $return;
    }

    private function shouldSkip(Page $subject): bool
    {
        if ($this->request->isAjax()) {
            return true;
        }

        if (false === $this->request->isGet() && false === $this->request->isHead()) {
            return true;
        }

        if (false === $subject->getLayout()->isCacheable()) {
            return true;
        }

        return false;
    }
}
