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
use ExceptionalJSON\DecodeErrorException;
use JsonClass\Json;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

class RulesTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeFail(): void
    {
        $jsonParser = $this->getMockBuilder(Json::class)
            ->disableOriginalConstructor()
            ->setMethods(['decode'])
            ->getMock();

        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with('{"key": "value"}')
            ->will(self::throwException(new DecodeErrorException(0, 'error', '')));

        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->setMethods(['getContents'])
            ->getMock();
        $file
            ->expects(self::once())
            ->method('getContents')
            ->will(self::returnValue('{"key": "value"}'));

        /** @var Json $jsonParser */
        /** @var SplFileInfo $file */
        $object = new Rules($file, $jsonParser);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file "" contains invalid json');
        $object();
    }

    /**
     * @return void
     */
    public function testInvokeSuccess(): void
    {
        $jsonParser = $this->getMockBuilder(Json::class)
            ->disableOriginalConstructor()
            ->setMethods(['decode'])
            ->getMock();

        $jsonParser
            ->expects(self::once())
            ->method('decode')
            ->with('{"key": "value"}')
            ->will(self::returnValue(['rules' => ['abc'], 'generic' => 'test']));

        $file = $this->getMockBuilder(SplFileInfo::class)
            ->disableOriginalConstructor()
            ->setMethods(['getContents'])
            ->getMock();
        $file
            ->expects(self::once())
            ->method('getContents')
            ->will(self::returnValue('{"key": "value"}'));

        /** @var Json $jsonParser */
        /** @var SplFileInfo $file */
        $object = new Rules($file, $jsonParser);

        $object();

        self::assertTrue($object->isInitialized());
        self::assertSame(['abc'], $object->getRules());
        self::assertSame('test', $object->getDefault());
    }
}
