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
final class Amazon implements DeviceInterface
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
            'kfkawi' => 'amazon=amazon kfkawi',
            'kfgiwi' => 'amazon=amazon kfgiwi',
            'kffowi' => 'amazon=amazon kffowi',
            'kfmuwi' => 'amazon=amazon kfmuwi',
            'kfdowi' => 'amazon=amazon kfdowi',
            'kftrwi' => 'amazon=amazon kftrwi',
            'kftrpwi' => 'amazon=amazon kftrpwi',
            'kfrapwi' => 'amazon=amazon kfrapwi',
            'kfonwi' => 'amazon=amazon kfonwi',
            'kfmawi' => 'amazon=amazon kfmawi',
            'kfsuwi' => 'amazon=amazon kfsuwi',
            'aftmm' => 'amazon=amazon aftmm',
            'aftsss' => 'amazon=amazon aftsss',
            'kftbwi' => 'amazon=amazon kftbwi',
            'kfauwi' => 'amazon=amazon kfauwi',
            'kfsawi' => 'amazon=amazon kfsawi',
            'kfquwi' => 'amazon=amazon kfquwi',
            'aftt' => 'amazon=amazon aftt',
            'afttiff43' => 'amazon=amazon afttiff43',
            'aeobc' => 'amazon=amazon aeobc',
            'aeokn' => 'amazon=amazon aeokn',
            'kfapwa' => 'amazon=amazon kfapwa',
            'kfaswi' => 'amazon=amazon kfaswi',
            'kfjwa' => 'amazon=amazon kfjwa',
            'kfjwi' => 'amazon=amazon kfjwi',
            'kfot' => 'amazon=amazon kfot',
            'aftss' => 'amazon=amazon aftss',
            'afts' => 'amazon=amazon afts',
            'kftuwi' => 'amazon=amazon kftuwi',
            'kfrawi' => 'amazon=amazon kfrawi',
            't76n2b' => 'amazon=amazon t76n2b',
            'kfmewi' => 'amazon=amazon kfmewi',
            'kfsnwi' => 'amazon=amazon kfsnwi',
            'kfsawa' => 'amazon=amazon kfsawa',
            'kfarwi' => 'amazon=amazon kfarwi',
            'kftt' => 'amazon=amazon kftt',
            'kfapwi' => 'amazon=amazon kfapwi',
            'kfthwi', 'kindle fire hdx 7' => 'amazon=amazon kfthwi',
            'kfthwa', 'kindle fire hdx' => 'amazon=amazon kfthwa',
            'kfsowi', 'amazon kindle fire hd' => 'amazon=amazon kfsowi',
            'aftn' => 'amazon=amazon aftn',
            'aftm' => 'amazon=amazon aftm',
            'aftb' => 'amazon=amazon aftb',
            'afta' => 'amazon=amazon afta',
            'aeohp' => 'amazon=amazon aeohp',
            'aftkrt' => 'amazon=amazon aftkrt',
            'aftka' => 'amazon=amazon aftka',
            'aftgazl' => 'amazon=amazon aftgazl',
            'aeohy' => 'amazon=amazon aeohy',
            'amazon kindle fire2' => 'amazon=amazon kindle fire 2',
            'sd4930ur' => 'amazon=amazon sd4930ur',
            'amazon tate' => 'amazon=amazon tate',
            'amazon jem' => 'amazon=amazon jem',
            'amazon kindle fire', 'kindle fire' => 'amazon=amazon d01400',
            'aeoch' => 'amazon=amazon aeoch',
            'aftti43' => 'amazon=amazon aftti43',
            // has conflicts with another amazon device
            // 'aftkauk001' => 'amazon=amazon aftkauk001',
            'aftr' => 'amazon=amazon aftr',
            'aftkm' => 'amazon=amazon aftkm',
            'aftka002' => 'amazon=amazon aftka002',
            'aftkauk002' => 'amazon=amazon aftkauk002',
            'aeocw' => 'amazon=amazon aeocw',
            'aeobp' => 'amazon=amazon aeobp',
            'aeocn' => 'amazon=amazon aeocn',
            'aftbu001' => 'amazon=amazon aftbu001',
            'aftca002' => 'amazon=amazon aftca002',
            'aftcl001' => 'amazon=amazon aftcl001',
            'kfraswi' => 'amazon=amazon kfraswi',
            'afthy7abba' => 'amazon=amazon afthy7abba',
            'aeoat' => 'amazon=amazon aeoat',
            'aeota' => 'amazon=amazon aeota',
            // other
            default => null,
        };
    }
}
