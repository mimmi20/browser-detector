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

namespace BrowserDetector\Parser\Helper\Device;

use BrowserDetector\Parser\Helper\DeviceInterface;
use Override;

/** @phpcs:disable SlevomatCodingStandard.Classes.ClassLength.ClassTooLong */
final class Oukitel implements DeviceInterface
{
    /**
     * @return non-empty-string|null
     *
     * @throws void
     *
     * @phpcs:disable SlevomatCodingStandard.Functions.FunctionLength.FunctionLength
     */
    #[Override]
    public function getDeviceCode(string $code): string | null
    {
        return match ($code) {
            'wp16' => 'oukitel=oukitel wp16',
            'wp18' => 'oukitel=oukitel wp18',
            'c17 pro' => 'oukitel=oukitel c17 pro',
            'c21 pro' => 'oukitel=oukitel c21 pro',
            'c33' => 'oukitel=oukitel c33',
            'c18_pro' => 'oukitel=oukitel c18 pro',
            'wp5' => 'oukitel=oukitel wp5',
            'wp6' => 'oukitel=oukitel wp6',
            'wp5 pro' => 'oukitel=oukitel wp5 pro',
            'wp7' => 'oukitel=oukitel wp7',
            'wp12' => 'oukitel=oukitel wp12',
            'wp8 pro' => 'oukitel=oukitel wp8 pro',
            'wp12 pro' => 'oukitel=oukitel wp12 pro',
            'c15 pro' => 'oukitel=oukitel c15 pro',
            'wp5000' => 'oukitel=oukitel wp5000',
            'k7 power' => 'oukitel=oukitel k7 power',
            'rt1' => 'oukitel=oukitel rt1',
            'wp32' => 'oukitel=oukitel wp32',
            'c36' => 'oukitel=oukitel c36',
            'wp23' => 'oukitel=oukitel wp23',
            'wp17' => 'oukitel=oukitel wp17',
            'wp55' => 'oukitel=oukitel wp55',
            'wp200 pro' => 'oukitel=oukitel wp200 pro',
            'c35' => 'oukitel=oukitel c35',
            'wp27' => 'oukitel=oukitel wp27',
            'c25' => 'oukitel=oukitel c25',
            'wp15' => 'oukitel=oukitel wp15',
            'wp38' => 'oukitel=oukitel wp38',
            'wp36 pro' => 'oukitel=oukitel wp36 pro',
            'wp36' => 'oukitel=oukitel wp36',
            'wp23 pro', 'oukitel wp23pro' => 'oukitel=oukitel wp23 pro',
            'wp2', 'oukitel wp2' => 'oukitel=oukitel wp2',
            'wp1' => 'oukitel=oukitel wp1',
            'c16_pro' => 'oukitel=oukitel c16 pro',
            'c12 pro' => 'oukitel=oukitel c12 pro',
            'c8 4g' => 'oukitel=oukitel c8 4g',
            'c8' => 'oukitel=oukitel c8',
            'c5 pro' => 'oukitel=oukitel c5 pro',
            'c5' => 'oukitel=oukitel c5',
            'c4' => 'oukitel=oukitel c4',
            'oukitel-c3' => 'oukitel=oukitel c3',
            'oukitel c2' => 'oukitel=oukitel c2',
            'k3' => 'oukitel=oukitel k3',
            'k7_pro' => 'oukitel=oukitel k7 pro',
            'k4000' => 'oukitel=oukitel k4000',
            'oukitel k4000 pro', 'k4000pro' => 'oukitel=oukitel k4000 pro',
            'k4000 plus' => 'oukitel=oukitel k4000 plus',
            'wp22' => 'oukitel=oukitel wp22',
            'c22' => 'oukitel=oukitel c22',
            'c32' => 'oukitel=oukitel c32',
            'wp28' => 'oukitel=oukitel wp28',
            'wp26' => 'oukitel=oukitel wp26',
            'okt3' => 'oukitel=oukitel okt3',
            'rt7 titan 5g' => 'oukitel=oukitel rt7 titan 5g',
            'rt6' => 'oukitel=oukitel rt6',
            'rt5' => 'oukitel=oukitel rt5',
            'wp100 titan' => 'oukitel=oukitel wp100 titan',
            'wp32_pro' => 'oukitel=oukitel wp32 pro',
            'wp39 pro' => 'oukitel=oukitel wp39 pro',
            'wp33 pro' => 'oukitel=oukitel wp33 pro',
            'wp19 pro' => 'oukitel=oukitel wp19 pro',
            'ot5' => 'oukitel=oukitel ot5',
            'rt7 titan' => 'oukitel=oukitel rt7 titan 4g',
            'ot6 kids' => 'oukitel=oukitel ot6 kids',
            'wp35 pro' => 'oukitel=oukitel wp35 pro',
            'wp35 s' => 'oukitel=oukitel wp35 s',
            'wp39' => 'oukitel=oukitel wp39',
            'wp28 s' => 'oukitel=oukitel wp28 s',
            'wp28 e' => 'oukitel=oukitel wp28 e',
            'rt9' => 'oukitel=oukitel rt9',
            'k16' => 'oukitel=oukitel k16',
            'c 38', 'c38' => 'oukitel=oukitel c38',
            'ot11' => 'oukitel=oukitel ot11',
            'rt8' => 'oukitel=oukitel rt8',
            'wp52' => 'oukitel=oukitel wp52',
            'ot8' => 'oukitel=oukitel ot8',
            'wp35' => 'oukitel=oukitel wp35',
            'c51' => 'oukitel=oukitel c51',
            'wp50' => 'oukitel=oukitel wp50',
            'ot6' => 'oukitel=oukitel ot6',
            'ot5 s' => 'oukitel=oukitel ot5 s',
            'oukitel c1' => 'oukitel=oukitel c1 2025',
            'rt3 pro' => 'oukitel=oukitel rt3 pro',
            'wp30 pro' => 'oukitel=oukitel wp30 pro',
            'rt2' => 'oukitel=oukitel rt2',
            'wp300' => 'oukitel=oukitel wp300',
            'wp55 ultra' => 'oukitel=oukitel wp55 ultra',
            'wp53' => 'oukitel=oukitel wp53',
            'wp53 pro' => 'oukitel=oukitel wp53 pro',
            'wp53 s' => 'oukitel=oukitel wp53 s',
            'wp56' => 'oukitel=oukitel wp56',
            'c31' => 'oukitel=oukitel c31',
            'c31 pro' => 'oukitel=oukitel c31 pro',
            'wp21 ultra' => 'oukitel=oukitel wp21 ultra',
            'rt3' => 'oukitel=oukitel rt3',
            'wp21' => 'oukitel=oukitel wp21',
            'wp18 pro' => 'oukitel=oukitel wp18 pro',
            'wp20' => 'oukitel=oukitel wp20',
            'wp20 pro' => 'oukitel=oukitel wp20 pro',
            'wp19' => 'oukitel=oukitel wp19',
            'wp210 pro' => 'oukitel=oukitel wp210 pro',
            'oukitel g3' => 'oukitel=oukitel g3',
            'c11' => 'oukitel=oukitel c11',
            'wp60', 'oukitel wp60' => 'oukitel=oukitel wp60',
            'rt3 plus' => 'oukitel=oukitel rt3 plus',
            'wp9' => 'oukitel=oukitel wp9',
            'c61 pro' => 'oukitel=oukitel c61 pro',
            'oukitel rt7 5g' => 'oukitel=oukitel rt7 5g',
            'oukitel g5' => 'oukitel=oukitel g5',
            'wp55 s' => 'oukitel=oukitel wp55 s',
            'c62 pro' => 'oukitel=oukitel c62 pro',
            'wp62' => 'oukitel=oukitel wp62',
            'c59 pro' => 'oukitel=oukitel c59 pro',
            // other
            default => null,
        };
    }
}
