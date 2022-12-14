<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\Twig\Escaper;

use Twig\Environment;

/**
 * Escape unescaped single quotes
 */
class QuotesEscaper implements EscaperInterface
{
    /**
     * @return string
     */
    public function getStrategy(): string
    {
        return 'quotes';
    }

    /**
     * Escape unescaped single quotes
     *
     * @param Environment $environment
     * @param string      $string
     * @param string      $charset
     *
     * @return string
     */
    public function escape(Environment $environment, $string, $charset): string
    {
        return preg_replace("%(?<!\\\\)'%", "\\'", $string);
    }
}
