<?php

namespace Kjonski\HowToBundle\Tests;

use Kjonski\HowToBundle\DependencyInjection\KjonskiHowToExtension;
use Kjonski\HowToBundle\KjonskiHowToBundle;
use PHPUnit\Framework\TestCase;

class KjonskiHowToBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new KjonskiHowToBundle();
        $this->assertInstanceOf(KjonskiHowToExtension::class, $bundle->getContainerExtension());
    }
}
