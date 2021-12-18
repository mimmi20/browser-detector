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
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\BrowserParserFactory;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use SebastianBergmann\RecursionContext\InvalidArgumentException;

final class BrowserParserFactoryTest extends TestCase
{
    /**
     * @throws InvalidArgumentException
     * @throws ExpectationFailedException
     * @throws Exception
     * @throws \InvalidArgumentException
     */
    public function testInvoke(): void
    {
        $logger        = $this->createMock(LoggerInterface::class);
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $engineParser  = $this->createMock(EngineParserInterface::class);

        $factory = new BrowserParserFactory($logger, $companyLoader, $engineParser);

        $parser = $factory();

        self::assertInstanceOf(BrowserParserInterface::class, $parser);
        self::assertInstanceOf(BrowserParser::class, $parser);
    }
}
