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

use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Factory\NormalizerFactory;
use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\PlatformLoader;
use Psr\Log\NullLogger;
use Stringy\Stringy;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class BrowserFactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Factory\BrowserFactory
     */
    private $object;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $platformFactory;

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
        $loader       = new BrowserLoader($cache, $logger);
        $this->object = new BrowserFactory($loader);

        $platformLoader        = new PlatformLoader($cache, $logger);
        $this->platformFactory = new PlatformFactory($platformLoader);
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
     * @return void
     * @throws \Psr\Cache\InvalidArgumentException
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

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        $sourceDirectory = 'tests/data/factory/browser/';
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

                if (array_key_exists($subfileTest['ua'], $tests)) {
                    echo 'UA "', $subfileTest['ua'], '" was already added', PHP_EOL;

                    continue;
                }

                $tests[$subfileTest['ua']] = $subfileTest;
            }
        }

        $fileTests = json_decode(file_get_contents('tests/data/factory/browser.json'), true);

        foreach ($fileTests as $fileTest) {
            if (array_key_exists($fileTest['ua'], $tests)) {
                continue;
            }

            $tests[$fileTest['ua']] = $fileTest;
        }

        return $tests;
    }
}
