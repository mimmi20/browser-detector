<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\LoaderInterface;
use Stringy\Stringy;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class PrestigioFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'psp5517duo'      => 'prestigio psp5517duo',
        'psp5505duo'      => 'prestigio psp5505duo',
        'psp5453duo'      => 'prestigio psp5453duo',
        'pmt7177_3g'      => 'pmt7177_3g',
        'pmt7077_3g'      => 'pmt7077_3g',
        'pmt3287_3g'      => 'pmt3287_3g',
        'pmt3277_3g'      => 'pmt3277_3g',
        'pmt3037_3g'      => 'pmt3037_3g',
        'pmt5587_wi'      => 'pmt5587_wi',
        'pmt3377_wi'      => 'pmt3377_wi',
        'pmp7480d3g_quad' => 'pmp7480d3g_quad',
        'pmp7380d3g'      => 'pmp7380d3g',
        'pmp7280c3g_quad' => 'pmp7280c3g_quad',
        'pmp7280c3g'      => 'pmp7280c3g',
        'pmp7170b3g'      => 'pmp7170b3g',
        'pmp7100d3g'      => 'pmp7100d3g',
        'pmp7079d_quad'   => 'pmp7079d_quad',
        'pmp7079d3g_quad' => 'pmp7079d3g_quad',
        'pmp7074b3gru'    => 'pmp7074b3gru',
        'pmp7070c3g'      => 'pmp7070c3g',
        'pmp5785c_quad'   => 'pmp5785c_quad',
        'pmp5785c3g_quad' => 'pmp5785c3g_quad',
        'pmp5770d'        => 'pmp5770d',
        'pmp5670c_duo'    => 'pmp5670c_duo',
        'pmp5580c'        => 'pmp5580c',
        'pmp5570c'        => 'pmp5570c',
        'pmp5297c_quad'   => 'pmp5297c_quad',
        'pmp5197dultra'   => 'pmp5197dultra',
        'pmp5101c_quad'   => 'pmp5101c_quad',
        'pmp5080cpro'     => 'pmp5080cpro',
        'pmp5080b'        => 'pmp5080b',
        'pmp3970b'        => 'pmp3970b',
        'pmp3870c'        => 'pmp3870c',
        'pmp3370b'        => 'pmp3370b',
        'pmp3074bru'      => 'pmp3074bru',
        'pmp3007c'        => 'pmp3007c',
        'pap7600duo'      => 'pap7600duo',
        'pap5503'         => 'pap5503',
        'pap5044duo'      => 'pap5044duo',
        'pap5000tduo'     => 'pap5000tduo',
        'pap5000duo'      => 'pap5000duo',
        'pap4500duo'      => 'pap4500duo',
        'pap4044duo'      => 'pap4044duo',
        'pap3350duo'      => 'pap3350duo',
        'psp8500'         => 'psp8500',
        'psp8400'         => 'psp8400',
        'gv7777'          => 'gv7777',
    ];

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(LoaderInterface $loader)
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
    public function detect($useragent, Stringy $s = null)
    {
        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('general prestigio device', $useragent);
    }
}
