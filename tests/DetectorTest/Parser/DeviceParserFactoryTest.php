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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\DeviceParser;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class DeviceParserFactoryTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     */
    public function testInvoke(): void
    {
        $logger         = $this->createMock(LoggerInterface::class);
        $companyLoader  = $this->createMock(CompanyLoaderInterface::class);
        $platformParser = $this->createMock(PlatformParserInterface::class);

        $factory = new DeviceParserFactory($logger, $companyLoader, $platformParser);

        $parser = $factory();

        self::assertInstanceOf(DeviceParserInterface::class, $parser);
        self::assertInstanceOf(DeviceParser::class, $parser);
    }
}
