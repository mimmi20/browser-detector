<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class PrestigioFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'psp5517duo'      => 'prestigio psp5517duo',
        'psp5508duo'      => 'prestigio psp5508duo',
        'psp5505duo'      => 'prestigio psp5505duo',
        'psp5504duo'      => 'prestigio psp5504duo',
        'psp5454duo'      => 'prestigio psp5454duo',
        'psp5453duo'      => 'prestigio psp5453duo',
        'psp8500'         => 'prestigio psp8500',
        'psp8400'         => 'prestigio psp8400',
        'pmt7177_3g'      => 'prestigio pmt7177_3g',
        'pmt7077_3g'      => 'prestigio pmt7077_3g',
        'pmt3287_3g'      => 'prestigio pmt3287_3g',
        'pmt3277_3g'      => 'prestigio pmt3277_3g',
        'pmt3037_3g'      => 'prestigio pmt3037_3g',
        'pmt5587_wi'      => 'prestigio pmt5587_wi',
        'pmt3767_3g'      => 'prestigio pmt3767_3g',
        'pmt3377_wi'      => 'prestigio pmt3377_wi',
        'pmt3118_3g'      => 'prestigio pmt3118_3g',
        'pmt3057_3g'      => 'prestigio pmt3057_3g',
        'pmp7480d3g_quad' => 'prestigio pmp7480d3g_quad',
        'pmp7380d3g'      => 'prestigio pmp7380d3g',
        'pmp7280c3g_quad' => 'prestigio pmp7280c3g_quad',
        'pmp7280c3g'      => 'prestigio pmp7280c3g',
        'pmp7170b3g'      => 'prestigio pmp7170b3g',
        'pmp7100d3g'      => 'prestigio pmp7100d3g',
        'pmp7079d_quad'   => 'prestigio pmp7079d_quad',
        'pmp7079d3g_quad' => 'prestigio pmp7079d3g_quad',
        'pmp7074b3gru'    => 'prestigio pmp7074b3gru',
        'pmp7070c3g'      => 'prestigio pmp7070c3g',
        'pmp5785c_quad'   => 'prestigio pmp5785c_quad',
        'pmp5785c3g_quad' => 'prestigio pmp5785c3g_quad',
        'pmp5770d'        => 'prestigio pmp5770d',
        'pmp5670c_duo'    => 'prestigio pmp5670c_duo',
        'pmp5580c'        => 'prestigio pmp5580c',
        'pmp5570c'        => 'prestigio pmp5570c',
        'pmp5297c_quad'   => 'prestigio pmp5297c_quad',
        'pmp5197dultra'   => 'prestigio pmp5197dultra',
        'pmp5101c_quad'   => 'prestigio pmp5101c_quad',
        'pmp5080cpro'     => 'prestigio pmp5080cpro',
        'pmp5080b'        => 'prestigio pmp5080b',
        'pmp3970b'        => 'prestigio pmp3970b',
        'pmp3870c'        => 'prestigio pmp3870c',
        'pmp3370b'        => 'prestigio pmp3370b',
        'pmp3074bru'      => 'prestigio pmp3074bru',
        'pmp3007c'        => 'prestigio pmp3007c',
        'pap7600duo'      => 'prestigio pap7600duo',
        'pap5503'         => 'prestigio pap5503',
        'pap5300duo'      => 'prestigio pap5300duo',
        'pap5044duo'      => 'prestigio pap5044duo',
        'pap5000tduo'     => 'prestigio pap5000tduo',
        'pap5000duo'      => 'prestigio pap5000duo',
        'pap4500duo'      => 'prestigio pap4500duo',
        'pap4044duo'      => 'prestigio pap4044duo',
        'pap3350duo'      => 'prestigio pap3350duo',
        'gv7777'          => 'prestigio gv7777',
    ];

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s): array
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general prestigio device', $useragent);
    }
}
