<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\Twig\Extensions\Filters;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * @deprecated
 */
class PhpFunctionsExtension extends AbstractExtension
{
    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('parse_url', 'parse_url'),
            new TwigFilter('oxNew', 'oxNew'),
            new TwigFilter('strtotime', 'strtotime'),
            new TwigFilter('is_array', 'is_array'),
            new TwigFilter('urlencode', 'urlencode'),
            new TwigFilter('addslashes', 'addslashes'),
            new TwigFilter('getimagesize', 'getimagesize')
        ];
    }
}
