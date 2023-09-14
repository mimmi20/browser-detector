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

namespace BrowserDetectorTest;

use BrowserDetector\GenericRequest;
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
    public function testGetBrowserFromUaString(): void
    {
        $useragent = 'testagent';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
        );

        $result = $object->buildRequest($useragent);
        assert(
            $result instanceof GenericRequest,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequest::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequest::class, $result);
        self::assertSame(['user-agent' => $useragent], $result->getHeaders());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetBrowserFromHeaderArray(): void
    {
        $useragent = 'testagent';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
        );

        $result = $object->buildRequest(
            ['user-agent' => $useragent, 1 => $useragent . "\r" . $useragent, 'x-test' => $useragent . "\r\n" . $useragent],
        );
        assert(
            $result instanceof GenericRequest,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequest::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequest::class, $result);
        self::assertSame(
            ['user-agent' => $useragent, 'x-test' => $useragent . '-' . $useragent],
            $result->getHeaders(),
        );
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testGetBrowserFromMessage(): void
    {
        $useragent = 'testagent';

        $deviceParser      = $this->createMock(DeviceParserInterface::class);
        $platformParser    = $this->createMock(PlatformParserInterface::class);
        $browserParser     = $this->createMock(BrowserParserInterface::class);
        $engineParser      = $this->createMock(EngineParserInterface::class);
        $normalizerFactory = new NormalizerFactory();

        $object = new RequestBuilder(
            $deviceParser,
            $platformParser,
            $browserParser,
            $engineParser,
            $normalizerFactory,
        );

        $message = ServerRequestFactory::fromGlobals(
            ['HTTP_USER_AGENT' => $useragent, 'HTTP_X_TEST' => $useragent . "\r\n " . $useragent],
        );

        $result = $object->buildRequest($message);
        assert(
            $result instanceof GenericRequest,
            sprintf(
                '$result should be an instance of %s, but is %s',
                GenericRequest::class,
                $result::class,
            ),
        );

        self::assertInstanceOf(GenericRequest::class, $result);
        self::assertSame(
            ['user-agent' => $useragent, 'x-test' => $useragent . ' ' . $useragent],
            $result->getHeaders(),
        );
    }
}
