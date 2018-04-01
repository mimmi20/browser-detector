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
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Loader\NotFoundException;
use BrowserDetector\Version\Version;
use Stringy\Stringy;
use UaNormalizer\NormalizerFactory;
use UaResult\Engine\EngineInterface;

trait EngineTestDetectTrait
{
    /**
     * @var \BrowserDetector\Factory\EngineFactory
     */
    private $object;

    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $platformFactory;

    /**
     * @var \BrowserDetector\Loader\BrowserLoader
     */
    private $browserLoader;

    /**
     * @dataProvider providerDetect
     *
     * @param string      $userAgent
     * @param string|null $engine
     * @param string|null $version
     * @param string|null $manufacturer
     *
     * @throws \Psr\Cache\InvalidArgumentException
     *
     * @return void
     */
    public function testDetect(string $userAgent, ?string $engine, ?string $version, ?string $manufacturer): void
    {
//        $normalizer   = (new NormalizerFactory())->build();
//        $normalizedUa = $normalizer->normalize($userAgent);
//
//        $s = new Stringy($normalizedUa);
//
//        try {
//            $platform = $this->platformFactory->detect($normalizedUa, $s);
//        } catch (NotFoundException $e) {
//            $platform = null;
//        }
//
//        /* @var \UaResult\Engine\EngineInterface $result */
//        $result = $this->object->detect($normalizedUa, $s, $this->browserLoader, $platform);
//
//        self::assertInstanceOf(EngineInterface::class, $result);
//        self::assertSame(
//            $engine,
//            $result->getName(),
//            'Expected engine name to be "' . $engine . '" (was "' . $result->getName() . '")'
//        );
//
//        self::assertInstanceOf(Version::class, $result->getVersion());
//        self::assertSame(
//            $version,
//            $result->getVersion()->getVersion(),
//            'Expected version to be "' . $version . '" (was "' . $result->getVersion()->getVersion() . '")'
//        );
//
//        self::assertSame(
//            $manufacturer,
//            $result->getManufacturer()->getName(),
//            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer()->getName() . '")'
//        );
    }
}
