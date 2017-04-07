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
use Psr\Cache\CacheItemPoolInterface;
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
        if ($s->contains('PMT7077_3G', true)) {
            return $this->loader->load('pmt7077_3g', $useragent);
        }

        if ($s->contains('PMT3287_3G', true)) {
            return $this->loader->load('pmt3287_3g', $useragent);
        }

        if ($s->contains('PMT3277_3G', true)) {
            return $this->loader->load('pmt3277_3g', $useragent);
        }

        if ($s->contains('PMT3037_3G', true)) {
            return $this->loader->load('pmt3037_3g', $useragent);
        }

        if ($s->contains('PMT5587_Wi', true)) {
            return $this->loader->load('pmt5587_wi', $useragent);
        }

        if ($s->contains('PMT3377_Wi', true)) {
            return $this->loader->load('pmt3377_wi', $useragent);
        }

        if ($s->contains('PMP7480D3G_QUAD', true)) {
            return $this->loader->load('pmp7480d3g_quad', $useragent);
        }

        if ($s->contains('PMP7380D3G', true)) {
            return $this->loader->load('pmp7380d3g', $useragent);
        }

        if ($s->contains('PMP7280C3G_QUAD', true)) {
            return $this->loader->load('pmp7280c3g_quad', $useragent);
        }

        if ($s->contains('PMP7280C3G', true)) {
            return $this->loader->load('pmp7280c3g', $useragent);
        }

        if ($s->contains('PMP7170B3G', true)) {
            return $this->loader->load('pmp7170b3g', $useragent);
        }

        if ($s->contains('PMP7100D3G', true)) {
            return $this->loader->load('pmp7100d3g', $useragent);
        }

        if ($s->contains('PMP7079D_QUAD', true)) {
            return $this->loader->load('pmp7079d_quad', $useragent);
        }

        if ($s->contains('PMP7079D3G_QUAD', true)) {
            return $this->loader->load('pmp7079d3g_quad', $useragent);
        }

        if ($s->contains('PMP7074B3GRU', true)) {
            return $this->loader->load('pmp7074b3gru', $useragent);
        }

        if ($s->contains('PMP7070C3G', true)) {
            return $this->loader->load('pmp7070c3g', $useragent);
        }

        if ($s->contains('PMP5785C_QUAD', true)) {
            return $this->loader->load('pmp5785c_quad', $useragent);
        }

        if ($s->contains('PMP5785C3G_QUAD', true)) {
            return $this->loader->load('pmp5785c3g_quad', $useragent);
        }

        if ($s->contains('PMP5770D', true)) {
            return $this->loader->load('pmp5770d', $useragent);
        }

        if ($s->contains('PMP5670C_DUO', true)) {
            return $this->loader->load('pmp5670c_duo', $useragent);
        }

        if ($s->contains('PMP5580C', true)) {
            return $this->loader->load('pmp5580c', $useragent);
        }

        if ($s->contains('PMP5570C', true)) {
            return $this->loader->load('pmp5570c', $useragent);
        }

        if ($s->contains('PMP5297C_QUAD', true)) {
            return $this->loader->load('pmp5297c_quad', $useragent);
        }

        if ($s->contains('PMP5197DULTRA', true)) {
            return $this->loader->load('pmp5197dultra', $useragent);
        }

        if ($s->contains('PMP5101C_QUAD', true)) {
            return $this->loader->load('pmp5101c_quad', $useragent);
        }

        if ($s->contains('PMP5080CPRO', true)) {
            return $this->loader->load('pmp5080cpro', $useragent);
        }

        if ($s->contains('PMP5080B', true)) {
            return $this->loader->load('pmp5080b', $useragent);
        }

        if ($s->contains('PMP3970B', true)) {
            return $this->loader->load('pmp3970b', $useragent);
        }

        if ($s->contains('PMP3870C', true)) {
            return $this->loader->load('pmp3870c', $useragent);
        }

        if ($s->contains('PMP3370B', true)) {
            return $this->loader->load('pmp3370b', $useragent);
        }

        if ($s->contains('PMP3074BRU', true)) {
            return $this->loader->load('pmp3074bru', $useragent);
        }

        if ($s->contains('PMP3007C', true)) {
            return $this->loader->load('pmp3007c', $useragent);
        }

        if ($s->contains('PAP7600DUO', true)) {
            return $this->loader->load('pap7600duo', $useragent);
        }

        if ($s->contains('PAP5503', true)) {
            return $this->loader->load('pap5503', $useragent);
        }

        if ($s->contains('PAP5044DUO', true)) {
            return $this->loader->load('pap5044duo', $useragent);
        }

        if ($s->contains('PAP5000TDUO', true)) {
            return $this->loader->load('pap5000tduo', $useragent);
        }

        if ($s->contains('PAP5000DUO', true)) {
            return $this->loader->load('pap5000duo', $useragent);
        }

        if ($s->contains('PAP4500DUO', true)) {
            return $this->loader->load('pap4500duo', $useragent);
        }

        if ($s->contains('PAP4044DUO', true)) {
            return $this->loader->load('pap4044duo', $useragent);
        }

        if ($s->contains('PAP3350DUO', true)) {
            return $this->loader->load('pap3350duo', $useragent);
        }

        if ($s->contains('PSP8500', true)) {
            return $this->loader->load('psp8500', $useragent);
        }

        if ($s->contains('PSP8400', true)) {
            return $this->loader->load('psp8400', $useragent);
        }

        if ($s->contains('GV7777', true)) {
            return $this->loader->load('gv7777', $useragent);
        }

        return $this->loader->load('general prestigio device', $useragent);
    }
}
