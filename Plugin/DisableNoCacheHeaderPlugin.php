<?php declare(strict_types=1);

/**
 * @author Siteation (https://siteation.dev/)
 * @copyright Copyright 2021 Siteation (https://siteation.dev/)
 * @license MIT
 */

namespace Siteation\Pagespeed\Plugin;

use ArrayIterator;
use Closure;
use Laminas\Http\Header\HeaderInterface;
use Siteation\Pagespeed\Config\BfcacheConfig;
use Magento\Framework\App\Response\Http;

class DisableNoCacheHeaderPlugin
{
    public function __construct(
        private BfcacheConfig $config
    ) {
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param Http $subject
     * @param Closure $proceed
     * @return void
     */
    public function aroundSetNoCacheHeaders(Http $subject, Closure $proceed): void
    {
        $header = $subject->getHeader('Cache-Control');

        $proceed();

        if ($this->isCacheable($header)) {
            $maxAge = $this->config->getMaxAge();
            $subject->setHeader('cache-control', 'public, max-age='.$maxAge, true);
            $subject->clearHeader('pragma');
        }
    }

    private function isCacheable($header): bool
    {
        if (!$header) {
            return false;
        }

        if ($header instanceof HeaderInterface) {
            return $this->doesHeaderValueAllowCaching($header->getFieldValue());
        }

        if ($header instanceof ArrayIterator) {
            foreach ($header as $subheader) {
                if ($subheader instanceof HeaderInterface) {
                    return $this->doesHeaderValueAllowCaching($subheader->getFieldValue());
                }
            }
        }

        return false;
    }

    private function doesHeaderValueAllowCaching(string $headerValue): bool
    {
        if (str_contains($headerValue, 'no-cache')) {
            return false;
        }

        if (str_contains($headerValue, 'no-store')) {
            return false;
        }

        return true;
    }
}
