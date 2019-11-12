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

use BrowserDetector\Version\Macos;
use BrowserDetector\Version\VersionFactory;
use BrowserDetector\Version\VersionInterface;
use MacosBuild\MacosBuild;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

final class MacosTest extends TestCase
{
    /**
     * @dataProvider providerVersion
     *
     * @param string      $useragent
     * @param string|null $expectedVersion
     *
     * @throws \Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \UnexpectedValueException
     *
     * @return void
     */
    public function testTestdetectVersion(string $useragent, ?string $expectedVersion): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $logger
            ->expects(self::never())
            ->method('debug');
        $logger
            ->expects(self::never())
            ->method('info');
        $logger
            ->expects(self::never())
            ->method('notice');
        $logger
            ->expects(self::never())
            ->method('warning');
        $logger
            ->expects(self::never())
            ->method('error');
        $logger
            ->expects(self::never())
            ->method('critical');
        $logger
            ->expects(self::never())
            ->method('alert');
        $logger
            ->expects(self::never())
            ->method('emergency');

        /** @var LoggerInterface $logger */
        $object = new Macos($logger, new VersionFactory(), new MacosBuild());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array[]
     */
    public function providerVersion(): array
    {
        return [
            [
                'Downcast/2.9.11 (Mac OS X Version 10.11.3 (Build 15D13b))',
                '10.11.3-beta+2',
            ],
            [
                'Mail/3445.1.3 CFNetwork/887 Darwin/17.0.0 (x86_64)',
                '10.13.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10) AppleWebKit/534.48.3 (KHTML like Gecko) Version/5.1 Safari/534.48.3',
                '10.0.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 107) AppleWebKit/534.48.3 (KHTML like Gecko) Version/5.1 Safari/534.48.3',
                '10.7.0',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 1084) AppleWebKit/536.29.13 (KHTML like Gecko) Version/6.0.4 Safari/536.29.13',
                '10.8.4',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.5.17 (KHTML, like Gecko) Version/8.0.5 Safari/600.5.17',
                '10.10.4',
            ],
            [
                'Apple Mac OS X v10.11.3 CoreMedia v1.0.0.15D13b',
                '10.11.3-beta+2',
            ],
            [
                'Apple Mac OS X v10.11.3 CoreMedia v1.0.0.1X7',
                '10.11.3',
            ],
            [
                'Downcast/2.9.11 (Mac OS X Version 10.11.3 (Build 1X7))',
                '10.11.3',
            ],
            [
                'QuickTime/7.6 (qtver=7.6;cpu=IA32;os=Mac 10,5,7)',
                '10.5.7',
            ],
            [
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10102) AppleWebKit/640.3.18 (KHTML like Gecko) Version/10.0.2 Safari/640.3.18',
                '10.10.2',
            ],
        ];
    }
}
