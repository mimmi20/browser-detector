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

use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\PlatformLoader;
use Psr\Log\NullLogger;
use Stringy\Stringy;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class PlatformFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $cache        = new FilesystemAdapter('', 0, __DIR__ . '/../../cache/');
        $logger       = new NullLogger();
        $loader       = new PlatformLoader($cache, $logger);
        $this->object = new PlatformFactory($loader);
    }

    /**
     * @dataProvider providerDetect
     *
     * @param string      $agent
     * @param string|null $platform
     * @param string|null $version
     * @param string|null $manufacturer
     * @param int|null    $bits
     *
     * @return void
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testDetect(string $agent, ?string $platform, ?string $version, ?string $manufacturer, ?int $bits): void
    {
        $normalizer = (new NormalizerFactory())->build();

        $normalizedUa = $normalizer->normalize($agent);

        /* @var \UaResult\Os\OsInterface $result */
        $result = $this->object->detect($normalizedUa, new Stringy($normalizedUa));

        self::assertInstanceOf('\UaResult\Os\OsInterface', $result);
        self::assertSame(
            $platform,
            $result->getName(),
            'Expected platform name to be "' . $platform . '" (was "' . $result->getName() . '")'
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
            'Expected bits count to be "' . $bits . '" (was "' . $result->getBits() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        $sourceDirectory = 'tests/data/factory/platform/';
        $iterator        = new \RecursiveDirectoryIterator($sourceDirectory);

        $tests = [];

        foreach (new \RecursiveIteratorIterator($iterator) as $file) {
            /* @var $file \SplFileInfo */
            if (!$file->isFile() || 'json' !== $file->getExtension()) {
                continue;
            }

            $subfileTests = json_decode(file_get_contents($file->getPathname()), true);

            foreach ($subfileTests as $subfileTest) {
                if ('this is a fake ua to trigger the fallback' === $subfileTest['ua']) {
                    continue;
                }

                $tests[$subfileTest['ua']] = $subfileTest;
            }
        }

        $fileTests = json_decode(file_get_contents('tests/data/factory/platform.json'), true);

        foreach ($fileTests as $fileTest) {
            if (array_key_exists($fileTest['ua'], $tests)) {
                continue;
            }

            $tests[$fileTest['ua']] = $fileTest;
        }

        return $tests;
    }
}
