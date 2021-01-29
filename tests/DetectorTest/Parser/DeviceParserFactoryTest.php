<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\DeviceParser;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class DeviceParserFactoryTest extends TestCase
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $logger         = $this->createMock(LoggerInterface::class);
        $jsonParser     = $this->createMock(JsonInterface::class);
        $companyLoader  = $this->createMock(CompanyLoaderInterface::class);
        $platformParser = $this->createMock(PlatformParserInterface::class);

        \assert($logger instanceof LoggerInterface);
        \assert($jsonParser instanceof JsonInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        \assert($platformParser instanceof PlatformParserInterface);
        $factory = new DeviceParserFactory($logger, $jsonParser, $companyLoader, $platformParser);

        $parser = $factory();

        self::assertInstanceOf(DeviceParserInterface::class, $parser);
        self::assertInstanceOf(DeviceParser::class, $parser);
    }
}
