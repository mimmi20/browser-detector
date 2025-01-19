<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest;

use BrowserDetector\Detector;
use BrowserDetector\DetectorFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RuntimeException;
use UnexpectedValueException;

#[CoversClass(Detector::class)]
final class DetectorTest extends TestCase
{
    /**
     * @param array<non-empty-string, non-empty-string> $headers
     * @param array<string, mixed>                      $expected
     *
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     * @throws ExpectationFailedException
     * @throws RuntimeException
     * @throws \Laminas\Hydrator\Exception\InvalidArgumentException
     */
    #[DataProvider('providerUa')]
    public function testData(array $headers, array $expected): void
    {
        $logger = $this->createMock(LoggerInterface::class);
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

        $cache = $this->createMock(CacheInterface::class);

        $factory  = new DetectorFactory($cache, $logger);
        $detector = $factory();

        $result = $detector->getBrowser($headers);

        self::assertSame($expected, $result);
    }

    /**
     * @return array<int, array<int, mixed>>
     *
     * @throws void
     */
    public static function providerUa(): array
    {
        return [
            [
                [
                    'sec-ch-ua' => '"Chromium";v="92", " Not A;Brand";v="99", "HuaweiBrowser";v="92"',
                    'sec-ch-ua-arch' => '""',
                    'sec-ch-ua-full-version' => '"92.0.4515.105"',
                    'sec-ch-ua-mobile' => '?1',
                    'sec-ch-ua-model' => '"RVL-AL09"',
                    'sec-ch-ua-platform' => '"Android"',
                    'sec-ch-ua-platform-version' => '"9; HarmonyOS"',
                    'sec-fetch-dest' => 'document',
                    'sec-fetch-mode' => 'navigate',
                    'sec-fetch-site' => 'cross-site',
                    'sec-fetch-user' => '?1',
                    'user-agent' => 'Mozilla/5.0 (Linux; Android 9; HarmonyOS; RVL-AL09; HMSCore 6.7.0.301; GMSCore 22.30.17) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.105 HuaweiBrowser/12.1.3.303 Mobile Safari/537.36',
                ],
                [
                    'headers' => [
                        'sec-ch-ua-model' => '"RVL-AL09"',
                        'sec-ch-ua-platform' => '"Android"',
                        'sec-ch-ua-platform-version' => '"9; HarmonyOS"',
                        'sec-ch-ua' => '"Chromium";v="92", " Not A;Brand";v="99", "HuaweiBrowser";v="92"',
                        'sec-ch-ua-full-version' => '"92.0.4515.105"',
                        'sec-ch-ua-arch' => '""',
                        'sec-ch-ua-mobile' => '?1',
                        'user-agent' => 'Mozilla/5.0 (Linux; Android 9; HarmonyOS; RVL-AL09; HMSCore 6.7.0.301; GMSCore 22.30.17) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.105 HuaweiBrowser/12.1.3.303 Mobile Safari/537.36',
                    ],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'RVL-AL09',
                        'marketingName' => 'Honor Note 10',
                        'manufacturer' => 'huawei',
                        'brand' => 'huawei',
                        'dualOrientation' => null,
                        'simCount' => null,
                        'display' => [
                            'width' => 2220,
                            'height' => 1080,
                            'touch' => true,
                            'size' => 6.95,
                        ],
                        'type' => 'phablet',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'HarmonyOS',
                        'marketingName' => 'HarmonyOS',
                        'version' => null,
                        'manufacturer' => 'huawei',
                    ],
                    'client' => [
                        'name' => 'HuaweiBrowser',
                        'version' => '92.0.0',
                        'manufacturer' => 'huawei',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '92.0.4515.105',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (Linux; Android 12; DBY-W09 Build/HUAWEIDBY-W09; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/97.0.4692.98 Mobile Safari/537.36 T7/13.41 BDOS/1.0 (HarmonyOS 3.0.0) SP-engine/2.79.0 baiduboxapp/13.41.5.10 (Baidu; P1 12) NABar/1.0'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (Linux; Android 12; DBY-W09 Build/HUAWEIDBY-W09; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/97.0.4692.98 Mobile Safari/537.36 T7/13.41 BDOS/1.0 (HarmonyOS 3.0.0) SP-engine/2.79.0 baiduboxapp/13.41.5.10 (Baidu; P1 12) NABar/1.0'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'DBY-W09',
                        'marketingName' => 'MatePad 11 Wi-Fi (2021)',
                        'manufacturer' => 'huawei',
                        'brand' => 'huawei',
                        'dualOrientation' => true,
                        'simCount' => 0,
                        'display' => [
                            'width' => 2560,
                            'height' => 1600,
                            'touch' => true,
                            'size' => 10.95,
                        ],
                        'type' => 'tablet',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'HarmonyOS',
                        'marketingName' => 'HarmonyOS',
                        'version' => '3.0.0',
                        'manufacturer' => 'huawei',
                    ],
                    'client' => [
                        'name' => 'Baidu Box App',
                        'version' => '13.41.5.10',
                        'manufacturer' => 'baidu',
                        'type' => 'mobile-application',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'T7',
                        'version' => '13.41.0',
                        'manufacturer' => 'baidu',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (Linux; U; Android 6.0.1; xx; Le X820 Build/MOB31T) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/40.0.2214.89 Quark/1.6.9.911 Mobile Safari/537.36'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (Linux; U; Android 6.0.1; xx; Le X820 Build/MOB31T) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/40.0.2214.89 Quark/1.6.9.911 Mobile Safari/537.36'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'Le X820',
                        'marketingName' => 'Le Max 2',
                        'manufacturer' => 'leeco',
                        'brand' => 'leeco',
                        'dualOrientation' => true,
                        'simCount' => 2,
                        'display' => [
                            'width' => 2560,
                            'height' => 1440,
                            'touch' => true,
                            'size' => 5.7,
                        ],
                        'type' => 'smartphone',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Android',
                        'marketingName' => 'Android',
                        'version' => '6.0.1',
                        'manufacturer' => 'google',
                    ],
                    'client' => [
                        'name' => 'Quark',
                        'version' => '1.6.9.911',
                        'manufacturer' => 'quark-team',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '40.0.2214.89',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                [
                    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    'sec-ch-ua-mobile' => '?0',
                    'sec-ch-ua-platform' => '"Windows"',
                    'sec-ch-ua-platform-version' => '"14.0.0"',
                ],
                [
                    'headers' => [
                        'sec-ch-ua-platform' => '"Windows"',
                        'sec-ch-ua-platform-version' => '"14.0.0"',
                        'sec-ch-ua-mobile' => '?0',
                        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    ],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'Windows Desktop',
                        'marketingName' => 'Windows Desktop',
                        'manufacturer' => 'unknown',
                        'brand' => 'unknown',
                        'dualOrientation' => null,
                        'simCount' => null,
                        'display' => [
                            'width' => null,
                            'height' => null,
                            'touch' => false,
                            'size' => null,
                        ],
                        'type' => 'desktop',
                        'ismobile' => false,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '11.0.0',
                        'manufacturer' => 'microsoft',
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                [
                    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    'sec-ch-ua-mobile' => '?0',
                    'sec-ch-ua-platform' => '"Windows"',
                    'sec-ch-ua-platform-version' => '"10.0.0"',
                ],
                [
                    'headers' => [
                        'sec-ch-ua-platform' => '"Windows"',
                        'sec-ch-ua-platform-version' => '"10.0.0"',
                        'sec-ch-ua-mobile' => '?0',
                        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    ],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'Windows Desktop',
                        'marketingName' => 'Windows Desktop',
                        'manufacturer' => 'unknown',
                        'brand' => 'unknown',
                        'dualOrientation' => null,
                        'simCount' => null,
                        'display' => [
                            'width' => null,
                            'height' => null,
                            'touch' => false,
                            'size' => null,
                        ],
                        'type' => 'desktop',
                        'ismobile' => false,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '10.0.0',
                        'manufacturer' => 'microsoft',
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                [
                    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    'sec-ch-ua-mobile' => '?0',
                    'sec-ch-ua-platform' => '"Windows"',
                    'sec-ch-ua-platform-version' => '"0.1"',
                ],
                [
                    'headers' => [
                        'sec-ch-ua-platform' => '"Windows"',
                        'sec-ch-ua-platform-version' => '"0.1"',
                        'sec-ch-ua-mobile' => '?0',
                        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    ],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'Windows Desktop',
                        'marketingName' => 'Windows Desktop',
                        'manufacturer' => 'unknown',
                        'brand' => 'unknown',
                        'dualOrientation' => null,
                        'simCount' => null,
                        'display' => [
                            'width' => null,
                            'height' => null,
                            'touch' => false,
                            'size' => null,
                        ],
                        'type' => 'desktop',
                        'ismobile' => false,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '7.0.0',
                        'manufacturer' => 'microsoft',
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                [
                    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    'sec-ch-ua-mobile' => '?0',
                    'sec-ch-ua-platform' => '"Windows"',
                    'sec-ch-ua-platform-version' => '"0.2"',
                ],
                [
                    'headers' => [
                        'sec-ch-ua-platform' => '"Windows"',
                        'sec-ch-ua-platform-version' => '"0.2"',
                        'sec-ch-ua-mobile' => '?0',
                        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    ],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'Windows Desktop',
                        'marketingName' => 'Windows Desktop',
                        'manufacturer' => 'unknown',
                        'brand' => 'unknown',
                        'dualOrientation' => null,
                        'simCount' => null,
                        'display' => [
                            'width' => null,
                            'height' => null,
                            'touch' => false,
                            'size' => null,
                        ],
                        'type' => 'desktop',
                        'ismobile' => false,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '8.0.0',
                        'manufacturer' => 'microsoft',
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                [
                    'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    'sec-ch-ua-mobile' => '?0',
                    'sec-ch-ua-platform' => '"Windows"',
                    'sec-ch-ua-platform-version' => '"0.3"',
                ],
                [
                    'headers' => [
                        'sec-ch-ua-platform' => '"Windows"',
                        'sec-ch-ua-platform-version' => '"0.3"',
                        'sec-ch-ua-mobile' => '?0',
                        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.3',
                    ],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'Windows Desktop',
                        'marketingName' => 'Windows Desktop',
                        'manufacturer' => 'unknown',
                        'brand' => 'unknown',
                        'dualOrientation' => null,
                        'simCount' => null,
                        'display' => [
                            'width' => null,
                            'height' => null,
                            'touch' => false,
                            'size' => null,
                        ],
                        'type' => 'desktop',
                        'ismobile' => false,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '8.1.0',
                        'manufacturer' => 'microsoft',
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                ['user-agent' => 'UCWEB/2.0 (iOS; U; iPd OS 7_0_4; zh-CN; iPd5,1) U2/1.0.0 UCBrowser/9.0.1.284 U2/1.0.0 Mobile'],
                [
                    'headers' => ['user-agent' => 'UCWEB/2.0 (iOS; U; iPd OS 7_0_4; zh-CN; iPd5,1) U2/1.0.0 UCBrowser/9.0.1.284 U2/1.0.0 Mobile'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'iPad 5,1',
                        'marketingName' => 'iPad mini 4',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
                        'dualOrientation' => null,
                        'simCount' => null,
                        'display' => [
                            'width' => 2048,
                            'height' => 1536,
                            'touch' => true,
                            'size' => 7.9,
                        ],
                        'type' => 'tablet',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'iOS',
                        'marketingName' => 'iOS',
                        'version' => '7.0.4',
                        'manufacturer' => 'apple',
                    ],
                    'client' => [
                        'name' => 'UC Browser',
                        'version' => '9.0.1.284',
                        'manufacturer' => 'ucweb',
                        'type' => 'transcoder',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'WebKit',
                        'version' => null,
                        'manufacturer' => 'apple',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'Macintosh',
                        'marketingName' => 'Macintosh',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
                        'dualOrientation' => false,
                        'simCount' => 0,
                        'display' => [
                            'width' => null,
                            'height' => null,
                            'touch' => false,
                            'size' => null,
                        ],
                        'type' => 'desktop',
                        'ismobile' => false,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Mac OS X',
                        'marketingName' => 'Mac OS X',
                        'version' => '10.9.3',
                        'manufacturer' => 'apple',
                    ],
                    'client' => [
                        'name' => 'Safari',
                        'version' => '7.0.3',
                        'manufacturer' => 'apple',
                        'type' => 'browser',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => 'WebKit',
                        'version' => '537.75.14',
                        'manufacturer' => 'apple',
                    ],
                ],
            ],
            [
                ['x-crawled-by' => 'RecordedFuture-ASI-Crawl'],
                [
                    'headers' => ['x-crawled-by' => 'RecordedFuture-ASI-Crawl'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => null,
                        'marketingName' => null,
                        'manufacturer' => 'unknown',
                        'brand' => 'unknown',
                        'dualOrientation' => null,
                        'simCount' => null,
                        'display' => [
                            'width' => null,
                            'height' => null,
                            'touch' => null,
                            'size' => null,
                        ],
                        'type' => 'unknown',
                        'ismobile' => false,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => null,
                        'marketingName' => null,
                        'version' => null,
                        'manufacturer' => 'unknown',
                    ],
                    'client' => [
                        'name' => null,
                        'version' => null,
                        'manufacturer' => 'unknown',
                        'type' => 'unknown',
                        'isbot' => false,
                    ],
                    'engine' => [
                        'name' => null,
                        'version' => null,
                        'manufacturer' => 'unknown',
                    ],
                ],
            ],
        ];
    }
}
