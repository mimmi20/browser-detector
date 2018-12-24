<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: Besitzer
 * Date: 24.12.2018
 * Time: 13:12
 */
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\DeviceParser;
use BrowserDetector\Parser\DeviceParserFactory;
use BrowserDetector\Parser\DeviceParserInterface;
use BrowserDetector\Parser\PlatformParserInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class DeviceParserFactoryTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $logger         = $this->createMock(LoggerInterface::class);
        $jsonParser     = $this->createMock(JsonInterface::class);
        $companyLoader  = $this->createMock(CompanyLoaderInterface::class);
        $platformParser = $this->createMock(PlatformParserInterface::class);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Parser\PlatformParserInterface $platformParser */
        $factory = new DeviceParserFactory($logger, $jsonParser, $companyLoader, $platformParser);

        $parser = $factory();

        self::assertInstanceOf(DeviceParserInterface::class, $parser);
        self::assertInstanceOf(DeviceParser::class, $parser);
    }
}
