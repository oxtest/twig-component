<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace OxidEsales\Twig\Subscriber;

use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\FinalizingModuleActivationEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\FinalizingModuleDeactivationEvent;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Setup\Event\ModuleSetupEvent;
use OxidEsales\Twig\TwigContextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;

class InvalidateCacheEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private TwigContextInterface $twigContext, private Filesystem $filesystem)
    {
    }

    public function invalidateCache(ModuleSetupEvent $event)
    {
        $this->filesystem->remove($this->twigContext->getCacheDir());
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FinalizingModuleActivationEvent::class   => 'invalidateCache',
            FinalizingModuleDeactivationEvent::class => 'invalidateCache',
        ];
    }
}
