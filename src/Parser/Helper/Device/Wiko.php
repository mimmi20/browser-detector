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
final class Wiko implements DeviceInterface
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
            'w-v750bn-eea' => 'wiko=wiko w-v750bn-eea',
            'w-v680-eea' => 'wiko=wiko w-v680-eea',
            'w-v730-eea' => 'wiko=wiko w-v730-eea',
            'w-v720-eea' => 'wiko=wiko w-v720-eea',
            'w-v755-ope' => 'wiko=wiko w-v755-ope',
            'w-v755-eea' => 'wiko=wiko w-v755-eea',
            'w-p611-eea' => 'wiko=wiko w-p611-eea',
            'w-k610-eea' => 'wiko=wiko w-k610-eea',
            'w-v745-eea' => 'wiko=wiko w-v745-eea',
            'w-v851-eea' => 'wiko=wiko w-v851-eea',
            'w-v830-eea' => 'wiko=wiko w-v830-eea',
            'w-v830-id' => 'wiko=wiko w-v830-id',
            'w-k630-eea' => 'wiko=wiko w-k630-eea',
            'harry' => 'wiko=wiko harry',
            'w_c800' => 'wiko=wiko wc800',
            'w-v600' => 'wiko=wiko w-v600',
            'lenny4 plus' => 'wiko=wiko lenny 4 plus',
            'view2 go' => 'wiko=wiko view 2 go',
            'lenny3' => 'wiko=wiko lenny 3',
            'w-k211-ope' => 'wiko=wiko w-k211-ope',
            'w-v850-eea' => 'wiko=wiko w-v850-eea',
            'view prime' => 'wiko=wiko view prime',
            'sunny2 plus' => 'wiko=wiko sunny 2 plus',
            'w-k510-eea' => 'wiko=wiko w-k510-eea',
            'pulp 4g' => 'wiko=wiko pulp 4g',
            'w-k521-eea' => 'wiko=wiko w-k521-eea',
            'jerry' => 'wiko=wiko jerry',
            'w-p311-eea' => 'wiko=wiko w-p311-eea',
            'w_c860' => 'wiko=wiko wc860',
            'w-v800-eea' => 'wiko=wiko w-v800-eea',
            'w_p130' => 'wiko=wiko wp130',
            'w-v750bn-ope' => 'wiko=wiko w-v750bn-ope',
            'sunny' => 'wiko=wiko sunny',
            'view2 plus' => 'wiko=wiko view2 plus',
            'w_k400' => 'wiko=wiko lenny 5',
            'vhem' => 'wiko=wiko vhem',
            'u616at' => 'wiko=wiko u616at',
            'jlg-an00' => 'wiko=wiko jlg-an00',
            'shr-an00' => 'wiko=wiko shr-an00',
            'aix-an00' => 'wiko=wiko aix-an00',
            'tommy' => 'wiko=wiko tommy',
            'tommy2' => 'wiko=wiko tommy 2',
            'tommy3' => 'wiko=wiko tommy 3',
            'rainbow 4g' => 'wiko=wiko rainbow 4g',
            'rainbow' => 'wiko=wiko rainbow',
            'mky-an20' => 'wiko=wiko mky-an20',
            'che-an00' => 'wiko=wiko che-an00',
            'jlg-an80' => 'wiko=wiko jlg-an80',
            'snp-an00' => 'wiko=wiko snp-an00',
            'lgn-an00' => 'wiko=wiko lgn-an00',
            'bal-an20' => 'wiko=wiko bal-an20',
            'wiko w-v770' => 'wiko=wiko w-v770',
            'lft-an00' => 'wiko=wiko lft-an00',
            'jey-an00' => 'wiko=wiko jey-an00',
            // other
            default => null,
        };
    }
}
