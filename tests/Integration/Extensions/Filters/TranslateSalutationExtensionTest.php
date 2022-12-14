<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\Twig\Tests\Integration\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Transition\Adapter\TemplateLogic\TranslateSalutationLogic;
use OxidEsales\Twig\Extensions\Filters\TranslateSalutationExtension;
use OxidEsales\Twig\Tests\Integration\Extensions\AbstractExtensionTest;
use Twig\Extension\AbstractExtension;

final class TranslateSalutationExtensionTest extends AbstractExtensionTest
{
    protected AbstractExtension $extension;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setLanguage(0);
    }

    public function translateSalutationProvider(): array
    {
        return [
            ["{{ 'MR'|translate_salutation }}", 'Herr'],
            ["{{ 'MRS'|translate_salutation }}", 'Frau'],
        ];
    }

    /**
     * @dataProvider translateSalutationProvider
     */
    public function testTranslateSalutation(string $template, string $expected): void
    {
        $translateSalutationLogic = $this->getMockBuilder(TranslateSalutationLogic::class)
            ->setMethods(['translateSalutation'])->getMock();

        $translateSalutationLogic->expects($this->once())->method('translateSalutation')->willReturn(
            $expected
        );
        $this->extension = new TranslateSalutationExtension($translateSalutationLogic);

        $this->assertEquals($expected, $this->getTemplate($template)->render([]));
    }
}
