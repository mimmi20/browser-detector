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
final class Htc implements DeviceInterface
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
            'htc desire 19+' => 'htc=htc desire 19 plus',
            'htc u11' => 'htc=htc u11',
            'htc 10' => 'htc=htc 10',
            'htc 2pzf1', '2pzf1' => 'htc=htc 2pzf1',
            'htc desire 21 pro 5g' => 'htc=htc desire 21 pro 5g',
            'htc 10 evo' => 'htc=htc 10 evo',
            'htc one m9' => 'htc=htc m9',
            'htc desire eye' => 'htc=htc desire eye',
            'htc desire 12' => 'htc=htc desire 12',
            'htc desire 20 pro' => 'htc=htc desire 20 pro',
            'htc u12+' => 'htc=htc u12+',
            'htc one' => 'htc=htc m7',
            'htc u ultra' => 'htc=htc u ultra',
            'htc one a9s' => 'htc=htc a9s',
            'htc one a9' => 'htc=htc one a9',
            'htc u11 life' => 'htc=htc u11 life',
            'htc desire 12+' => 'htc=htc desire 12+',
            'htc 2q55100', '2q55100' => 'htc=htc 2q55100',
            'htc 2q55300', '2q55300' => 'htc=htc 2q55300',
            'htc 2q4d200', '2q4d200' => 'htc=htc 2q4d200',
            'htc u20 5g' => 'htc=htc u20 5g',
            'htc 2pzm3', '2pzm3' => 'htc=htc 2pzm3',
            'htc 2pq93', '2pq93' => 'htc=htc 2pq93',
            'htc 2pq910', '2pq910' => 'htc=htc 2pq910',
            'htc_a9u' => 'htc=htc a9u',
            'htc_d526h', 'htcd526h' => 'htc=htc desire 526h',
            'htc a103 plus' => 'htc=htc a103 plus',
            'htc u23 pro' => 'htc=htc u23 pro',
            '2qc9200' => 'htc=htc 2qc9200',
            '2qc9100' => 'htc=htc 2qc9100',
            '2qcb100' => 'htc=htc 2qcb100',
            'htc_u-2u' => 'htc=htc u-2u',
            'u play', 'htc u play' => 'htc=htc u play',
            '2q6e1' => 'htc=htc 2q6e1',
            'u12 life', 'htc u12 life' => 'htc=htc u12 life',
            '2pzc100', 'htc 2pzc100' => 'htc=htc 2pzc100',
            '2pzc5' => 'htc=htc 2pzc5',
            '601ht' => 'htc=htc 601ht',
            'htv33' => 'htc=htc htv33',
            'htc a101 plus' => 'htc=htc a101 plus',
            'htc a102' => 'htc=htc a102',
            'htc desire 22 pro' => 'htc=htc desire 22 pro',
            'htc a103' => 'htc=htc a103',
            'wildfire e5' => 'htc=htc wildfire e5',
            'htc ones dual sim' => 'htc=htc one s dual sim',
            'htc one0p6b dual sim' => 'htc=htc 0p6b dual sim',
            'htc butterfly s 901s' => 'htc=htc s901s',
            'htc_desire_601_dual_sim' => 'htc=htc desire 601 dual sim',
            'one s c2' => 'htc=htc c2',
            'sprint apa9292kt' => 'htc=htc 9292',
            '0pcv1' => 'htc=htc 0pcv1',
            '0pja2' => 'htc=htc 0pja2',
            '0pm92' => 'htc=htc 0pm92',
            '2ps64' => 'htc=htc 2ps64',
            '2pyb2' => 'htc=htc 2pyb2',
            'htcd160lvwpp' => 'htc=htc d160lvwpp',
            'vive xr series' => 'htc=htc vive xr series',
            'wildfire e6 star' => 'htc=htc wildfire e6 star',
            'htc u24 pro', 'u24 pro' => 'htc=htc u24 pro',
            'wildfire e4 plus' => 'htc=htc wildfire e4 plus',
            'wildfire e6' => 'htc=htc wildfire e6',
            'wildfire', 'htc wildfire' => 'htc=htc wildfire',
            'wildfire e5 plus' => 'htc=htc wildfire e5 plus',
            'wildfire e1', 'htc wildfire e1' => 'htc=htc wildfire e1',
            'wildfire e1 plus' => 'htc=htc wildfire e1 plus',
            'wildfire e7' => 'htc=htc wildfire e7',
            'wildfire e7 plus' => 'htc=htc wildfire e7 plus',
            'wildfire e' => 'htc=htc wildfire e',
            'wildfire e plus', 'htc wildfire e plus' => 'htc=htc wildfire e plus',
            'wildfire e lite' => 'htc=htc wildfire e lite',
            'wildfire e3' => 'htc=htc wildfire e3',
            'wildfire e2' => 'htc=htc wildfire e2',
            'wildfire e2 plus' => 'htc=htc wildfire e2 plus',
            'wildfire x', 'htc wildfire x' => 'htc=htc wildfire x',
            'wildfire r70' => 'htc=htc wildfire r70',
            'wildfire e3 lite' => 'htc=htc wildfire e3 lite',
            'wildfire e star' => 'htc=htc wildfire e star',
            'wildfire e6 plus' => 'htc=htc wildfire e6 plus',
            // other
            default => null,
        };
    }
}
