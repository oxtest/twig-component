<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\Twig\Extensions;

use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\AddUrlParametersLogic;
use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\SeoUrlLogic;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class UrlExtension extends AbstractExtension
{
    public function __construct(private SeoUrlLogic $seoUrlLogic, private AddUrlParametersLogic $addUrlParametersLogic)
    {
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('seo_url', [$this, 'getSeoUrl'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('add_url_parameters', [$this, 'addUrlParameters'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Output SEO style url
     *
     * @param array $parameters
     *
     * @return null|string
     */
    public function getSeoUrl(array $parameters): ?string
    {
        $url = $this->seoUrlLogic->seoUrl($parameters);

        $dynamicParameters = $parameters['params'] ?? false;
        if ($dynamicParameters) {
            $url = $this->addUrlParameters($url, $dynamicParameters);
        }

        return $url;
    }

    /**
     * Add additional parameters to url
     *
     * @param string $url               Url
     * @param string $dynamicParameters Dynamic URL parameters
     *
     * @return string
     */
    public function addUrlParameters(string $url, string $dynamicParameters): string
    {
        return $this->addUrlParametersLogic->addUrlParameters($url, $dynamicParameters);
    }
}
