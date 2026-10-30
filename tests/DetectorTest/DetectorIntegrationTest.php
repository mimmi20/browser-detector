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
use DateInterval;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use SplFileInfo;
use Stringable;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use UnexpectedValueException;

use function assert;
use function is_array;
use function is_string;
use function sprintf;
use function str_replace;

use const PHP_EOL;

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

        $cache = new class () implements CacheInterface {
            /**
             * Fetches a value from the cache.
             *
             * @param string $key     the unique key of this item in the cache
             * @param mixed  $default default value to return if the key does not exist
             *
             * @return mixed the value of the item from the cache, or $default in case of cache miss
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            #[Override]
            public function get(string $key, mixed $default = null): mixed
            {
                return null;
            }

            /**
             * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
             *
             * @param string                $key   the key of the item to store
             * @param mixed                 $value the value of the item to store, must be serializable
             * @param DateInterval|int|null $ttl   Optional. The TTL value of this item. If no value is sent and
             *                                     the driver supports TTL then the library may set a default value
             *                                     for it or let the driver take care of that.
             *
             * @return bool true on success and false on failure
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            #[Override]
            public function set(string $key, mixed $value, int | DateInterval | null $ttl = null): bool
            {
                return false;
            }

            /**
             * Delete an item from the cache by its unique key.
             *
             * @param string $key the unique cache key of the item to delete
             *
             * @return bool True if the item was successfully removed. False if there was an error.
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            #[Override]
            public function delete(string $key): bool
            {
                return false;
            }

            /**
             * Wipes clean the entire cache's keys.
             *
             * @return bool true on success and false on failure
             *
             * @throws void
             */
            #[Override]
            public function clear(): bool
            {
                return false;
            }

            /**
             * Obtains multiple cache items by their unique keys.
             *
             * @param iterable<string> $keys    a list of keys that can obtained in a single operation
             * @param mixed            $default default value to return for keys that do not exist
             *
             * @return iterable<string, mixed> A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            #[Override]
            public function getMultiple(iterable $keys, mixed $default = null): iterable
            {
                return [];
            }

            /**
             * Persists a set of key => value pairs in the cache, with an optional TTL.
             *
             * @param iterable<string, mixed> $values a list of key => value pairs for a multiple-set operation
             * @param DateInterval|int|null   $ttl    Optional. The TTL value of this item. If no value is sent and
             *                                        the driver supports TTL then the library may set a default value
             *                                        for it or let the driver take care of that.
             *
             * @return bool true on success and false on failure
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            #[Override]
            public function setMultiple(iterable $values, int | DateInterval | null $ttl = null): bool
            {
                return false;
            }

            /**
             * Deletes multiple cache items in a single operation.
             *
             * @param iterable<string> $keys a list of string-based keys to be deleted
             *
             * @return bool True if the items were successfully removed. False if there was an error.
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            #[Override]
            public function deleteMultiple(iterable $keys): bool
            {
                return false;
            }

            /**
             * Determines whether an item is present in the cache.
             *
             * NOTE: It is recommended that has() is only to be used for cache warming type purposes
             * and not to be used within your live applications operations for get/set, as this method
             * is subject to a race condition where your has() will return true and immediately after,
             * another script can remove it making the state of your app out of date.
             *
             * @param string $key the cache item key
             *
             * @throws void
             *
             * @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            #[Override]
            public function has(string $key): bool
            {
                return false;
            }
        };

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

        self::assertSame($expected, $result);
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
        $files    = new FilterIterator($iterator, 'yaml');
        $data     = [];

        foreach ($files as $file) {
            assert($file instanceof SplFileInfo);

            $pathName = $file->getPathname();
            $filepath = str_replace('\\', '/', $pathName);
            assert(is_string($filepath));

            try {
                $fileData = Yaml::parseFile($filepath);
            } catch (ParseException $e) {
                echo new \Exception(
                    sprintf('could not parse file %s', $file),
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
