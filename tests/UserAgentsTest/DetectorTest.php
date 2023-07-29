<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace UserAgentsTest;

use BrowserDetector\Detector;
use BrowserDetector\DetectorFactory;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Version\NotNumericException;
use DateInterval;
use Exception;
use JsonException;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use RuntimeException;
use Stringable;
use UaResult\Browser\BrowserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;

use function assert;
use function file_get_contents;
use function is_array;
use function is_iterable;
use function is_string;
use function json_decode;
use function json_encode;
use function sprintf;

use const JSON_THROW_ON_ERROR;
use const JSON_UNESCAPED_SLASHES;
use const JSON_UNESCAPED_UNICODE;
use const PHP_EOL;

/** @infection-ignore-all */
final class DetectorTest extends TestCase
{
    private static DetectorFactory $factory;
    private Detector $object;

    /** @throws void */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
             */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
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
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
             */
            public function has(string $key): bool
            {
                return false;
            }
        };

        assert($logger instanceof LoggerInterface);
        self::$factory = new DetectorFactory($cache, $logger);
    }

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws void
     */
    #[CoversNothing]
    protected function setUp(): void
    {
        $this->object = (self::$factory)();
    }

    /**
     * @param array<string, string> $headers
     *
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     */
    #[DataProvider('providerGetBrowser')]
    #[CoversNothing]
    public function testGetBrowser(array $headers, Result $expectedResult): void
    {
        $result = ($this->object)($headers);
        assert(
            $result instanceof ResultInterface,
            sprintf(
                '$result should be an instance of %s, but is %s',
                ResultInterface::class,
                $result::class,
            ),
        );

        try {
            $encodedHeaders = json_encode(
                $headers,
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
            );
        } catch (JsonException) {
            $encodedHeaders = '< failed to encode headers >';
        }

        self::assertInstanceOf(
            ResultInterface::class,
            $result,
            sprintf(
                'found result is not an instance of "\UaResult\Result\ResultInterface" for headers %s',
                $encodedHeaders,
            ),
        );

        $foundBrowser = $result->getBrowser();

        self::assertInstanceOf(
            BrowserInterface::class,
            $foundBrowser,
            sprintf(
                'found browser is not an instance of "\UaResult\Browser\BrowserInterface" for headers %s',
                $encodedHeaders,
            ),
        );

        $foundEngine = $result->getEngine();

        self::assertInstanceOf(
            EngineInterface::class,
            $foundEngine,
            sprintf(
                'found engine is not an instance of "\UaResult\Engine\EngineInterface" for headers %s',
                $encodedHeaders,
            ),
        );

        $foundPlatform = $result->getOs();

        self::assertInstanceOf(
            OsInterface::class,
            $foundPlatform,
            sprintf(
                'found platform is not an instance of "\UaResult\Os\OsInterface" for headers %s',
                $encodedHeaders,
            ),
        );

        $foundDevice = $result->getDevice();

        self::assertInstanceOf(
            DeviceInterface::class,
            $foundDevice,
            sprintf(
                'found result is not an instance of "\UaResult\Device\DeviceInterface" for headers %s',
                $encodedHeaders,
            ),
        );

        self::assertSame(
            $expectedResult,
            $result,
            sprintf(
                'detection result mismatch for headers %s',
                $encodedHeaders,
            ),
        );
    }

    /**
     * @return array<string, array<string, (array<string, string>|Result)>>
     *
     * @throws Exception
     * @throws NotNumericException
     * @throws RuntimeException
     */
    public static function providerGetBrowser(): array
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('tests/data/'));
        $files    = new RegexIterator($iterator, '/^.+\.json$/i', RegexIterator::GET_MATCH);

        $data   = [];
        $logger = new NullLogger();

        $companyLoaderFactory = new CompanyLoaderFactory();

        $companyLoader = $companyLoaderFactory();
        assert(
            $companyLoader instanceof CompanyLoader,
            sprintf(
                '$companyLoader should be an instance of %s, but is %s',
                CompanyLoader::class,
                $companyLoader::class,
            ),
        );
        $resultFactory = new ResultFactory($companyLoader, $logger);

        foreach ($files as $file) {
            assert(is_array($file));

            $file = $file[0];
            assert(is_string($file));

            $content = @file_get_contents($file);

            if ($content === false) {
                throw new RuntimeException(sprintf('could not read file "%s"', $file));
            }

            try {
                $tests = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new Exception(sprintf('file "%s" contains invalid json', $file), 0, $e);
            }

            assert(is_iterable($tests));

            foreach ($tests as $i => $test) {
                $expectedResult = $resultFactory->fromArray($logger, $test);

                if (!$expectedResult instanceof Result) {
                    continue;
                }

                $index = sprintf('file:%s test:%d', $file, $i);

                $data[$index] = [
                    'headers' => $expectedResult->getHeaders(),
                    'result' => $expectedResult,
                ];
            }
        }

        return $data;
    }
}
