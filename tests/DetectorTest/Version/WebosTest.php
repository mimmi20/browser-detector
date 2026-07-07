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
use BrowserDetector\Version\VersionBuilder;
use BrowserDetector\Version\VersionInterface;
use BrowserDetector\Version\Webos;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

#[CoversClass(Webos::class)]
final class WebosTest extends TestCase
{
    /**
     * @throws ExpectationFailedException
     * @throws UnexpectedValueException
     * @throws Exception
     * @throws NotNumericException
     */
    #[DataProvider('providerVersion')]
    public function testTestdetectVersion(string $useragent, string | null $expectedVersion): void
    {
        $object = new Webos(new VersionBuilder());

        $detectedVersion = $object->detectVersion($useragent);

        self::assertInstanceOf(VersionInterface::class, $detectedVersion);
        self::assertSame($expectedVersion, $detectedVersion->getVersion());
    }

    /**
     * @return array<int, array<int, string|null>>
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    public static function providerVersion(): array
    {
        return [
            [
                'Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.5; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/234.83 Safari/534.6 TouchPad/1.0',
                '3.0.5',
            ],
            [
                'Mozilla/5.0 (webOS/2.1.1; U; de-DE) AppleWebKit/532.2 (KHTML, like Gecko) Version/1.0 Safari/532.2 P160U/1.0',
                '2.1.1',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.6834.207 Safari/537.36',
                '26.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.6099.270 Safari/537.36 WebAppManager',
                '25.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/108.0.5359.211 Safari/537.36 WebAppManager',
                '24.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.128 Safari/537.36 WebAppManager',
                '23.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36 HbbTV/1.6.1 (+DRM; LGE/ATMACA/AXEN; AX32DAL540-0276; WEBOS22 03.34.35; W22_K8AP; DTV_C22L;)',
                '22.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36 HbbTV/1.5.1 ( DRM; LGE; OLED55A16LA; WEBOS6.0 03.00.12; W60_LM21U; DTV_W21U;) FVC/5.0 (LGE; WEBOS6.0 ;)',
                '6.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36 HbbTV/1.5.1 ( DRM; LGE/SQY/RCA; XU43WT180N; WEBOS5.0 03.21.04; W50_K6LP; DTV_C20P;)',
                '5.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.34 Safari/537.36 HbbTV/1.4.1 ( DRM; LGE; 43UK6400PLF; WEBOS4.0 03.00.81; W4_LM18A; W4_LM18A;)',
                '4.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36 HbbTV/1.2.1 ( DRM; LGE; 43LJ614V-ZA; WEBOS3.5 04.70.50; W3_M2R;)',
                '3.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/538.2 (KHTML, like Gecko) Large Screen Safari/538.2 LG Browser/7.00.00(LGE; 55UF851V-ZC; 04.05.01; 1; DTV_W15U); webOS.TV-2015; LG NetCast.TV-2013 Compatible (LGE, 55UF851V-ZC, wired)',
                '2.0.0',
            ],
            [
                'LG Browser/7.00.00(LGE; WEBOS1; 00.00.00) webOS.TV-2015)',
                '1.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S; Linux/SmartTV) AppleWebKit/537.41 (KHTML, like Gecko) Large Screen ISIS/0.2.1-2-r13 Safari/537.41',
                '1.0.0',
            ],
            [
                'Mozilla/5.0 (Web0S Linux/SmartTV) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36 HbbTV/1.2.1 ( DRM; LGE; 43LJ614V-ZA; WEBOS3.5 04.70.50; W3_M2R;)',
                null,
            ],
        ];
    }
}
