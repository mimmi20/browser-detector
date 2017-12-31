<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Cache\Cache;
use BrowserDetector\Factory\Browser\EdgeBasedFactory;
use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\PlatformLoader;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Stringy\Stringy;
use Symfony\Component\Cache\Simple\FilesystemCache;

trait BrowserTestDetectTrait
{
    /**
     * @var \BrowserDetector\Factory\Browser\EdgeBasedFactory
     */
    private $object;

    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $platformFactory;

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        PlatformLoader::resetInstance();
        BrowserLoader::resetInstance();
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string      $userAgent
     * @param string|null $browser
     * @param string|null $version
     * @param string|null $manufacturer
     * @param int|null    $bits
     * @param string|null $type
     *
     * @throws \Psr\Cache\InvalidArgumentException
     *
     * @return void
     */
    public function testDetect(string $userAgent, ?string $browser, ?string $version, ?string $manufacturer, ?int $bits, ?string $type): void
    {
        $normalizer = (new NormalizerFactory())->build();

        $normalizedUa = $normalizer->normalize($userAgent);

        $s = new Stringy($normalizedUa);

        $platform = $this->platformFactory->detect($normalizedUa, $s);

        /* @var \UaResult\Browser\BrowserInterface $result */
        [$result] = $this->object->detect($normalizedUa, $s, $platform);

        self::assertInstanceOf('\UaResult\Browser\BrowserInterface', $result);
        self::assertSame(
            $browser,
            $result->getName(),
            'Expected browser name to be "' . $browser . '" (was "' . $result->getName() . '")'
        );

        self::assertInstanceOf('\BrowserDetector\Version\Version', $result->getVersion());
        self::assertSame(
            $version,
            $result->getVersion()->getVersion(),
            'Expected version to be "' . $version . '" (was "' . $result->getVersion()->getVersion() . '")'
        );

        self::assertSame(
            $manufacturer,
            $result->getManufacturer()->getName(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
        );

        self::assertSame(
            $bits,
            $result->getBits(),
            'Expected browser bits to be "' . $bits . '" (was "' . $result->getBits() . '")'
        );

        self::assertSame(
            $type,
            $result->getType()->getName(),
            'Expected browser type to be "' . $type . '" (was "' . $result->getType()->getName() . '")'
        );
    }
}
