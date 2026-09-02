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
final class Gigaset implements DeviceInterface
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
        $specialDevices = [];

        return match ($code) {
            'e940-2795-00' => 'gigaset=gigaset e940-2795-00',
            'e940-2796-00' => 'gigaset=gigaset e940-2796-00',
            'gs185' => 'gigaset=gigaset gs185',
            'gx290' => 'gigaset=gigaset gx290',
            'gs110' => 'gigaset=gigaset gs110',
            'gs100' => 'gigaset=gigaset gs100',
            'e940-2766-00' => 'gigaset=gigaset e940-2766-00',
            'gs190' => 'gigaset=gigaset gs190',
            'gs270 plus' => 'gigaset=gigaset gs270 plus',
            'gs195' => 'gigaset=gigaset gs195',
            'gigaset gs170' => 'gigaset=gigaset gs170',
            'gs290' => 'gigaset=gigaset gs290',
            'e940-2878-03' => 'gigaset=gigaset e940-2878-03',
            'gs270' => 'gigaset=gigaset gs270',
            'gs180' => 'gigaset=gigaset gs180',
            'gs370', 'gigaset gs370' => 'gigaset=gigaset gs370',
            'gs280' => 'gigaset=gigaset gs280',
            'e940-2797-00' => 'gigaset=gigaset e940-2797-00',
            'gigaset gs160' => 'gigaset=gigaset gs160',
            'e940-2849-00' => 'gigaset=gigaset e940-2849-00',
            'gs370_plus' => 'gigaset=gigaset gs370 plus',
            'gs80' => 'gigaset=gigaset gs80',
            'gs57-6' => 'gigaset=gigaset gs57-6',
            'gs55-6' => 'gigaset=gigaset gs55-6',
            'gs53-6' => 'gigaset=gigaset gs53-6',
            'qv1030', 'gigaset qv1030' => 'gigaset=gigaset qv1030',
            'gigaset qv830' => 'gigaset=gigaset qv830',
            'maxwell-10' => 'gigaset=gigaset maxwell 10',
            'e940-2849-01' => 'gigaset=gigaset e940-2849-01',
            'e940-2797-01' => 'gigaset=gigaset e940-2797-01',
            'e940-3043-00' => 'gigaset=gigaset e940-3043-00',
            // other
            default => null,
        };
    }
}
