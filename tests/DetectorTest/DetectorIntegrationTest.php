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
use JsonException;
use Monolog\Handler\BufferHandler;
use Monolog\Handler\PsrHandler;
use Monolog\Logger;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;
use Stringable;
use Symfony\Component\Cache\Adapter\NullAdapter;
use Symfony\Component\Cache\Psr16Cache;
use UnexpectedValueException;

use function assert;
use function file_get_contents;
use function in_array;
use function is_array;
use function is_string;
use function json_decode;
use function sprintf;
use function str_replace;

use const JSON_THROW_ON_ERROR;
use const PHP_EOL;

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
#[Group(name: 'integration')]
final class DetectorIntegrationTest extends TestCase
{
    private static DetectorFactory $detectorFactory;
    private Detector $detector;

    /** @throws void */
    #[Override]
    public static function setUpBeforeClass(): void
    {
        $logger = new class () extends AbstractLogger {
            /**
             * Detailed debug information.
             *
             * @param array<mixed> $context
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            #[Override]
            public function debug(string | Stringable $message, array $context = []): void
            {
                // do nothing here
            }

            /**
             * Logs with an arbitrary level.
             *
             * @param int|string   $level
             * @param array<mixed> $context
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             * @phpcs:disable SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
             */
            #[Override]
            public function log($level, string | Stringable $message, array $context = []): void
            {
                echo '[', $level, '] ', $message, PHP_EOL;
            }
        };

        $logger = new Logger(
            name: 'browser-detector',
            handlers: [
                new BufferHandler(
                    handler: new PsrHandler($logger),
                    bufferLimit: 0,
                    level: LogLevel::WARNING,
                    bubble: false,
                    flushOnOverflow: false,
                ),
            ],
        );

        $cache = new Psr16Cache(new NullAdapter());

        assert($logger instanceof LoggerInterface);
        self::$detectorFactory = new DetectorFactory($cache, $logger);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[Override]
    protected function setUp(): void
    {
        $this->detector = (self::$detectorFactory)();
    }

    /**
     * @param array<non-empty-string, non-empty-string> $headers
     * @param array<string, mixed>                      $expected
     *
     * @throws Exception
     * @throws UnexpectedValueException
     * @throws ExpectationFailedException
     * @throws RuntimeException
     */
    #[DataProvider(methodName: 'providerUa')]
    public function testData(array $headers, array $expected): void
    {
        $result = $this->detector->getBrowser($headers);

        // if (($headers['user-agent'] ?? '') === 'Mozilla/5.0 (Linux; Android 12; Pixel 4a (5G) Build/SQ1A.220205.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.101 Mobile Safari/537.36 HuaweiBrowser/12.0.1.302 HMSCore/6.4.0.307') {
        //     var_dump($headers, $expected, $result);
        // }

        self::assertEquals($expected, $result);
    }

    /**
     * @return list<array<mixed>>
     *
     * @throws UnexpectedValueException
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerUa(): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator('data/integration-tests'),
        );
        $files    = new FilterIterator($iterator, 'json');
        $data     = [];

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $content = file_get_contents($filepath);

            if (in_array($content, [false, '', PHP_EOL], strict: true)) {
                continue;
            }

            try {
                $fileData = json_decode($content, associative: true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                echo new \Exception(
                    sprintf('could not decode file %s', $file),
                    0,
                    $e,
                ), PHP_EOL;

                continue;
            }

            assert(is_array($fileData));

            foreach ($fileData as $entry) {
                if (!is_array($entry)) {
                    continue;
                }

                $data[] = $entry;
            }
        }

        return $data;
    }
}
