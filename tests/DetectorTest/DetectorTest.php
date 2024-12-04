<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2024, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest;

use BrowserDetector\DetectorFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use RuntimeException;
use UnexpectedValueException;

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

        unset($result['headers']);

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
        ];
    }
}
