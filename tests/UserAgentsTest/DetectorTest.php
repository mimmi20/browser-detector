<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace UserAgentsTest;

use BrowserDetector\DetectorFactory;
use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\CompanyLoaderFactory;
use BrowserDetector\Loader\Helper\Filter;
use ExceptionalJSON\DecodeErrorException;
use ExceptionalJSON\EncodeErrorException;
use JsonClass\Json;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use UaResult\Browser\BrowserInterface;
use UaResult\Device\DeviceInterface;
use UaResult\Engine\EngineInterface;
use UaResult\Os\OsInterface;
use UaResult\Result\Result;
use UaResult\Result\ResultInterface;

final class DetectorTest extends TestCase
{
    /** @var \BrowserDetector\Detector */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     *
     * @coversNothing
     */
    protected function setUp(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
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

        $cache = new class() implements CacheInterface {
            /**
             * Fetches a value from the cache.
             *
             * @param mixed $key     the unique key of this item in the cache
             * @param mixed $default default value to return if the key does not exist
             *
             * @throws \Psr\SimpleCache\InvalidArgumentException
             *                                                   MUST be thrown if the $key string is not a legal value
             *
             * @return mixed the value of the item from the cache, or $default in case of cache miss
             */
            public function get($key, $default = null)
            {
                return null;
            }

            /**
             * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
             *
             * @param mixed                  $key   the key of the item to store
             * @param mixed                  $value the value of the item to store, must be serializable
             * @param \DateInterval|int|null $ttl   Optional. The TTL value of this item. If no value is sent and
             *                                      the driver supports TTL then the library may set a default value
             *                                      for it or let the driver take care of that.
             *
             * @throws \Psr\SimpleCache\InvalidArgumentException
             *                                                   MUST be thrown if the $key string is not a legal value
             *
             * @return bool true on success and false on failure
             */
            public function set($key, $value, $ttl = null): bool
            {
                return false;
            }

            /**
             * Delete an item from the cache by its unique key.
             *
             * @param mixed $key the unique cache key of the item to delete
             *
             * @throws \Psr\SimpleCache\InvalidArgumentException
             *                                                   MUST be thrown if the $key string is not a legal value
             *
             * @return bool True if the item was successfully removed. False if there was an error.
             */
            public function delete($key): bool
            {
                return false;
            }

            /**
             * Wipes clean the entire cache's keys.
             *
             * @return bool true on success and false on failure
             */
            public function clear(): bool
            {
                return false;
            }

            /**
             * Obtains multiple cache items by their unique keys.
             *
             * @param mixed $keys    a list of keys that can obtained in a single operation
             * @param mixed $default default value to return for keys that do not exist
             *
             * @throws \Psr\SimpleCache\InvalidArgumentException MUST be thrown if $keys is neither an array nor a Traversable,
             *                                                   or if any of the $keys are not a legal value
             *
             * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
             */
            public function getMultiple($keys, $default = null): iterable
            {
                return [];
            }

            /**
             * Persists a set of key => value pairs in the cache, with an optional TTL.
             *
             * @param mixed                  $values a list of key => value pairs for a multiple-set operation
             * @param \DateInterval|int|null $ttl    Optional. The TTL value of this item. If no value is sent and
             *                                       the driver supports TTL then the library may set a default value
             *                                       for it or let the driver take care of that.
             *
             * @throws \Psr\SimpleCache\InvalidArgumentException
             *                                                   MUST be thrown if $values is neither an array nor a Traversable,
             *                                                   or if any of the $values are not a legal value
             *
             * @return bool true on success and false on failure
             */
            public function setMultiple($values, $ttl = null): bool
            {
                return false;
            }

            /**
             * Deletes multiple cache items in a single operation.
             *
             * @param mixed $keys a list of string-based keys to be deleted
             *
             * @throws \Psr\SimpleCache\InvalidArgumentException
             *                                                   MUST be thrown if $keys is neither an array nor a Traversable,
             *                                                   or if any of the $keys are not a legal value
             *
             * @return bool True if the items were successfully removed. False if there was an error.
             */
            public function deleteMultiple($keys): bool
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
             * @param mixed $key the cache item key
             *
             * @throws \Psr\SimpleCache\InvalidArgumentException
             *                                                   MUST be thrown if the $key string is not a legal value
             *
             * @return bool
             */
            public function has($key): bool
            {
                return false;
            }
        };

        \assert($logger instanceof LoggerInterface);
        $factory      = new DetectorFactory($cache, $logger);
        $this->object = $factory();
    }

    /**
     * @dataProvider providerGetBrowser
     *
     * @param array  $headers
     * @param Result $expectedResult
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \BrowserDetector\Loader\NotFoundException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     *
     * @coversNothing
     */
    public function testGetBrowser(array $headers, Result $expectedResult): void
    {
        $result = $this->object->__invoke($headers);
        \assert($result instanceof ResultInterface, sprintf('$result should be an instance of %s, but is %s', ResultInterface::class, get_class($result)));

        try {
            $encodedHeaders = (new Json())->encode($headers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } catch (EncodeErrorException $e) {
            $encodedHeaders = '< failed to encode headers >';
        }

        self::assertInstanceOf(
            ResultInterface::class,
            $result,
            sprintf(
                'found result is not an instance of "\UaResult\Result\ResultInterface" for headers %s',
                $encodedHeaders
            )
        );

        $foundBrowser = $result->getBrowser();

        self::assertInstanceOf(
            BrowserInterface::class,
            $foundBrowser,
            sprintf(
                'found browser is not an instance of "\UaResult\Browser\BrowserInterface" for headers %s',
                $encodedHeaders
            )
        );

        $foundEngine = $result->getEngine();

        self::assertInstanceOf(
            EngineInterface::class,
            $foundEngine,
            sprintf(
                'found engine is not an instance of "\UaResult\Engine\EngineInterface" for headers %s',
                $encodedHeaders
            )
        );

        $foundPlatform = $result->getOs();

        self::assertInstanceOf(
            OsInterface::class,
            $foundPlatform,
            sprintf(
                'found platform is not an instance of "\UaResult\Os\OsInterface" for headers %s',
                $encodedHeaders
            )
        );

        $foundDevice = $result->getDevice();

        self::assertInstanceOf(
            DeviceInterface::class,
            $foundDevice,
            sprintf(
                'found result is not an instance of "\UaResult\Device\DeviceInterface" for headers %s',
                $encodedHeaders
            )
        );

        self::assertEquals(
            $expectedResult,
            $result,
            sprintf(
                'detection result mismatch for headers %s',
                $encodedHeaders
            )
        );
    }

    /**
     * @throws \Exception
     *
     * @return array[]
     */
    public function providerGetBrowser(): array
    {
        $finder = new Finder();
        $finder->files();
        $finder->name('*.json');
        $finder->ignoreDotFiles(true);
        $finder->ignoreVCS(true);
        $finder->ignoreUnreadableDirs();
        $finder->in('tests/data/');

        $data       = [];
        $logger     = new NullLogger();
        $jsonParser = new Json();

        $companyLoaderFactory = new CompanyLoaderFactory($jsonParser, new Filter());

        $companyLoader = $companyLoaderFactory();
        \assert($companyLoader instanceof CompanyLoader, sprintf('$companyLoader should be an instance of %s, but is %s', CompanyLoader::class, get_class($companyLoader)));
        $resultFactory = new ResultFactory($companyLoader);

        foreach ($finder as $file) {
            \assert($file instanceof SplFileInfo);

            try {
                $tests = (new Json())->decode(
                    $file->getContents(),
                    true
                );
            } catch (DecodeErrorException $e) {
                throw new \Exception(sprintf('file "%s" contains invalid json', $file->getPathname()), 0, $e);
            }

            foreach ($tests as $i => $test) {
                $expectedResult = $resultFactory->fromArray($logger, $test);

                if (null === $expectedResult) {
                    continue;
                }

                $index = sprintf('file:%s test:%d', $file->getRelativePathname(), $i);

                $data[$index] = [
                    'headers' => $expectedResult->getHeaders(),
                    'result' => $expectedResult,
                ];
            }
        }

        return $data;
    }
}
