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
use BrowserDetector\Parser\PlatformParser;
use BrowserDetector\Parser\PlatformParserFactory;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class PlatformParserFactoryTest extends TestCase
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
        $logger        = $this->createMock(LoggerInterface::class);
        $jsonParser    = $this->createMock(JsonInterface::class);
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        \assert($logger instanceof LoggerInterface);
        \assert($jsonParser instanceof JsonInterface);
        \assert($companyLoader instanceof CompanyLoaderInterface);
        $factory = new PlatformParserFactory($logger, $jsonParser, $companyLoader);

        $parser = $factory();

        self::assertInstanceOf(PlatformParserInterface::class, $parser);
        self::assertInstanceOf(PlatformParser::class, $parser);
    }
}
