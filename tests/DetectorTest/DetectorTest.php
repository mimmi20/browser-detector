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
use PHPUnit\Event\NoPreviousThrowableException;
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
     * @throws NoPreviousThrowableException
     * @throws \PHPUnit\Framework\MockObject\Exception
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
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
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
                        'dualOrientation' => true,
                        'simCount' => 2,
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
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'HuaweiBrowser',
                        'modus' => null,
                        'version' => '92.0.0',
                        'manufacturer' => 'huawei',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
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
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Baidu Box App',
                        'modus' => null,
                        'version' => '13.41.5.10',
                        'manufacturer' => 'baidu',
                        'type' => 'mobile-application',
                        'isbot' => false,
                        'bits' => null,
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
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Quark',
                        'modus' => null,
                        'version' => '1.6.9.911',
                        'manufacturer' => 'quark-team',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
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
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '11.0.0',
                        'manufacturer' => 'microsoft',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'modus' => null,
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
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
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '10.0.0',
                        'manufacturer' => 'microsoft',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'modus' => null,
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
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
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '7.0.0',
                        'manufacturer' => 'microsoft',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'modus' => null,
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
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
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '8.0.0',
                        'manufacturer' => 'microsoft',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'modus' => null,
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
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
                        'name' => 'Windows',
                        'marketingName' => 'Windows',
                        'version' => '8.1.0',
                        'manufacturer' => 'microsoft',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Chrome',
                        'modus' => null,
                        'version' => '97.0.4692.99',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
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
                        'marketingName' => 'iPad Mini 4',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
                        'dualOrientation' => true,
                        'simCount' => 0,
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
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'UC Browser',
                        'modus' => null,
                        'version' => '9.0.1.284',
                        'manufacturer' => 'ucweb',
                        'type' => 'transcoder',
                        'isbot' => false,
                        'bits' => null,
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
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Safari',
                        'modus' => null,
                        'version' => '7.0.3',
                        'manufacturer' => 'apple',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
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
                        'simCount' => 0,
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
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => null,
                        'modus' => null,
                        'version' => null,
                        'manufacturer' => 'unknown',
                        'type' => 'unknown',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => null,
                        'version' => null,
                        'manufacturer' => 'unknown',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; iLA_Silk Build/iLA_Silk)'],
                [
                    'headers' => ['user-agent' => 'Dalvik/2.1.0 (Linux; U; Android 8.1.0; iLA_Silk Build/iLA_Silk)'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'Silk',
                        'marketingName' => 'Silk',
                        'manufacturer' => 'ila',
                        'brand' => 'ila',
                        'dualOrientation' => true,
                        'simCount' => 1,
                        'display' => [
                            'width' => null,
                            'height' => null,
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
                        'version' => '8.1.0',
                        'manufacturer' => 'google',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Dalvik',
                        'modus' => null,
                        'version' => '2.1.0',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => 'WebKit',
                        'version' => null,
                        'manufacturer' => 'apple',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (Linux; U; Android 4.2.1; zh-cn; Infinix X801 Build/JOP40D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30;'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (Linux; U; Android 4.2.1; zh-cn; Infinix X801 Build/JOP40D) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30;'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'X801',
                        'marketingName' => 'Joypad 8S',
                        'manufacturer' => 'infinix',
                        'brand' => 'infinix',
                        'dualOrientation' => true,
                        'simCount' => 1,
                        'display' => [
                            'width' => 1024,
                            'height' => 768,
                            'touch' => true,
                            'size' => 8.0,
                        ],
                        'type' => 'fone-pad',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Android',
                        'marketingName' => 'Android',
                        'version' => '4.2.1',
                        'manufacturer' => 'google',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Android Webkit',
                        'modus' => null,
                        'version' => '4.0.0',
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => 'WebKit',
                        'version' => '534.30.0',
                        'manufacturer' => 'apple',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_1_1 like Mac OS X; zh-CN) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/19B81 UCBrowser/13.7.2.1636 Mobile AliApp(TUnionSDK/0.1.20.4) dv(iPh14,5);pr(UCBrowser/13.7.2.1636);ov(15_1_1);ss(390x844);bt(UC);pm(0);bv(0);nm(0);im(0);nt(1);'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_1_1 like Mac OS X; zh-CN) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/19B81 UCBrowser/13.7.2.1636 Mobile AliApp(TUnionSDK/0.1.20.4) dv(iPh14,5);pr(UCBrowser/13.7.2.1636);ov(15_1_1);ss(390x844);bt(UC);pm(0);bv(0);nm(0);im(0);nt(1);'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'iPhone 14,5',
                        'marketingName' => 'iPhone 13',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
                        'dualOrientation' => true,
                        'simCount' => 1,
                        'display' => [
                            'width' => 2532,
                            'height' => 1170,
                            'touch' => true,
                            'size' => 6.1,
                        ],
                        'type' => 'phablet',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'iOS',
                        'marketingName' => 'iOS',
                        'version' => '15.1.1',
                        'manufacturer' => 'apple',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'UC Browser',
                        'modus' => null,
                        'version' => '13.7.2.1636',
                        'manufacturer' => 'ucweb',
                        'type' => 'transcoder',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => 'WebKit',
                        'version' => '605.1.15',
                        'manufacturer' => 'apple',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (Linux; Android 10; arm_64; M2002J9G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 YaBrowser/20.7.5.84.00 SA/3 Mobile Safari/537.36'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (Linux; Android 10; arm_64; M2002J9G) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 YaBrowser/20.7.5.84.00 SA/3 Mobile Safari/537.36'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'M2002J9G',
                        'marketingName' => 'Mi 10 Lite 5G',
                        'manufacturer' => 'xiaomi',
                        'brand' => 'xiaomi',
                        'dualOrientation' => true,
                        'simCount' => 2,
                        'display' => [
                            'width' => 2400,
                            'height' => 1080,
                            'touch' => true,
                            'size' => 6.6,
                        ],
                        'type' => 'smartphone',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Android',
                        'marketingName' => 'Android',
                        'version' => '10.0.0',
                        'manufacturer' => 'google',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Yandex Browser',
                        'modus' => null,
                        'version' => '20.7.5.84.00',
                        'manufacturer' => 'yandex',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '83.0.4103.116',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (Linux; Android 10; arm_64; M2002J9G Build/JOP40D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 YaBrowser/20.7.5.84.00 SA/3 Mobile Safari/537.36'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (Linux; Android 10; arm_64; M2002J9G Build/JOP40D) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 YaBrowser/20.7.5.84.00 SA/3 Mobile Safari/537.36'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'M2002J9G',
                        'marketingName' => 'Mi 10 Lite 5G',
                        'manufacturer' => 'xiaomi',
                        'brand' => 'xiaomi',
                        'dualOrientation' => true,
                        'simCount' => 2,
                        'display' => [
                            'width' => 2400,
                            'height' => 1080,
                            'touch' => true,
                            'size' => 6.6,
                        ],
                        'type' => 'smartphone',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Android',
                        'marketingName' => 'Android',
                        'version' => '10.0.0',
                        'manufacturer' => 'google',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Yandex Browser',
                        'modus' => null,
                        'version' => '20.7.5.84.00',
                        'manufacturer' => 'yandex',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '83.0.4103.116',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (Linux; arm_64; Android 14; Optima 8430E 4G DA1C8P01) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.6834.2144 YaApp_Android/25.20.1/apad YaSearchBrowser/25.20.1/apad BroPP/1.0 SA/3 Mobile Safari/537.36'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (Linux; arm_64; Android 14; Optima 8430E 4G DA1C8P01) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.6834.2144 YaApp_Android/25.20.1/apad YaSearchBrowser/25.20.1/apad BroPP/1.0 SA/3 Mobile Safari/537.36'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'DA1C8P01',
                        'marketingName' => 'Optima 8430E 4G',
                        'manufacturer' => 'digma',
                        'brand' => 'digma',
                        'dualOrientation' => true,
                        'simCount' => 2,
                        'display' => [
                            'width' => 1280,
                            'height' => 800,
                            'touch' => true,
                            'size' => 8.0,
                        ],
                        'type' => 'fone-pad',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Android',
                        'marketingName' => 'Android',
                        'version' => '14.0.0',
                        'manufacturer' => 'google',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Yandex Search Browser',
                        'modus' => null,
                        'version' => '25.20.1',
                        'manufacturer' => 'yandex',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => 'Blink',
                        'version' => '132.0.6834.2144',
                        'manufacturer' => 'google',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Android 17 - samsung meliuslte'],
                [
                    'headers' => ['user-agent' => 'Android 17 - samsung meliuslte'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'general Samsung device',
                        'marketingName' => 'general Samsung device',
                        'manufacturer' => 'samsung',
                        'brand' => 'samsung',
                        'dualOrientation' => null,
                        'simCount' => 0,
                        'display' => [
                            'width' => null,
                            'height' => null,
                            'touch' => true,
                            'size' => null,
                        ],
                        'type' => 'mobile-device',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'Android',
                        'marketingName' => 'Android',
                        'version' => null,
                        'manufacturer' => 'google',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Android Webkit',
                        'modus' => null,
                        'version' => null,
                        'manufacturer' => 'google',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => null,
                        'version' => null,
                        'manufacturer' => 'unknown',
                    ],
                ],
            ],
            [
                ['user-agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) WorxWeb/18.11.5(build 18.11.5.4) Mobile/16B92 Safari/605.1<tabid-F3D1C4D0-C475-4EFA-AFC9-9E4FA70B94AD>'],
                [
                    'headers' => ['user-agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) WorxWeb/18.11.5(build 18.11.5.4) Mobile/16B92 Safari/605.1<tabid-F3D1C4D0-C475-4EFA-AFC9-9E4FA70B94AD>'],
                    'device' => [
                        'architecture' => null,
                        'deviceName' => 'iPhone',
                        'marketingName' => 'iPhone',
                        'manufacturer' => 'apple',
                        'brand' => 'apple',
                        'dualOrientation' => true,
                        'simCount' => 1,
                        'display' => [
                            'width' => 480,
                            'height' => 320,
                            'touch' => true,
                            'size' => 3.5,
                        ],
                        'type' => 'smartphone',
                        'ismobile' => true,
                        'istv' => false,
                        'bits' => null,
                    ],
                    'os' => [
                        'name' => 'iOS',
                        'marketingName' => 'iOS',
                        'version' => '12.1.0',
                        'manufacturer' => 'apple',
                        'bits' => null,
                    ],
                    'client' => [
                        'name' => 'Safari',
                        'modus' => null,
                        'version' => '5.0.0',
                        'manufacturer' => 'apple',
                        'type' => 'browser',
                        'isbot' => false,
                        'bits' => null,
                    ],
                    'engine' => [
                        'name' => 'WebKit',
                        'version' => '605.1.15',
                        'manufacturer' => 'apple',
                    ],
                ],
            ],
        ];
    }
}
