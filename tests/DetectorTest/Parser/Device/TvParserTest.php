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

namespace BrowserDetectorTest\Parser\Device;

use BrowserDetector\Parser\Device\TvParser;
use BrowserDetector\Parser\Helper\RulefileParserInterface;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

final class TvParserTest extends TestCase
{
    /** @throws ExpectationFailedException */
    public function testParse(): void
    {
        $useragent    = 'test-useragent';
        $expectedMode = 'test-mode';
        $genericMode  = 'genericMode';

        $fileParser = $this->getMockBuilder(RulefileParserInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $fileParser
            ->expects(self::exactly(2))
            ->method('parseFile')
            ->willReturn($genericMode, $expectedMode);

        $object = new TvParser($fileParser);

        self::assertSame($genericMode . '=' . $expectedMode, $object->parse($useragent));
    }
}
