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
use UaResult\Browser\BrowserInterface;

trait BrowserTestDetectTrait
{
    /**
     * @var \BrowserDetector\Factory\BrowserFactory
     */
    private $object;

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
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testDetect(string $userAgent, ?string $browser, ?string $version, ?string $manufacturer, ?int $bits, ?string $type): void
    {
        $normalizer = (new NormalizerFactory())->build();

        $normalizedUa = $normalizer->normalize($userAgent);

        $object = $this->object;

        /* @var \UaResult\Browser\BrowserInterface $result */
        [$result] = $object($normalizedUa);

        self::assertInstanceOf(BrowserInterface::class, $result);
        self::assertSame(
            $browser,
            $result->getName(),
            'Expected browser name to be "' . $browser . '" (was "' . $result->getName() . '")'
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
            'Expected browser bits to be "' . $bits . '" (was "' . $result->getBits() . '")'
        );

        self::assertSame(
            $type,
            $result->getType()->getName(),
            'Expected browser type to be "' . $type . '" (was "' . $result->getType()->getName() . '")'
        );
    }
}
