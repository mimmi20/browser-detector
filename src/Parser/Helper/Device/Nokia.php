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
final class Nokia implements DeviceInterface
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
            'nokia g50' => 'nokia=nokia g50',
            'nokia g20' => 'nokia=nokia g20',
            'nokia x10' => 'nokia=nokia x10',
            'nokia x20' => 'nokia=nokia x20',
            'nokia g22' => 'nokia=nokia g22',
            'nokia c12' => 'nokia=nokia c12',
            'nokia 2.3' => 'nokia=nokia 2.3',
            'nokia 5.4' => 'nokia=nokia 5.4',
            'nokia 8.3 5g' => 'nokia=nokia 8.3 5g',
            'nokia g11' => 'nokia=nokia g11',
            'nokia 8.1' => 'nokia=nokia 8.1',
            'nokia 5.1' => 'nokia=nokia 5.1',
            'nokia 7.1' => 'nokia=nokia 7.1',
            'nokia 7.2' => 'nokia=nokia 7.2',
            'nokia 4.2' => 'nokia=nokia 4.2',
            'nokia 6.1' => 'nokia=nokia 6.1',
            'nokia 6.2' => 'nokia=nokia 6.2',
            'nokia g60 5g' => 'nokia=nokia g60 5g',
            'nokia 3.1 plus' => 'nokia=nokia 3.1 plus',
            'ta-1021' => 'nokia=nokia ta-1021',
            'nokia 2' => 'nokia=nokia 2',
            'nokia x30 5g' => 'nokia=nokia x30 5g',
            'nokia 3.4' => 'nokia=nokia 3.4',
            'nokia 7 plus' => 'nokia=nokia 7 plus',
            'nokia g42 5g' => 'nokia=nokia g42 5g',
            'nokia g21' => 'nokia=nokia g21',
            'nokia 2.4' => 'nokia=nokia 2.4',
            'nokia 3.2' => 'nokia=nokia 3.2',
            'nokia 8 sirocco' => 'nokia=nokia 8 sirocco',
            'ta-1053' => 'nokia=nokia ta-1053',
            'ta-1012' => 'nokia=nokia ta-1012',
            'nokia g10' => 'nokia=nokia g10',
            'nokia 5.3' => 'nokia=nokia 5.3',
            'ta-1032' => 'nokia=nokia ta-1032',
            'nokia 5.1 plus' => 'nokia=nokia 5.1 plus',
            'ta-1003' => 'nokia=nokia ta-1003',
            'nokia 2.2' => 'nokia=nokia 2.2',
            'nokia 9' => 'nokia=nokia 9',
            'ta-1033' => 'nokia=nokia ta-1033',
            'nokia c22' => 'nokia=nokia c22',
            'nokia g11 plus' => 'nokia=nokia g11 plus',
            'ta-1004' => 'nokia=nokia ta-1004',
            'nokia t20' => 'nokia=nokia t20',
            'nokia 3.1' => 'nokia=nokia 3.1',
            'nokia 2.1' => 'nokia=nokia 2.1',
            'nokia xr20' => 'nokia=nokia xr20',
            'nokia g310 5g' => 'nokia=nokia g310 5g',
            'nokia c02' => 'nokia=nokia c02',
            'nokia 8' => 'nokia=nokia 8',
            'nokia 2720 flip' => 'nokia=nokia 2720 flip',
            'nokia c32' => 'nokia=nokia c32',
            'nokia 02-4g' => 'nokia=nokia 02-4g',
            'nokia 8.3' => 'nokia=nokia 8.3 4g',
            'nokia streaming box 8000' => 'nokia=nokia streaming box 8000',
            'nokia c12 pro' => 'nokia=nokia c12 pro',
            'n155dl' => 'nokia=nokia n155dl',
            'n1374dl' => 'nokia=nokia n1374dl',
            'ta-1374' => 'nokia=nokia ta-1374',
            'nokia g100' => 'nokia=nokia g100',
            'n156dl' => 'nokia=nokia n156dl',
            'nokia t21' => 'nokia=nokia t21',
            'ta-1487' => 'nokia=nokia ta-1487',
            'ta-1495' => 'nokia=nokia ta-1495',
            'ta-1521' => 'nokia=nokia ta-1521',
            'ta-1505' => 'nokia=nokia ta-1505',
            'n150dl' => 'nokia=nokia n150dl',
            'n151dl' => 'nokia=nokia n151dl',
            'n152dl' => 'nokia=nokia n152dl',
            'ta-1484' => 'nokia=nokia ta-1484',
            'ta-1520' => 'nokia=nokia ta-1520',
            'n1530dl' => 'nokia=nokia n1530dl',
            'ta-1530' => 'nokia=nokia ta-1530',
            'ta-1448' => 'nokia=nokia ta-1448',
            'ta-1476' => 'nokia=nokia ta-1476',
            'nokia g400 5g' => 'nokia=nokia g400 5g',
            'nokia 3110' => 'nokia=nokia 3110',
            'nokia 1000 4g' => 'nokia=nokia 1000 4g',
            'nokia 3115' => 'nokia=nokia 3115',
            'nokia 1100 4g' => 'nokia=nokia 1100 4g',
            'nokia 3215' => 'nokia=nokia 3215',
            'nokia c21 plus' => 'nokia=nokia c21 plus',
            'nokia x100' => 'nokia=nokia x100',
            'nokia 1.4' => 'nokia=nokia 1.4',
            'nokia 1.3' => 'nokia=nokia 1.3',
            'nokia c20' => 'nokia=nokia c20',
            'nokia streaming box 8010' => 'nokia=nokia streaming box 8010',
            'nokia 225 4g' => 'nokia=nokia 225 4g',
            // other
            default => null,
        };
    }
}
