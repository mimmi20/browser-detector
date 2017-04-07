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
class SonyFactory implements Factory\FactoryInterface
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
        if ($s->contains('f3111', false)) {
            return $this->loader->load('f3111', $useragent);
        }

        if ($s->contains('e6853', false)) {
            return $this->loader->load('e6853', $useragent);
        }

        if ($s->contains('e6653', false)) {
            return $this->loader->load('e6653', $useragent);
        }

        if ($s->contains('e6553', false)) {
            return $this->loader->load('e6553', $useragent);
        }

        if ($s->contains('e5823', false)) {
            return $this->loader->load('e5823', $useragent);
        }

        if ($s->contains('e5603', false)) {
            return $this->loader->load('e5603', $useragent);
        }

        if ($s->contains('e2303', false)) {
            return $this->loader->load('e2303', $useragent);
        }

        if ($s->contains('e2105', false)) {
            return $this->loader->load('e2105', $useragent);
        }

        if ($s->contains('e2003', false)) {
            return $this->loader->load('e2003', $useragent);
        }

        if ($s->contains('c5502', false)) {
            return $this->loader->load('c5502', $useragent);
        }

        if ($s->contains('c5303', false)) {
            return $this->loader->load('c5303', $useragent);
        }

        if ($s->contains('c5302', false)) {
            return $this->loader->load('c5302', $useragent);
        }

        if ($s->contains('xperia s', false)) {
            return $this->loader->load('xperia s', $useragent);
        }

        if ($s->contains('c6902', false)) {
            return $this->loader->load('c6902', $useragent);
        }

        if ($s->contains('l36h', false)) {
            return $this->loader->load('l36h', $useragent);
        }

        if ($s->containsAny(['xperia z1', 'c6903'], false)) {
            return $this->loader->load('c6903', $useragent);
        }

        if ($s->contains('c6833', false)) {
            return $this->loader->load('c6833', $useragent);
        }

        if ($s->contains('c6606', false)) {
            return $this->loader->load('c6606', $useragent);
        }

        if ($s->contains('c6602', false)) {
            return $this->loader->load('c6602', $useragent);
        }

        if ($s->containsAny(['xperia z', 'c6603'], false)) {
            return $this->loader->load('c6603', $useragent);
        }

        if ($s->contains('c6503', false)) {
            return $this->loader->load('c6503', $useragent);
        }

        if ($s->contains('c2305', false)) {
            return $this->loader->load('c2305', $useragent);
        }

        if ($s->contains('c2105', false)) {
            return $this->loader->load('c2105', $useragent);
        }

        if ($s->contains('c2005', false)) {
            return $this->loader->load('c2005', $useragent);
        }

        if ($s->contains('c1905', false)) {
            return $this->loader->load('c1905', $useragent);
        }

        if ($s->contains('c1904', false)) {
            return $this->loader->load('c1904', $useragent);
        }

        if ($s->contains('c1605', false)) {
            return $this->loader->load('c1605', $useragent);
        }

        if ($s->contains('c1505', false)) {
            return $this->loader->load('c1505', $useragent);
        }

        if ($s->contains('d5803', false)) {
            return $this->loader->load('d5803', $useragent);
        }

        if ($s->contains('d6633', false)) {
            return $this->loader->load('d6633', $useragent);
        }

        if ($s->contains('d6603', false)) {
            return $this->loader->load('d6603', $useragent);
        }

        if ($s->contains('l50u', false)) {
            return $this->loader->load('l50u', $useragent);
        }

        if ($s->contains('d6503', false)) {
            return $this->loader->load('d6503', $useragent);
        }

        if ($s->contains('d5833', false)) {
            return $this->loader->load('d5833', $useragent);
        }

        if ($s->contains('d5503', false)) {
            return $this->loader->load('d5503', $useragent);
        }

        if ($s->contains('d5303', false)) {
            return $this->loader->load('d5303', $useragent);
        }

        if ($s->contains('d5103', false)) {
            return $this->loader->load('d5103', $useragent);
        }

        if ($s->contains('d2403', false)) {
            return $this->loader->load('d2403', $useragent);
        }

        if ($s->contains('d2306', false)) {
            return $this->loader->load('d2306', $useragent);
        }

        if ($s->contains('d2303', false)) {
            return $this->loader->load('d2303', $useragent);
        }

        if ($s->contains('d2302', false)) {
            return $this->loader->load('d2302', $useragent);
        }

        if ($s->contains('d2203', false)) {
            return $this->loader->load('d2203', $useragent);
        }

        if ($s->contains('d2105', false)) {
            return $this->loader->load('d2105', $useragent);
        }

        if ($s->contains('d2005', false)) {
            return $this->loader->load('d2005', $useragent);
        }

        if ($s->contains('SGPT13', false)) {
            return $this->loader->load('sgpt13', $useragent);
        }

        if ($s->contains('sgpt12', false)) {
            return $this->loader->load('sgpt12', $useragent);
        }

        if ($s->contains('SGP771', false)) {
            return $this->loader->load('sgp771', $useragent);
        }

        if ($s->contains('SGP712', false)) {
            return $this->loader->load('sgp712', $useragent);
        }

        if ($s->contains('SGP621', false)) {
            return $this->loader->load('sgp621', $useragent);
        }

        if ($s->contains('SGP611', false)) {
            return $this->loader->load('sgp611', $useragent);
        }

        if ($s->contains('SGP521', false)) {
            return $this->loader->load('sgp521', $useragent);
        }

        if ($s->contains('SGP512', false)) {
            return $this->loader->load('sgp512', $useragent);
        }

        if ($s->contains('SGP511', false)) {
            return $this->loader->load('sgp511', $useragent);
        }

        if ($s->contains('SGP412', false)) {
            return $this->loader->load('sgp412', $useragent);
        }

        if ($s->contains('SGP321', false)) {
            return $this->loader->load('sgp321', $useragent);
        }

        if ($s->contains('SGP312', false)) {
            return $this->loader->load('sgp312', $useragent);
        }

        if ($s->contains('SGP311', false)) {
            return $this->loader->load('sgp311', $useragent);
        }

        if ($s->contains('ST26i', false)) {
            return $this->loader->load('st26i', $useragent);
        }

        if ($s->contains('ST26a', false)) {
            return $this->loader->load('st26a', $useragent);
        }

        if ($s->contains('ST23i', false)) {
            return $this->loader->load('st23i', $useragent);
        }

        if ($s->contains('ST21iv', false)) {
            return $this->loader->load('st21iv', $useragent);
        }

        if ($s->contains('ST21i2', false)) {
            return $this->loader->load('st21i2', $useragent);
        }

        if ($s->contains('ST21i', false)) {
            return $this->loader->load('st21i', $useragent);
        }

        if ($s->containsAny(['lt30p', 'xperia t'], false)) {
            return $this->loader->load('lt30p', $useragent);
        }

        if ($s->contains('LT29i', false)) {
            return $this->loader->load('lt29i', $useragent);
        }

        if ($s->contains('LT26w', false)) {
            return $this->loader->load('lt26w', $useragent);
        }

        if ($s->contains('LT25i', false)) {
            return $this->loader->load('lt25i', $useragent);
        }

        if ($s->contains('X10iv', false)) {
            return $this->loader->load('x10iv', $useragent);
        }

        if ($s->contains('X10i', false)) {
            return $this->loader->load('x10i', $useragent);
        }

        if ($s->contains('X10a', false)) {
            return $this->loader->load('x10a', $useragent);
        }

        if ($s->contains('X10', false)) {
            return $this->loader->load('sonyericsson x10', $useragent);
        }

        if ($s->contains('U20iv', false)) {
            return $this->loader->load('u20iv', $useragent);
        }

        if ($s->contains('U20i', false)) {
            return $this->loader->load('u20i', $useragent);
        }

        if ($s->contains('U20a', false)) {
            return $this->loader->load('u20a', $useragent);
        }

        if ($s->contains('ST27i', false)) {
            return $this->loader->load('st27i', $useragent);
        }

        if ($s->contains('ST25iv', false)) {
            return $this->loader->load('st25iv', $useragent);
        }

        if ($s->contains('ST25i', false)) {
            return $this->loader->load('st25i', $useragent);
        }

        if ($s->contains('ST25a', false)) {
            return $this->loader->load('st25a', $useragent);
        }

        if ($s->contains('ST18iv', false)) {
            return $this->loader->load('st18iv', $useragent);
        }

        if ($s->contains('ST18i', false)) {
            return $this->loader->load('st18i', $useragent);
        }

        if ($s->contains('ST17i', false)) {
            return $this->loader->load('st17i', $useragent);
        }

        if ($s->contains('ST15i', false)) {
            return $this->loader->load('st15i', $useragent);
        }

        if ($s->contains('so-05d', false)) {
            return $this->loader->load('so-05d', $useragent);
        }

        if ($s->contains('so-03e', false)) {
            return $this->loader->load('so-03e', $useragent);
        }

        if ($s->contains('so-03c', false)) {
            return $this->loader->load('so-03c', $useragent);
        }

        if ($s->contains('so-02e', false)) {
            return $this->loader->load('so-02e', $useragent);
        }

        if ($s->contains('so-02d', false)) {
            return $this->loader->load('so-02d', $useragent);
        }

        if ($s->contains('so-02c', false)) {
            return $this->loader->load('so-02c', $useragent);
        }

        if ($s->contains('SK17iv', false)) {
            return $this->loader->load('sk17iv', $useragent);
        }

        if ($s->contains('SK17i', false)) {
            return $this->loader->load('sk17i', $useragent);
        }

        if ($s->contains('R800iv', false)) {
            return $this->loader->load('r800iv', $useragent);
        }

        if ($s->contains('R800i', false)) {
            return $this->loader->load('r800i', $useragent);
        }

        if ($s->contains('R800a', false)) {
            return $this->loader->load('r800a', $useragent);
        }

        if ($s->contains('MT27i', false)) {
            return $this->loader->load('mt27i', $useragent);
        }

        if ($s->contains('MT15iv', false)) {
            return $this->loader->load('mt15iv', $useragent);
        }

        if ($s->contains('MT15i', false)) {
            return $this->loader->load('mt15i', $useragent);
        }

        if ($s->contains('MT15a', false)) {
            return $this->loader->load('mt15a', $useragent);
        }

        if ($s->contains('MT11i', false)) {
            return $this->loader->load('mt11i', $useragent);
        }

        if ($s->contains('MK16i', false)) {
            return $this->loader->load('mk16i', $useragent);
        }

        if ($s->contains('MK16a', false)) {
            return $this->loader->load('mk16a', $useragent);
        }

        if ($s->contains('LT28h', false)) {
            return $this->loader->load('lt28h', $useragent);
        }

        if ($s->contains('LT28at', false)) {
            return $this->loader->load('lt28at', $useragent);
        }

        if ($s->contains('LT26ii', false)) {
            return $this->loader->load('lt26ii', $useragent);
        }

        if ($s->contains('LT26i', false)) {
            return $this->loader->load('lt26i', $useragent);
        }

        if ($s->contains('LT22i', false)) {
            return $this->loader->load('lt22i', $useragent);
        }

        if ($s->contains('LT18iv', false)) {
            return $this->loader->load('lt18iv', $useragent);
        }

        if ($s->contains('LT18i', false)) {
            return $this->loader->load('lt18i', $useragent);
        }

        if ($s->contains('LT18a', false)) {
            return $this->loader->load('lt18a', $useragent);
        }

        if ($s->contains('LT18', false)) {
            return $this->loader->load('lt18', $useragent);
        }

        if ($s->contains('LT15iv', false)) {
            return $this->loader->load('lt15iv', $useragent);
        }

        if ($s->contains('LT15i', false)) {
            return $this->loader->load('lt15i', $useragent);
        }

        if ($s->contains('E15iv', false)) {
            return $this->loader->load('e15iv', $useragent);
        }

        if ($s->contains('E15i', false)) {
            return $this->loader->load('e15i', $useragent);
        }

        if ($s->contains('E15av', false)) {
            return $this->loader->load('e15av', $useragent);
        }

        if ($s->contains('E15a', false)) {
            return $this->loader->load('e15a', $useragent);
        }

        if ($s->contains('E10iv', false)) {
            return $this->loader->load('e10iv', $useragent);
        }

        if ($s->contains('E10i', false)) {
            return $this->loader->load('e10i', $useragent);
        }

        if ($s->contains('Tablet S', false)) {
            return $this->loader->load('tablet s', $useragent);
        }

        if ($s->contains('Tablet P', false)) {
            return $this->loader->load('sgpt211', $useragent);
        }

        if ($s->contains('Netbox', false)) {
            return $this->loader->load('netbox', $useragent);
        }

        if ($s->contains('XST2', false)) {
            return $this->loader->load('xst2', $useragent);
        }

        if ($s->contains('X2', false)) {
            return $this->loader->load('sonyericsson x2', $useragent);
        }

        if ($s->contains('X1i', false)) {
            return $this->loader->load('x1i', $useragent);
        }

        if ($s->contains('WT19iv', false)) {
            return $this->loader->load('wt19iv', $useragent);
        }

        if ($s->contains('WT19i', false)) {
            return $this->loader->load('wt19i', $useragent);
        }

        if ($s->contains('WT19a', false)) {
            return $this->loader->load('wt19a', $useragent);
        }

        if ($s->contains('WT13i', false)) {
            return $this->loader->load('wt13i', $useragent);
        }

        if ($s->contains('W995', false)) {
            return $this->loader->load('w995', $useragent);
        }

        if ($s->contains('W910i', false)) {
            return $this->loader->load('w910i', $useragent);
        }

        if ($s->contains('W890i', false)) {
            return $this->loader->load('w890i', $useragent);
        }

        if ($s->contains('W760i', false)) {
            return $this->loader->load('w760i', $useragent);
        }

        if ($s->contains('W715v', false)) {
            return $this->loader->load('w715v', $useragent);
        }

        if ($s->contains('W595', false)) {
            return $this->loader->load('w595', $useragent);
        }

        if ($s->contains('W580i', false)) {
            return $this->loader->load('w580i', $useragent);
        }

        if ($s->contains('W508a', false)) {
            return $this->loader->load('w508a', $useragent);
        }

        if ($s->contains('W200i', false)) {
            return $this->loader->load('w200i', $useragent);
        }

        if ($s->contains('W150i', false)) {
            return $this->loader->load('w150i', $useragent);
        }

        if ($s->contains('W20i', false)) {
            return $this->loader->load('w20i', $useragent);
        }

        if ($s->contains('U10i', false)) {
            return $this->loader->load('u10i', $useragent);
        }

        if ($s->contains('U8i', false)) {
            return $this->loader->load('u8i', $useragent);
        }

        if ($s->contains('U5i', false)) {
            return $this->loader->load('u5i', $useragent);
        }

        if ($s->contains('U1iv', false)) {
            return $this->loader->load('u1iv', $useragent);
        }

        if ($s->contains('U1i', false)) {
            return $this->loader->load('u1i', $useragent);
        }

        if ($s->contains('U1', false)) {
            return $this->loader->load('sonyericsson u1', $useragent);
        }

        if ($s->contains('SO-01E', false)) {
            return $this->loader->load('so-01e', $useragent);
        }

        if ($s->contains('SO-01D', false)) {
            return $this->loader->load('so-01d', $useragent);
        }

        if ($s->contains('SO-01C', false)) {
            return $this->loader->load('so-01c', $useragent);
        }

        if ($s->contains('SO-01B', false)) {
            return $this->loader->load('so-01b', $useragent);
        }

        if ($s->contains('SonyEricssonSO', false)) {
            return $this->loader->load('so', $useragent);
        }

        if ($s->contains('S500i', false)) {
            return $this->loader->load('s500i', $useragent);
        }

        if ($s->contains('S312', false)) {
            return $this->loader->load('s312', $useragent);
        }

        if ($s->contains('R800x', false)) {
            return $this->loader->load('r800x', $useragent);
        }

        if ($s->contains('K810i', false)) {
            return $this->loader->load('k810i', $useragent);
        }

        if ($s->contains('k800i', false)) {
            return $this->loader->load('k800i', $useragent);
        }

        if ($s->contains('k790i', false)) {
            return $this->loader->load('k790i', $useragent);
        }

        if ($s->contains('k770i', false)) {
            return $this->loader->load('k770i', $useragent);
        }

        if ($s->contains('J300', false)) {
            return $this->loader->load('j300', $useragent);
        }

        if ($s->contains('J108i', false)) {
            return $this->loader->load('j108i', $useragent);
        }

        if ($s->contains('J20i', false)) {
            return $this->loader->load('j20i', $useragent);
        }

        if ($s->contains('J10i2', false)) {
            return $this->loader->load('j10i2', $useragent);
        }

        if ($s->contains('G700', false)) {
            return $this->loader->load('g700', $useragent);
        }

        if ($s->contains('CK15i', false)) {
            return $this->loader->load('ck15i', $useragent);
        }

        if ($s->contains('C905', false)) {
            return $this->loader->load('c905', $useragent);
        }

        if ($s->contains('C902', false)) {
            return $this->loader->load('c902', $useragent);
        }

        if ($s->contains('A5000', false)) {
            return $this->loader->load('a5000', $useragent);
        }

        if ($s->contains('EBRD1201', false)) {
            return $this->loader->load('prst1', $useragent);
        }

        if ($s->contains('EBRD1101', false)) {
            return $this->loader->load('prst1', $useragent);
        }

        if ($s->contains('PlayStation Vita', false)) {
            return $this->loader->load('playstation vita', $useragent);
        }

        if ($s->containsAny(['PlayStation Portable', 'PSP'], false)) {
            return $this->loader->load('playstation portable', $useragent);
        }

        if ($s->contains('PlayStation 4', false)) {
            return $this->loader->load('playstation 4', $useragent);
        }

        if ($s->contains('PLAYSTATION 3', false)) {
            return $this->loader->load('playstation 3', $useragent);
        }

        return $this->loader->load('general sonyericsson device', $useragent);
    }
}
