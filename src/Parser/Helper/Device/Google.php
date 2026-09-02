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
final class Google implements DeviceInterface
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
            'nexus 7' => 'google=google nexus 7',
            'pixel 3', 'aosp on blueline' => 'google=google pixel 3',
            'pixel 3a' => 'google=google pixel 3a',
            'pixel 4', 'google pixel 4' => 'google=google pixel 4',
            'pixel 4 xl' => 'google=google pixel 4 xl',
            'pixel 4a (5g)', 'pixel 4a (5g', 'aosp on bramble' => 'google=google pixel 4a 5g',
            'pixel 5' => 'google=google pixel 5',
            'pixel 6' => 'google=google pixel 6',
            'pixel 6a' => 'google=google pixel 6a',
            'pixel 6 pro' => 'google=google pixel 6 pro',
            'pixel 7' => 'google=google pixel 7',
            'pixel 7a' => 'google=google pixel 7a',
            'pixel 7 pro' => 'google=google pixel 7 pro',
            'pixel 8' => 'google=google pixel 8',
            'pixel 8x' => 'google=google pixel 8x',
            'kukui' => 'google=google kukui',
            'nexus 5', 'aosp on hammerhead' => 'google=google nexus 5',
            'pixel 4a', 'aosp on sunfish' => 'google=google pixel 4a',
            'pixel 9 pro xl' => 'google=google pixel 9 pro xl',
            'pixel 8a' => 'google=google pixel 8a',
            'pixel 9 pro fold' => 'google=google pixel 9 pro fold',
            'pixel 8 pro' => 'google=google pixel 8 pro',
            'pixel 2 xl', 'aosp on taimen' => 'google=google pixel 2 xl',
            'pixel 3a xl' => 'google=google pixel 3a xl',
            'pixel 5a' => 'google=google pixel 5a',
            'pixel 3 xl' => 'google=google pixel 3 xl',
            'pixel 2', 'google pixel 2' => 'google=google pixel 2',
            'nexus 5x' => 'google=google nexus 5x',
            'pixel c' => 'google=google pixel c',
            'pixel 9 pro' => 'google=google pixel 9 pro',
            'nexus 6p' => 'google=google nexus 6p',
            'pixel 9' => 'google=google pixel 9',
            'pixel xl' => 'google=google pixel xl',
            'gvu6c' => 'google=google gvu6c',
            'gqml3' => 'google=google gqml3',
            'go3z5' => 'google=google go3z5',
            'gb7n6' => 'google=google gb7n6',
            'g9s9b16' => 'google=google g9s9b16',
            'g9s9b' => 'google=google g9s9b',
            'gr1yh' => 'google=google gr1yh',
            'g025h' => 'google=google g025h',
            'gd1yq' => 'google=google gd1yq',
            'g025i' => 'google=google g025i',
            'g025e' => 'google=google g025e',
            'g6qu3' => 'google=google g6qu3',
            'g9fpl' => 'google=google g9fpl',
            'ge2ae' => 'google=google ge2ae',
            'gp4bc' => 'google=google gp4bc',
            'gfe4j' => 'google=google gfe4j',
            'g0dzq' => 'google=google g0dzq',
            'gwkk3' => 'google=google gwkk3',
            'ghl1x' => 'google=google ghl1x',
            'g82u8' => 'google=google g82u8',
            'g1mnw' => 'google=google g1mnw',
            'gc3ve' => 'google=google gc3ve',
            'g9bqd' => 'google=google g9bqd',
            'gkws6' => 'google=google gkws6',
            'ga04851-us' => 'google=google ga04851-us',
            'gzpfo' => 'google=google gzpfo',
            'gpj41' => 'google=google gpj41',
            'pipit' => 'google=google pipit',
            'gwvk6' => 'google=google gwvk6',
            'gec77' => 'google=google gec77',
            'gr83y' => 'google=google gr83y',
            'gur25' => 'google=google gur25',
            'g1b60' => 'google=google g1b60',
            'g2ybb' => 'google=google g2ybb',
            'gkv4x' => 'google=google gkv4x',
            'g6gpr' => 'google=google g6gpr',
            'g8hhn' => 'google=google g8hhn',
            'g576d' => 'google=google g576d',
            'ggh2x' => 'google=google ggh2x',
            'gc15s' => 'google=google gc15s',
            'g5nz6' => 'google=google g5nz6',
            'gtt9q' => 'google=google gtt9q',
            'g8vou' => 'google=google g8vou',
            'gf5kq' => 'google=google gf5kq',
            'gluog' => 'google=google gluog',
            'g025n' => 'google=google g025n',
            'g025j' => 'google=google g025j',
            'ga02099' => 'google=google ga02099',
            'g020p' => 'google=google g020p',
            'g020' => 'google=google g020',
            'ga01181-us' => 'google=google ga01181-us',
            'ga01182-us' => 'google=google ga01182-us',
            'ga01180-us' => 'google=google ga01180-us',
            'g020a' => 'google=google g020a',
            'g020b' => 'google=google g020b',
            'g020c' => 'google=google g020c',
            'g020e' => 'google=google g020e',
            'g020f' => 'google=google g020f',
            'g020g' => 'google=google g020g',
            'g020h' => 'google=google g020h',
            'g011c' => 'google=google g011c',
            'g4s1m' => 'google=google g4s1m',
            'g1f8f' => 'google=google g1f8f',
            'pixel 10 pro xl' => 'google=google pixel 10 pro xl',
            'g020i' => 'google=google g020i',
            'g020m' => 'google=google g020m',
            'ga01188-us' => 'google=google ga01188-us',
            'ga01187-us' => 'google=google ga01187-us',
            'ga01189-us' => 'google=google ga01189-us',
            'ga01191-us' => 'google=google ga01191-us',
            'pixel 9a' => 'google=google pixel 9a',
            'gxq96' => 'google=google gxq96',
            'gtf7p' => 'google=google gtf7p',
            'g3y12' => 'google=google g3y12',
            'chromecast' => 'google=google chromecast',
            'chromecast hd' => 'google=google chromecast hd',
            'nexus 10', 'aosp on manta' => 'google=google nexus 10',
            'pixel 10 pro' => 'google=google pixel 10 pro',
            'gehn3' => 'google=google gehn3',
            'g4qur' => 'google=google g4qur',
            'gn4f5' => 'google=google gn4f5',
            'pixel 10' => 'google=google pixel 10',
            'gk2mp' => 'google=google gk2mp',
            'glbw0' => 'google=google glbw0',
            'gl066' => 'google=google gl066',
            'pixel 10 pro fold' => 'google=google pixel 10 pro fold',
            'gu0np' => 'google=google gu0np',
            'gm66v' => 'google=google gm66v',
            'pixel 10a' => 'google=google pixel 10a',
            'ge1gq' => 'google=google ge1gq',
            'gv0bp' => 'google=google gv0bp',
            'g4h7l' => 'google=google g4h7l',
            'pixel fold' => 'google=google pixel fold',
            'nexus 6' => 'google=google nexus 6',
            'pixel' => 'google=google pixel',
            'google pixelbook' => 'google=google pixelbook',
            'pixel tablet' => 'google=google pixel tablet',
            'pixel tablet 2' => 'google=google pixel tablet 2',
            'google pixelbook go' => 'google=google pixelbook go',
            'pixel 11' => 'google=google pixel 11',
            'pixel 11 pro fold' => 'google=google pixel 11 pro fold',
            'pixel 9 fold' => 'google=google pixel 9 fold',
            'adt-3' => 'google=google adt-3',
            'pixel 11 pro' => 'google=google pixel 11 pro',
            'gm45k' => 'google=google gm45k',
            'g7swn' => 'google=google g7swn',
            // other
            default => null,
        };
    }
}
