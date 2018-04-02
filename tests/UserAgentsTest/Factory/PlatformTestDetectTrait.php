<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UserAgentsTest\Factory;

use BrowserDetector\Version\Version;
use UaNormalizer\NormalizerFactory;
use UaResult\Os\OsInterface;

trait PlatformTestDetectTrait
{
    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $object;

    /**
     * @dataProvider providerDetect
     *
     * @param string      $agent
     * @param string|null $platform
     * @param string|null $version
     * @param string|null $manufacturer
     * @param int|null    $bits
     *
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testDetect(string $agent, ?string $platform, ?string $version, ?string $manufacturer, ?int $bits): void
    {
        $normalizer = (new NormalizerFactory())->build();

        $normalizedUa = $normalizer->normalize($agent);

        $object = $this->object;

        /* @var \UaResult\Os\OsInterface $result */
        $result = $object($normalizedUa);

        self::assertInstanceOf(OsInterface::class, $result);
        self::assertSame(
            $platform,
            $result->getName(),
            'Expected platform name to be "' . $platform . '" (was "' . $result->getName() . '")'
        );

        self::assertInstanceOf(Version::class, $result->getVersion());
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
            'Expected bits count to be "' . $bits . '" (was "' . $result->getBits() . '")'
        );
    }
}
