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
namespace BrowserDetectorTest\Loader\Helper;

use BrowserDetector\Loader\Helper\Rules;
use PHPUnit\Framework\TestCase;
use Seld\JsonLint\JsonParser;
use Seld\JsonLint\ParsingException;
use Symfony\Component\Finder\SplFileInfo;

class RulesTest extends TestCase
{
    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeFail(): void
    {
        $jsonParser = $this->getMockBuilder(JsonParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['parse'])
            ->getMock();

        $jsonParser
            ->expects(self::once())
            ->method('parse')
            ->will(self::throwException(new ParsingException('error')));

        $file = $this->createMock(SplFileInfo::class);

        /** @var JsonParser $jsonParser */
        /** @var SplFileInfo $file */
        $object = new Rules($jsonParser, $file);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file "" contains invalid json');
        $object();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *
     * @return void
     */
    public function testInvokeSuccess(): void
    {
        $jsonParser = $this->getMockBuilder(JsonParser::class)
            ->disableOriginalConstructor()
            ->setMethods(['parse'])
            ->getMock();

        $jsonParser
            ->expects(self::once())
            ->method('parse')
            ->will(self::returnValue(['rules' => ['abc'], 'generic' => 'test']));

        $file = $this->createMock(SplFileInfo::class);

        /** @var JsonParser $jsonParser */
        /** @var SplFileInfo $file */
        $object = new Rules($jsonParser, $file);

        $object();

        self::assertTrue($object->isInitialized());
        self::assertSame(['abc'], $object->getRules());
        self::assertSame('test', $object->getDefault());
    }
}
