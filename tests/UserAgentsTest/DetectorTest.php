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

namespace UserAgentsTest;

use BrowserDetector\Detector;
use BrowserDetector\DetectorFactory;
use BrowserDetector\Iterator\FilterIterator;
use BrowserDetector\Version\Exception\NotNumericException;
use Exception;
use JsonException;
use Monolog\Handler\BufferHandler;
use Monolog\Handler\PsrHandler;
use Monolog\Logger;
use Override;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Psr\SimpleCache\InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;
use Stringable;
use Symfony\Component\Cache\Adapter\NullAdapter;
use Symfony\Component\Cache\Psr16Cache;

use function assert;
use function file_get_contents;
use function in_array;
use function is_array;
use function is_iterable;
use function is_scalar;
use function is_string;
use function json_decode;
use function json_encode;
use function sprintf;
use function str_replace;
use function var_export;

use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;
use const PHP_EOL;

/** @infection-ignore-all */
#[CoversNothing]
#[Group(name: 'integration')]
final class DetectorTest extends TestCase
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
     * @param array<string, mixed>                      $expectedResult
     *
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     */
    #[DataProvider(methodName: 'providerGetBrowser')]
    public function testGetBrowser(array $headers, array $expectedResult): void
    {
        $result = $this->detector->getBrowser($headers);
        assert(is_array($result));

        try {
            $encodedHeaders = json_encode(
                $headers,
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
            );
        } catch (JsonException) {
            $encodedHeaders = '< failed to encode headers >';
        }

        self::assertIsArray(
            $result,
            sprintf(
                'found result is not an array for headers %s',
                $encodedHeaders,
            ),
        );

        self::assertEquals(
            $expectedResult['headers'],
            $result['headers'] ?? [],
            sprintf(
                "detection header result mismatch for headers %s\ntest headers:%s\nexpected result: %s\nactual result: %s",
                $encodedHeaders,
                var_export($headers, return: true),
                var_export($expectedResult['headers'], return: true),
                var_export($result['headers'] ?? [], return: true),
            ),
        );

        self::assertEquals(
            $expectedResult,
            $result,
            sprintf(
                "detection result mismatch for headers %s\ntest headers:%s\nexpected result: %s\nactual result: %s",
                $encodedHeaders,
                var_export($headers, return: true),
                var_export($expectedResult, return: true),
                var_export($result, return: true),
            ),
        );
    }

    /**
     * @return array<string, array<int, mixed>>
     *
     * @throws Exception
     * @throws NotNumericException
     * @throws RuntimeException
     */
    public static function providerGetBrowser(): array
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('data/tests/'));
        $files    = new FilterIterator($iterator, 'json');

        $data = [];

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            $content = file_get_contents($filepath);

            if (in_array($content, [false, '', PHP_EOL], strict: true)) {
                continue;
            }

            try {
                $tests = json_decode($content, associative: true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                echo new Exception(
                    sprintf('could not decode file %s', $file),
                    0,
                    $e,
                ), PHP_EOL;

                continue;
            }

            assert(is_iterable($tests));

            foreach ($tests as $i => $expectedResult) {
                if (!is_array($expectedResult)) {
                    continue;
                }

                if (!is_scalar($i)) {
                    continue;
                }

                $index = sprintf('file:%s test:%d', $filepath, $i);

                $data[$index] = [
                    $expectedResult['headers'],
                    $expectedResult,
                ];
            }
        }

        return $data;
    }
}
