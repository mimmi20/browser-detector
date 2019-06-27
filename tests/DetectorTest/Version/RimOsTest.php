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
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\RimOs;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class RimOsTest extends TestCase
{
    /**
     * @var \BrowserDetector\Version\RimOs
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(static::never())
            ->method('debug');
        $logger
            ->expects(static::never())
            ->method('info');
        $logger
            ->expects(static::never())
            ->method('notice');
        $logger
            ->expects(static::never())
            ->method('warning');
        $logger
            ->expects(static::never())
            ->method('error');
        $logger
            ->expects(static::never())
            ->method('critical');
        $logger
            ->expects(static::never())
            ->method('alert');
        $logger
            ->expects(static::never())
            ->method('emergency');

        /* @var LoggerInterface $logger */
        $this->object = new RimOs($logger, new VersionFactory());
    }

    /**
     * @dataProvider providerVersion
     *
     * @param string      $useragent
     * @param string|null $expectedVersion
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testTestdetectVersion(string $useragent, ?string $expectedVersion): void
    {
        $detectedVersion = $this->object->detectVersion($useragent);

        static::assertInstanceOf(VersionInterface::class, $detectedVersion);
        static::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array[]
     */
    public function providerVersion(): array
    {
        return [
            [
                'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Mobile Safari/537.35+',
                '10.0.0',
            ],
            [
                'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.3.3.3057 Mobile Safari/537.35+',
                '10.3.3.3057',
            ],
            [
                'FlyCast/1.34 (BlackBerry; 8330/4.5.0.131 Profile/MIDP-2.0 Configuration/CLDC-1.1 VendorID/-1)',
                '4.5.0.131',
            ],
            [
                'BlackBerry8530/5.0.0.973 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/105',
                '5.0.0.973',
            ],
            [
                'Opera/9.80 (BlackBerry; Opera Mini/8.0.35667/35.7561; U; en) Presto/2.8.119 Version/11.10',
                null,
            ],
        ];
    }
}
