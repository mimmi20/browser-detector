<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2026, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Version;

use BrowserDetector\Version\Exception\NotNumericException;
use BrowserDetector\Version\NullVersion;
use BrowserDetector\Version\SmartisanOs;
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionBuilderInterface;
use BrowserDetector\Version\VersionFactoryInterface;
use BrowserDetector\Version\VersionInterface;
use PHPUnit\Event\NoPreviousThrowableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

use function assert;

#[CoversClass(SmartisanOs::class)]
final class SmartisanOsTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws Exception
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new SmartisanOs(new VersionBuilder());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string|null>>
     *
     * @throws void
     */
    public static function providerVersion(): array
    {
        return [
            [
                'Mozilla/5.0 (Linux; U; Android 7.1.2; zh-cn; OC106 Build/N2G47H) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/57.0.2987.132 MQQBrowser/8.9 Mobile Safari/537.36',
                '6.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 8.1.0; zh-cn; OE106 Build/OPM1.171019.026) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 MQQBrowser/10.3 Mobile Safari/537.36',
                '6.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 9; zh-CN; DT1901A Build/PKQ1.190727.001) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 UCBrowser/12.8.9.1069 Mobile Safari/537.36',
                '6.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 8.1.0; DE106 Build/OPM1.171019.026; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/76.0.3809.89 Mobile',
                '6.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 10; DT2002C Build/QKQ1.200712.002; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/76.0.3809.89 Mobile Safari/537.36',
                '6.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; arm_64; Android 10; Smartisan U3 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.216 YaApp_Android/21.53.1 YaSearchBrowser/21.53.1 BroPP/1.0 SA/3 Mobile Safari/537.36',
                '3.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; Android 6.0.1; SM919 Build/MXB48T; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.49 Mobile MQQBrowser/6.2 TBS/043024 Safari/537.36 MicroMessenger/6.5.4.1000 NetType/WIFI Language/zh_CN',
                '3.0.0',
            ],
            [
                'Mozilla/5.0 (BB10; Kbd) AppleWebKit/537.35+ (KHTML, like Gecko) Mobile Safari/537.35+',
                null,
            ],
            [
                'Mozilla/5.0 (Linux; Android 5.1.1; SM801 Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/53.0.2785.49 Mobile MQQBrowser/6.2 TBS/043024 Safari/537.36 MicroMessenger/6.5.4.1000 NetType/4G Language/zh_CN',
                '2.5.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 5.1.1; zh-CN; YQ601 Build/LMY47V) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 UCBrowser/10.9.3.727 U3/0.8.0 Mobile Safari/534.30',
                '2.0.0',
            ],
            [
                'Mozilla/5.0 (Linux; U; Android 4.4.2; zh-cn; SM701 Build/SANFRANCISCO) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/5.4 TBS/025469 Mobile Safari/533.1 MicroMessenger/6.2.5.49_r7ead8bf.620 NetType/WIFI Language/zh_CN QQ/6.6.0.2935',
                '1.5.0',
            ],
        ];
    }
}
