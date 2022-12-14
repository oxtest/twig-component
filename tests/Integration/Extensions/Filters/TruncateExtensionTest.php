<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\Twig\Tests\Integration\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\TruncateLogic;
use OxidEsales\Twig\Extensions\Filters\TruncateExtension;
use OxidEsales\Twig\Tests\Integration\Extensions\AbstractExtensionTest;
use Twig\Extension\AbstractExtension;

final class TruncateExtensionTest extends AbstractExtensionTest
{
    protected AbstractExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new TruncateExtension(new TruncateLogic());
        parent::setUp();
    }

    /**
     * @dataProvider truncateProvider
     */
    public function testTruncate(string $template, string $expected): void
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    public function truncateProvider(): array
    {
        return [
            [
                "{{ 'Duis iaculis pellentesque felis, et pulvinar elit lacinia at. Suspendisse dapibus pulvinar sem vitae.'|truncate }}",
                "Duis iaculis pellentesque felis, et pulvinar elit lacinia at. Suspendisse..."
            ],
            [
                "{{ 'Duis iaculis &#039;pellentesque&#039; felis, et &quot;pulvinar&quot; elit lacinia at. Suspendisse dapibus pulvinar sem vitae.'|truncate }}",
                "Duis iaculis &#039;pellentesque&#039; felis, et &quot;pulvinar&quot; elit lacinia at. Suspendisse..."
            ],
            [
                "{{ '&#039;Duis&#039; &#039;iaculis&#039; &#039;pellentesque&#039; felis, et &quot;pulvinar&quot; elit lacinia at. Suspendisse dapibus pulvinar sem vitae.'|truncate }}",
                "&#039;Duis&#039; &#039;iaculis&#039; &#039;pellentesque&#039; felis, et &quot;pulvinar&quot; elit lacinia at...."
            ],
        ];
    }

    /**
     * @dataProvider truncateProviderWithLength
     */
    public function testTruncateWithLength(string $template, string $expected): void
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    public function truncateProviderWithLength(): array
    {
        return [
            [
                "{{ 'Duis iaculis pellentesque felis, et pulvinar elit.'|truncate(20) }}",
                "Duis iaculis..."
            ],
            [
                "{{ 'Duis iaculis &#039;pellentesque&#039; felis, et &quot;pulvinar&quot; elit.'|truncate(20) }}",
                "Duis iaculis..."
            ],
            [
                "{{ '&#039;Duis&#039; &#039;iaculis&#039; &#039;pellentesque&#039; felis, et &quot;pulvinar&quot; elit.'|truncate(20) }}",
                "&#039;Duis&#039; &#039;iaculis&#039;..."
            ],
        ];
    }

    /**
     * @dataProvider truncateProviderWithSuffix
     */
    public function testTruncateWithSuffix(string $template, string $expected): void
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    public function truncateProviderWithSuffix(): array
    {
        return [
            [
                "{{ 'Duis iaculis pellentesque felis, et pulvinar elit lacinia at. Suspendisse dapibus pulvinar sem vitae.'|truncate(80, ' (...)') }}",
                "Duis iaculis pellentesque felis, et pulvinar elit lacinia at. Suspendisse (...)"
            ],
        ];
    }

    /**
     * @dataProvider truncateProviderWithBreakWords
     */
    public function testTruncateWithBreakWords(string $template, string $expected): void
    {
        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }

    public function truncateProviderWithBreakWords(): array
    {
        return [
            [
                "{{ 'Duis iaculis pellentesque felis, et pulvinar elit lacinia at. Suspendisse dapibus pulvinar sem vitae.'|truncate(80, '...', true) }}",
                "Duis iaculis pellentesque felis, et pulvinar elit lacinia at. Suspendisse dap..."
            ],
        ];
    }
}
