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
final class Lenovo implements DeviceInterface
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
            'lenovo tb-x304f' => 'lenovo=lenovo tb-x304f',
            'lenovo yt-j706f' => 'lenovo=lenovo yt-j706f',
            'x1030x' => 'lenovo=lenovo x1030x',
            'lenovo tb-x306x' => 'lenovo=lenovo tb-x306x',
            'lenovo tb-x306xa' => 'lenovo=lenovo tb-x306xa',
            'lenovo tb-j616f' => 'lenovo=lenovo tb-j616f',
            'lenovo tb-j616x' => 'lenovo=lenovo tb-j616x',
            'lenovo tb-x606f' => 'lenovo=lenovo tb-x606f',
            'lenovo tb-8705f' => 'lenovo=lenovo tb-8705f',
            'lenovo tb-8505x' => 'lenovo=lenovo tb-8505x',
            'lenovo tb-x605f' => 'lenovo=lenovo tb-x605f',
            'lenovo tb-8504x' => 'lenovo=lenovo tb-8504x',
            'lenovo yt3-x50f' => 'lenovo=lenovo yt3-x50f',
            'lenovo tb-x705f' => 'lenovo=lenovo tb-x705f',
            'lenovo tb-8505fs' => 'lenovo=lenovo tb-8505fs',
            'lenovo yt-x705f' => 'lenovo=lenovo yt-x705f',
            'tb350xu' => 'lenovo=lenovo tb350xu',
            'b5032' => 'lenovo=lenovo b5032',
            'tb330fu', 'lenovo tb330fu' => 'lenovo=lenovo tb330fu',
            'tb350fu' => 'lenovo=lenovo tb350fu',
            'tb310fu' => 'lenovo=lenovo tb310fu',
            'lifetab_s1036x' => 'medion=lenovo lifetab s1036x',
            'lenovo a2016a40' => 'lenovo=lenovo a2016a40',
            'lenovo tb-x505l' => 'lenovo=lenovo tb-x505l',
            'lenovo tb-j606f' => 'lenovo=lenovo tb-j606f',
            'lenovo tb-8704x' => 'lenovo=lenovo tb-8704x',
            'lenovo tb-x306fa' => 'lenovo=lenovo tb-x306fa',
            'lenovo tb-x103f' => 'lenovo=lenovo tb-x103f',
            'lenovo tb-x505f' => 'lenovo=lenovo tb-x505f',
            'lenovo tb-x104l' => 'lenovo=lenovo tb-x104l',
            'lenovo tb-8505f' => 'lenovo=lenovo tb-8505f',
            'lenovo tab 2 a10-70f' => 'lenovo=lenovo a10-70f',
            'lenovo tb-x306f' => 'lenovo=lenovo tb-x306f',
            'lenovo yt-x703l' => 'lenovo=lenovo yt-x703l',
            'tb328fu' => 'lenovo=lenovo tb328fu',
            'lenovo p2a42' => 'lenovo=lenovo p2a42',
            's1032x' => 'lenovo=lenovo s1032x',
            'lenovo k33a48' => 'lenovo=lenovo k33a48',
            'lenovo tb-x704l' => 'lenovo=lenovo tb-x704l',
            'lenovo tb-x704f' => 'lenovo=lenovo tb-x704f',
            'lenovo tb-x606fa' => 'lenovo=lenovo tb-x606fa',
            'lenovo tb3-x70l', 'tb3-x70l' => 'lenovo=lenovo tb3-x70l',
            'lenovo tb-x605fc' => 'lenovo=lenovo tb-x605fc',
            'lenovo tb-x304l' => 'lenovo=lenovo tb-x304l',
            'lenovo tb-x705l' => 'lenovo=lenovo tb-x705l',
            'lenovo tb-8505xs' => 'lenovo=lenovo tb-8505xs',
            'lenovo yt3-x50l' => 'lenovo=lenovo yt3-x50l',
            'lenovo tb-x104f' => 'lenovo=lenovo tb-x104f',
            'lifetab e1041x', 'e1041x' => 'lenovo=lenovo e1041x',
            'tb328xu' => 'lenovo=lenovo tb328xu',
            'tb125fu', 'lenovo tb125fu' => 'lenovo=lenovo tb125fu',
            'tb370fu', 'lenovo tb370fu' => 'lenovo=lenovo tb370fu',
            'lenovo tb3-x70f' => 'lenovo=lenovo tb3-x70f',
            'lenovo tb2-x30f' => 'lenovo=lenovo tb2-x30f',
            'lenovo tb3-850m' => 'lenovo=lenovo tb3-850m',
            'p1060x' => 'lenovo=lenovo p1060x',
            'lenovo tb-7305f' => 'lenovo=lenovo tb-7305f',
            'lenovo tb3-850f' => 'lenovo=lenovo tb3-850f',
            'lenovo tb-x605l' => 'lenovo=lenovo tb-x605l',
            'lenovo yt-x705l' => 'lenovo=lenovo yt-x705l',
            'lenovo tb-x606x' => 'lenovo=lenovo tb-x606x',
            'e1050x' => 'lenovo=lenovo e1050x',
            'lenovo yb-q501f' => 'lenovo=lenovo yb-q501f',
            'lenovo tb2-x30l' => 'lenovo=lenovo tb2-x30l',
            'lenovo tb-j607z' => 'lenovo=lenovo tb-j607z',
            'lenovo tb-8504f' => 'lenovo=lenovo tb-8504f',
            'lenovo l39051' => 'lenovo=lenovo l39051',
            'lenovo tb-j706l' => 'lenovo=lenovo tb-j706l',
            'lenovo tb-8703f' => 'lenovo=lenovo tb-8703f',
            'e1060x' => 'lenovo=lenovo e1060x',
            'lenovo k33a42' => 'lenovo=lenovo k33a42',
            'yoga tablet 2-1050f' => 'lenovo=lenovo 1050f',
            'lenovo yt-x703f' => 'lenovo=lenovo yt-x703f',
            'lenovo tb-j606l' => 'lenovo=lenovo tb-j606l',
            'lenovo tab 2 a10-70l' => 'lenovo=lenovo a10-70l',
            'tb351fu', 'lenovo tb351fu' => 'lenovo=lenovo tb351fu',
            'tb311xu', 'lenovo tb311xu' => 'lenovo=lenovo tb311xu',
            '20jjs0cu1m' => 'lenovo=lenovo 20jjs0cu1m',
            'tb321fu', 'lenovo tb321fu' => 'lenovo=lenovo tb321fu',
            'lenovo tb-j606n' => 'lenovo=lenovo tb-j606n',
            'lenovo z5s' => 'lenovo=lenovo z5s',
            'lenovo tb-j6c6f' => 'lenovo=lenovo tb-j6c6f',
            'xt2091-8' => 'lenovo=lenovo xt2091-8',
            'xt2091-7' => 'lenovo=lenovo xt2091-7',
            'l71061', 'lenovo l71061' => 'lenovo=lenovo l71061',
            'lenovo tb-9707f' => 'lenovo=lenovo tb-9707f',
            'tb-q706z' => 'lenovo=lenovo tb-q706z',
            'lenovo tb-q706f' => 'lenovo=lenovo tb-q706f',
            'tb311fu' => 'lenovo=lenovo tb311fu',
            'tb320fc' => 'lenovo=lenovo tb320fc',
            'tb330xu' => 'lenovo=lenovo tb330xu',
            'tb331fc' => 'lenovo=lenovo tb331fc',
            'tb360zu' => 'lenovo=lenovo tb360zu',
            'tb371fc' => 'lenovo=lenovo tb371fc',
            'tb373fu' => 'lenovo=lenovo tb373fu',
            'tb375fc' => 'lenovo=lenovo tb375fc',
            'tb310xu' => 'lenovo=lenovo tb310xu',
            'tb301xu' => 'lenovo=lenovo tb301xu',
            'tb301fu' => 'lenovo=lenovo tb301fu',
            'tb300xu' => 'lenovo=lenovo tb300xu',
            'tb300fu' => 'lenovo=lenovo tb300fu',
            'tb132fu' => 'lenovo=lenovo tb132fu',
            'tb128xu', 'lenovo tb128xu' => 'lenovo=lenovo tb128xu',
            'tb128fu', 'lenovo tb128fu' => 'lenovo=lenovo tb128fu',
            'lenovo x3a40' => 'lenovo=lenovo x3a40',
            'l38043', 'lenovo l38043' => 'lenovo=lenovo l38043',
            'tb138fc', 'lenovo tb138fc' => 'lenovo=lenovo tb138fc',
            'xiaoxin pad 2022' => 'lenovo=lenovo xiaoxin pad 2022',
            'lenovo n23 yoga/flex 11 chromebook', 'lenovo n23 yoga' => 'lenovo=lenovo n23 yoga/flex 11 chromebook',
            'tb330fup' => 'lenovo=lenovo tb330fup',
            'a301lv' => 'lenovo=lenovo a301lv',
            'tb336fu' => 'lenovo=lenovo tb336fu',
            'tb336zu' => 'lenovo=lenovo tb336zu',
            'tb361fu' => 'lenovo=lenovo tb361fu',
            'tb361zu' => 'lenovo=lenovo tb361zu',
            'tb305fu' => 'lenovo=lenovo tb305fu',
            'lenovo a6600d40' => 'lenovo=lenovo a6600d40',
            'lenovo a6600a40' => 'lenovo=lenovo a6600a40',
            'lenovo a7010a48' => 'lenovo=lenovo a7010a48',
            'lenovo thinkpad 11e 3rd gen chromebook' => 'lenovo=lenovo thinkpad 11e 3rd gen chromebook',
            'lenovo k10a40' => 'lenovo=lenovo k10a40',
            'lenovo tb-x616f' => 'lenovo=lenovo tb-x616f',
            'tb365fc' => 'lenovo=lenovo tb365fc',
            'tb330xup' => 'lenovo=lenovo tb330xup',
            'tb322fc' => 'lenovo=lenovo tb322fc',
            'tb305xu' => 'lenovo=lenovo tb305xu',
            'tb305fubn' => 'lenovo=lenovo tb305fubn',
            'lenovo legion y90' => 'lenovo=lenovo legion y90',
            'tb710fu' => 'lenovo=lenovo tb710fu',
            'tb520fu' => 'lenovo=lenovo tb520fu',
            'tb323fu' => 'lenovo=lenovo tb323fu',
            'zah20097cn' => 'lenovo=lenovo zah20097cn',
            'tb352fc' => 'lenovo=lenovo tb352fc',
            'tb352fu' => 'lenovo=lenovo tb352fu',
            'tb376fc' => 'lenovo=lenovo tb376fc',
            'tb335fc' => 'lenovo=lenovo tb335fc',
            'tb372fc' => 'lenovo=lenovo tb372fc',
            'ideapad k1' => 'lenovo=lenovo ideapad k1',
            'a6020a46' => 'lenovo=lenovo a6020a46',
            'a6020a40' => 'lenovo=lenovo a6020a40',
            'a6020', 'lineage_a6020' => 'lenovo=lenovo a6020',
            // other
            default => null,
        };
    }
}
