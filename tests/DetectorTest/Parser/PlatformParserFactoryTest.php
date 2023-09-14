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

namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\PlatformParser;
use BrowserDetector\Parser\PlatformParserFactory;
use BrowserDetector\Parser\PlatformParserInterface;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class PlatformParserFactoryTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $logger        = $this->createMock(LoggerInterface::class);
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        $factory = new PlatformParserFactory($logger, $companyLoader);

        $parser = $factory();

        self::assertInstanceOf(PlatformParserInterface::class, $parser);
        self::assertInstanceOf(PlatformParser::class, $parser);
    }
}
