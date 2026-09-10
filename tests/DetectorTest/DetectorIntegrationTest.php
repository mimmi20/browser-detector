<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest;

use BrowserDetector\Collection\Headers;
use BrowserDetector\Detector;
use BrowserDetector\DetectorFactory;
use BrowserDetector\Iterator\FilterIterator;
use BrowserDetector\Loader\BrowserLoader;
use BrowserDetector\Loader\DeviceLoader;
use BrowserDetector\Loader\DeviceLoaderFactory;
use BrowserDetector\Loader\EngineLoader;
use BrowserDetector\Loader\PlatformLoader;
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\DeviceParser;
use BrowserDetector\Parser\EngineParser;
use BrowserDetector\Parser\PlatformParser;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Constraint\IsType;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\NativeType;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
#[CoversClass(className: Detector::class)]
#[CoversClass(className: Headers::class)]
#[CoversClass(className: PlatformParser::class)]
#[CoversClass(className: BrowserParser::class)]
#[CoversClass(className: DeviceParser::class)]
#[CoversClass(className: EngineParser::class)]
#[CoversClass(className: DeviceLoaderFactory::class)]
#[CoversClass(className: DeviceLoader::class)]
#[CoversClass(className: EngineLoader::class)]
#[CoversClass(className: BrowserLoader::class)]
#[CoversClass(className: PlatformLoader::class)]
final class DetectorIntegrationTest extends TestCase
{
    /**
     * @param array<non-empty-string, non-empty-string> $headers
     * @param array<string, mixed>                      $expected
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws ExpectationFailedException
     * @throws RuntimeException
     * @throws \Laminas\Hydrator\Exception\InvalidArgumentException
     */
    #[DataProvider(methodName: 'providerUa')]
    public function testData(array $headers, array $expected): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        $cache = $this->createMock(CacheInterface::class);
        $cache
            ->expects(self::never())
            ->method('get');
        $cache
            ->expects(self::once())
            ->method('set');
        $cache
            ->expects(self::never())
            ->method('delete');
        $cache
            ->expects(self::never())
            ->method('clear');
        $cache
            ->expects(self::never())
            ->method('getMultiple');
        $cache
            ->expects(self::never())
            ->method('setMultiple');
        $cache
            ->expects(self::never())
            ->method('deleteMultiple');
        $cache
            ->expects(self::once())
            ->method('has')
            ->with(new IsType(NativeType::String))
            ->willReturn(value: false);

        $detectorFactory = new DetectorFactory($cache, $logger);
        $detector        = $detectorFactory();

        $result = $detector->getBrowser($headers);

        self::assertSame($expected, $result);
    }

    /**
     * @return array<int, array<int, mixed>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerUa(): array
    {
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator('data/integation-tests'));
        $files    = new FilterIterator($iterator, 'yaml');
        $data     = [];

        foreach ($files as $file) {
            assert($file instanceof \SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $fileData = Yaml::parseFile($filepath);

            assert(is_array($fileData));

            foreach ($fileData as $entry) {
                $data[] = $entry;
            }
        }

        return $data;
    }
}
