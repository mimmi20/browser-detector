<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest;

use BrowserDetector\GenericRequestInterface;
use BrowserDetector\Header\HeaderInterface;
use BrowserDetector\Loader\BrowserLoaderInterface;
use BrowserDetector\Loader\EngineLoaderInterface;
use BrowserDetector\Loader\PlatformLoaderInterface;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use BrowserDetector\RequestBuilder;
use Laminas\Diactoros\ServerRequestFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UaNormalizer\NormalizerFactory;

use function assert;
use function sprintf;

final class RequestBuilderTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testBuildRequestFromUaString(): void
    {
        $useragent = 'testagent';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $result = $object->buildRequest($useragent);
        assert(
            $result instanceof GenericRequestInterface,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequestInterface::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequestInterface::class, $result);
        self::assertSame(['user-agent' => $useragent], $result->getHeaders());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testBuildRequestFromHeaderArray(): void
    {
        $useragent = 'testagent';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $result = $object->buildRequest(
            ['user-agent' => $useragent, 1 => $useragent . "\r" . $useragent, 'x-test' => $useragent . "\r\n" . $useragent],
        );
        assert(
            $result instanceof GenericRequestInterface,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequestInterface::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequestInterface::class, $result);
        self::assertSame(
            ['user-agent' => $useragent, 'x-test' => $useragent . '-' . $useragent],
            $result->getHeaders(),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testBuildRequestFromMessage(): void
    {
        $useragent = 'testagent';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $message = ServerRequestFactory::fromGlobals(
            ['HTTP_USER_AGENT' => $useragent, 'HTTP_X_TEST' => $useragent . "\r\n " . $useragent],
        );

        $result = $object->buildRequest($message);
        assert(
            $result instanceof GenericRequestInterface,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequestInterface::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequestInterface::class, $result);
        self::assertSame(
            ['user-agent' => $useragent, 'x-test' => $useragent . ' ' . $useragent],
            $result->getHeaders(),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testBuildRequestFromRequest(): void
    {
        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $request = new class () implements GenericRequestInterface {
            /**
             * @return array<non-empty-string, non-empty-string>
             *
             * @throws void
             */
            public function getHeaders(): array
            {
                return [];
            }

            /**
             * @return array<non-empty-string, HeaderInterface>
             *
             * @throws void
             */
            public function getFilteredHeaders(): array
            {
                return [];
            }

            /** @throws void */
            public function getHash(): string
            {
                return '';
            }
        };

        $result = $object->buildRequest($request);
        assert(
            $result instanceof GenericRequestInterface,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequestInterface::class,
                $result::class,
            ),
        );

        self::assertSame($request, $result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testBuildRequestFromHeaderArray2(): void
    {
        $useragent     = '+Simple Browser';
        $requestedWith = 'com.massimple.nacion.parana.es';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $result = $object->buildRequest(
            [
                'user-agent' => $useragent,
                'http-x-requested-with' => $requestedWith,
            ],
        );
        assert(
            $result instanceof GenericRequestInterface,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequestInterface::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequestInterface::class, $result);
        self::assertSame(
            ['user-agent' => $useragent, 'x-requested-with' => $requestedWith],
            $result->getHeaders(),
        );

        $filteredHeaders = $result->getFilteredHeaders();

        self::assertCount(2, $filteredHeaders);
        self::assertArrayHasKey('user-agent', $filteredHeaders);
        self::assertArrayHasKey('x-requested-with', $filteredHeaders);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testBuildRequestFromHeaderArray3(): void
    {
        $useragent     = '+Simple Browser';
        $requestedWith = 'com.massimple.nacion.parana.es';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $result = $object->buildRequest(
            [
                'user-agent' => $useragent,
                'http_x-requested-with' => $requestedWith,
            ],
        );
        assert(
            $result instanceof GenericRequestInterface,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequestInterface::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequestInterface::class, $result);
        self::assertSame(
            ['user-agent' => $useragent, 'x-requested-with' => $requestedWith],
            $result->getHeaders(),
        );

        $filteredHeaders = $result->getFilteredHeaders();

        self::assertCount(2, $filteredHeaders);
        self::assertArrayHasKey('user-agent', $filteredHeaders);
        self::assertArrayHasKey('x-requested-with', $filteredHeaders);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testBuildRequestFromHeaderArray4(): void
    {
        $useragent     = '+Simple Browser';
        $requestedWith = 'com.massimple.nacion.parana.es';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $browserLoader     = $this->createMock(BrowserLoaderInterface::class);
        $platformLoader    = $this->createMock(PlatformLoaderInterface::class);
        $engineLoader      = $this->createMock(EngineLoaderInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
            $browserLoader,
            $platformLoader,
            $engineLoader,
        );

        $result = $object->buildRequest(
            [
                'user-agent' => $useragent,
                'http+x-requested-with' => $requestedWith,
            ],
        );
        assert(
            $result instanceof GenericRequestInterface,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequestInterface::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequestInterface::class, $result);
        self::assertSame(
            ['user-agent' => $useragent, 'http+x-requested-with' => $requestedWith],
            $result->getHeaders(),
        );

        $filteredHeaders = $result->getFilteredHeaders();

        self::assertCount(1, $filteredHeaders);
        self::assertArrayHasKey('user-agent', $filteredHeaders);
    }
}
