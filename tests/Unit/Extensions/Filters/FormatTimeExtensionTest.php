<?php declare(strict_types=1);
/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace OxidEsales\Twig\Tests\Unit\Extensions\Filters;

use OxidEsales\EshopCommunity\Internal\Adapter\TemplateLogic\FormatTimeLogic;
use OxidEsales\Twig\Extensions\Filters\FormatTimeExtension;
use PHPUnit\Framework\TestCase;

class FormatTimeExtensionTest extends TestCase
{
    public function provider(): array
    {
        return [
            [0, '00:00:00'],
            [77834, '21:37:14'],
            [460800, '128:00:00']
        ];
    }

    /**
     * @param int    $seconds
     * @param string $expectedTime
     *
     * @dataProvider provider
     */
    public function testFormatTime(int $seconds, string $expectedTime): void
    {
        $formatTimeLogic = new FormatTimeLogic();
        $formatTimeExtension = new FormatTimeExtension($formatTimeLogic);
        $formattedTime = $formatTimeExtension->formatTime($seconds);
        $this->assertEquals($expectedTime, $formattedTime);
    }
}
