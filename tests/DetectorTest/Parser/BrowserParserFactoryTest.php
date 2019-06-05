<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
/**
 * Created by PhpStorm.
 * User: Besitzer
 * Date: 23.12.2018
 * Time: 20:07
 */
namespace BrowserDetectorTest\Parser;

use BrowserDetector\Loader\CompanyLoaderInterface;
use BrowserDetector\Parser\BrowserParser;
use BrowserDetector\Parser\BrowserParserFactory;
use BrowserDetector\Parser\BrowserParserInterface;
use BrowserDetector\Parser\EngineParserInterface;
use JsonClass\JsonInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class BrowserParserFactoryTest extends TestCase
{
    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \PHPUnit\Framework\Exception
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $logger        = $this->createMock(LoggerInterface::class);
        $jsonParser    = $this->createMock(JsonInterface::class);
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);
        $engineParser  = $this->createMock(EngineParserInterface::class);

        /** @var \Psr\Log\LoggerInterface $logger */
        /** @var \JsonClass\JsonInterface $jsonParser */
        /** @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        /** @var \BrowserDetector\Parser\EngineParserInterface $engineParser */
        $factory = new BrowserParserFactory($logger, $jsonParser, $companyLoader, $engineParser);

        $parser = $factory();

        static::assertInstanceOf(BrowserParserInterface::class, $parser);
        static::assertInstanceOf(BrowserParser::class, $parser);
    }
}
