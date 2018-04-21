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
use UaResult\Engine\EngineInterface;

trait EngineTestDetectTrait
{
    /**
     * @var \BrowserDetector\Factory\EngineFactory
     */
    private $object;

    /**
     * @dataProvider providerDetect
     *
     * @param string      $agent
     * @param string|null $engine
     * @param string|null $version
     * @param string|null $manufacturer
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testDetect(string $agent, ?string $engine, ?string $version, ?string $manufacturer): void
    {
        $normalizer = (new NormalizerFactory())->build();

        $normalizedUa = $normalizer->normalize($agent);

        $object = $this->object;

        /* @var \UaResult\Engine\EngineInterface $result */
        $result = $object($normalizedUa);

        self::assertInstanceOf(EngineInterface::class, $result);
        self::assertSame(
            $engine,
            $result->getName(),
            'Expected Engine name to be "' . $engine . '" (was "' . $result->getName() . '")'
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
    }
}
