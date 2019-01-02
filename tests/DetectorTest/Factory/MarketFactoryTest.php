<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\MarketFactory;
use PHPUnit\Framework\TestCase;
use UaResult\Device\MarketInterface;

class MarketFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testFromEmptyArray(): void
    {
        $object = new MarketFactory();

        $result = $object->fromArray([]);

        self::assertInstanceOf(MarketInterface::class, $result);
        self::assertIsArray($result->getVendors());
        self::assertSame([], $result->getVendors());
        self::assertIsArray($result->getCountries());
        self::assertSame([], $result->getCountries());
        self::assertIsArray($result->getRegions());
        self::assertSame([], $result->getRegions());
    }

    /**
     * @return void
     */
    public function testFromArray(): void
    {
        $vendors   = ['test-vendor'];
        $regions   = ['test-region'];
        $countries = ['test-country'];
        $object    = new MarketFactory();

        $result = $object->fromArray(['vendors' => $vendors, 'regions' => $regions, 'countries' => $countries]);

        self::assertInstanceOf(MarketInterface::class, $result);
        self::assertIsArray($result->getVendors());
        self::assertSame($vendors, $result->getVendors());
        self::assertIsArray($result->getCountries());
        self::assertSame($countries, $result->getCountries());
        self::assertIsArray($result->getRegions());
        self::assertSame($regions, $result->getRegions());
    }

    /**
     * @return void
     */
    public function testFromStdClass(): void
    {
        $vendors      = new \stdClass();
        $vendors->x   = 'test-vendor';
        $regions      = new \stdClass();
        $regions->x   = 'test-region';
        $countries    = new \stdClass();
        $countries->x = 'test-country';
        $object       = new MarketFactory();

        $result = $object->fromArray(['vendors' => $vendors, 'regions' => $regions, 'countries' => $countries]);

        self::assertInstanceOf(MarketInterface::class, $result);
        self::assertIsArray($result->getVendors());
        self::assertSame([$vendors->x], $result->getVendors());
        self::assertIsArray($result->getCountries());
        self::assertSame([$countries->x], $result->getCountries());
        self::assertIsArray($result->getRegions());
        self::assertSame([$regions->x], $result->getRegions());
    }
}
