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
class LgFactory implements Factory\FactoryInterface
{
    /**
     * @var \Psr\Cache\CacheItemPoolInterface|null
     */
    private $cache = null;

    /**
     * @var \BrowserDetector\Loader\LoaderInterface|null
     */
    private $loader = null;

    /**
     * @param \Psr\Cache\CacheItemPoolInterface       $cache
     * @param \BrowserDetector\Loader\LoaderInterface $loader
     */
    public function __construct(CacheItemPoolInterface $cache, LoaderInterface $loader)
    {
        $this->cache  = $cache;
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
        if ($s->contains('x150', false)) {
            return $this->loader->load('x150', $useragent);
        }

        if ($s->contains('h850', false)) {
            return $this->loader->load('h850', $useragent);
        }

        if ($s->contains('h525n', false)) {
            return $this->loader->load('h525n', $useragent);
        }

        if ($s->contains('h345', false)) {
            return $this->loader->load('h345', $useragent);
        }

        if ($s->contains('h340n', false)) {
            return $this->loader->load('h340n', $useragent);
        }

        if ($s->contains('h320', false)) {
            return $this->loader->load('h320', $useragent);
        }

        if ($s->contains('vs980', false)) {
            return $this->loader->load('vs980', $useragent);
        }

        if ($s->contains('vs880', false)) {
            return $this->loader->load('vs880', $useragent);
        }

        if ($s->contains('vs840', false)) {
            return $this->loader->load('vs840 4g', $useragent);
        }

        if ($s->contains('vs700', false)) {
            return $this->loader->load('vs700', $useragent);
        }

        if ($s->contains('vm701', false)) {
            return $this->loader->load('vm701', $useragent);
        }

        if ($s->contains('vm670', false)) {
            return $this->loader->load('vm670', $useragent);
        }

        if ($s->contains('v935', false)) {
            return $this->loader->load('v935', $useragent);
        }

        if ($s->contains('v900', false)) {
            return $this->loader->load('v900', $useragent);
        }

        if ($s->contains('v700', false)) {
            return $this->loader->load('v700', $useragent);
        }

        if ($s->contains('v500', false)) {
            return $this->loader->load('v500', $useragent);
        }

        if ($s->contains('v490', false)) {
            return $this->loader->load('v490', $useragent);
        }

        if ($s->contains('t500', false)) {
            return $this->loader->load('t500', $useragent);
        }

        if ($s->contains('t385', false)) {
            return $this->loader->load('t385', $useragent);
        }

        if ($s->contains('t300', false)) {
            return $this->loader->load('t300', $useragent);
        }

        if ($s->contains('su760', false)) {
            return $this->loader->load('su760', $useragent);
        }

        if ($s->contains('su660', false)) {
            return $this->loader->load('su660', $useragent);
        }

        if ($s->contains('p999', false)) {
            return $this->loader->load('p999', $useragent);
        }

        if ($s->containsAny(['p990', 'optimus 2x'], false)) {
            return $this->loader->load('p990', $useragent);
        }

        if ($s->containsAny(['p970', 'optimus-black'], false)) {
            return $this->loader->load('p970', $useragent);
        }

        if ($s->contains('p940', false)) {
            return $this->loader->load('p940', $useragent);
        }

        if ($s->contains('p936', false)) {
            return $this->loader->load('p936', $useragent);
        }

        if ($s->contains('p925', false)) {
            return $this->loader->load('p925', $useragent);
        }

        if ($s->contains('p920', false)) {
            return $this->loader->load('p920', $useragent);
        }

        if ($s->contains('p895', false)) {
            return $this->loader->load('p895', $useragent);
        }

        if ($s->contains('p880', false)) {
            return $this->loader->load('p880', $useragent);
        }

        if ($s->contains('p875', false)) {
            return $this->loader->load('p875', $useragent);
        }

        if ($s->contains('p765', false)) {
            return $this->loader->load('p765', $useragent);
        }

        if ($s->contains('p760', false)) {
            return $this->loader->load('p760', $useragent);
        }

        if ($s->contains('p720', false)) {
            return $this->loader->load('p720', $useragent);
        }

        if ($s->contains('p713', false)) {
            return $this->loader->load('p713', $useragent);
        }

        if ($s->contains('p710', false)) {
            return $this->loader->load('p710', $useragent);
        }

        if ($s->contains('p705', false)) {
            return $this->loader->load('p705', $useragent);
        }

        if ($s->contains('p700', false)) {
            return $this->loader->load('p700', $useragent);
        }

        if ($s->contains('p698', false)) {
            return $this->loader->load('p698', $useragent);
        }

        if ($s->contains('p690', false)) {
            return $this->loader->load('p690', $useragent);
        }

        if ($s->containsAny(['p509', 'optimus-t'], false)) {
            return $this->loader->load('p509', $useragent);
        }

        if ($s->contains('p505r', false)) {
            return $this->loader->load('p505r', $useragent);
        }

        if ($s->contains('p505', false)) {
            return $this->loader->load('p505', $useragent);
        }

        if ($s->contains('p500h', false)) {
            return $this->loader->load('p500h', $useragent);
        }

        if ($s->contains('p500', false)) {
            return $this->loader->load('p500', $useragent);
        }

        if ($s->contains('p350', false)) {
            return $this->loader->load('p350', $useragent);
        }

        if ($s->containsAny(['nexus 5x', 'nexus5x'], false)) {
            return $this->loader->load('nexus 5x', $useragent);
        }

        if ($s->containsAny(['nexus 5', 'nexus5'], false)) {
            return $this->loader->load('nexus 5', $useragent);
        }

        if ($s->containsAny(['nexus 4', 'nexus4'], false)) {
            return $this->loader->load('nexus 4', $useragent);
        }

        if ($s->contains('ms690', false)) {
            return $this->loader->load('ms690', $useragent);
        }

        if ($s->contains('ls860', false)) {
            return $this->loader->load('ls860', $useragent);
        }

        if ($s->contains('ls740', false)) {
            return $this->loader->load('ls740', $useragent);
        }

        if ($s->contains('ls670', false)) {
            return $this->loader->load('ls670', $useragent);
        }

        if ($s->contains('ln510', false)) {
            return $this->loader->load('ln510', $useragent);
        }

        if ($s->contains('l160l', false)) {
            return $this->loader->load('l160l', $useragent);
        }

        if ($s->contains('ku800', false)) {
            return $this->loader->load('ku800', $useragent);
        }

        if ($s->contains('ks365', false)) {
            return $this->loader->load('ks365', $useragent);
        }

        if ($s->contains('ks20', false)) {
            return $this->loader->load('ks20', $useragent);
        }

        if ($s->contains('kp500', false)) {
            return $this->loader->load('kp500', $useragent);
        }

        if ($s->contains('km900', false)) {
            return $this->loader->load('km900', $useragent);
        }

        if ($s->contains('kc910', false)) {
            return $this->loader->load('kc910', $useragent);
        }

        if ($s->contains('hb620t', false)) {
            return $this->loader->load('hb620t', $useragent);
        }

        if ($s->contains('gw300', false)) {
            return $this->loader->load('gw300', $useragent);
        }

        if ($s->contains('gt550', false)) {
            return $this->loader->load('gt550', $useragent);
        }

        if ($s->contains('gt540', false)) {
            return $this->loader->load('gt540', $useragent);
        }

        if ($s->contains('gs290', false)) {
            return $this->loader->load('gs290', $useragent);
        }

        if ($s->contains('gm360', false)) {
            return $this->loader->load('gm360', $useragent);
        }

        if ($s->contains('gd880', false)) {
            return $this->loader->load('gd880', $useragent);
        }

        if ($s->contains('gd350', false)) {
            return $this->loader->load('gd350', $useragent);
        }

        if ($s->contains(' g3 ', false)) {
            return $this->loader->load('g3', $useragent);
        }

        if ($s->contains('f240s', false)) {
            return $this->loader->load('f240s', $useragent);
        }

        if ($s->contains('f240k', false)) {
            return $this->loader->load('f240k', $useragent);
        }

        if ($s->contains('f220k', false)) {
            return $this->loader->load('f220k', $useragent);
        }

        if ($s->contains('f200k', false)) {
            return $this->loader->load('f200k', $useragent);
        }

        if ($s->contains('f160k', false)) {
            return $this->loader->load('f160k', $useragent);
        }

        if ($s->contains('f100s', false)) {
            return $this->loader->load('f100s', $useragent);
        }

        if ($s->contains('f100l', false)) {
            return $this->loader->load('f100l', $useragent);
        }

        if ($s->contains('eve', false)) {
            return $this->loader->load('eve', $useragent);
        }

        if ($s->contains('e989', false)) {
            return $this->loader->load('e989', $useragent);
        }

        if ($s->contains('e988', false)) {
            return $this->loader->load('e988', $useragent);
        }

        if ($s->contains('e980h', false)) {
            return $this->loader->load('e980h', $useragent);
        }

        if ($s->contains('e975', false)) {
            return $this->loader->load('e975', $useragent);
        }

        if ($s->contains('e970', false)) {
            return $this->loader->load('e970', $useragent);
        }

        if ($s->contains('e906', false)) {
            return $this->loader->load('e906', $useragent);
        }

        if ($s->contains('e900', false)) {
            return $this->loader->load('e900', $useragent);
        }

        if ($s->contains('e739', false)) {
            return $this->loader->load('e739', $useragent);
        }

        if ($s->contains('e730', false)) {
            return $this->loader->load('e730', $useragent);
        }

        if ($s->contains('e720', false)) {
            return $this->loader->load('e720', $useragent);
        }

        if ($s->contains('e615', false)) {
            return $this->loader->load('e615', $useragent);
        }

        if ($s->contains('e612', false)) {
            return $this->loader->load('e612', $useragent);
        }

        if ($s->contains('e610', false)) {
            return $this->loader->load('e610', $useragent);
        }

        if ($s->contains('e510', false)) {
            return $this->loader->load('e510', $useragent);
        }

        if ($s->contains('e460', false)) {
            return $this->loader->load('e460', $useragent);
        }

        if ($s->contains('e440', false)) {
            return $this->loader->load('e440', $useragent);
        }

        if ($s->contains('e430', false)) {
            return $this->loader->load('e430', $useragent);
        }

        if ($s->contains('e425', false)) {
            return $this->loader->load('e425', $useragent);
        }

        if ($s->contains('e400', false)) {
            return $this->loader->load('e400', $useragent);
        }

        if ($s->contains('d958', false)) {
            return $this->loader->load('d958', $useragent);
        }

        if ($s->contains('d955', false)) {
            return $this->loader->load('d955', $useragent);
        }

        if ($s->contains('d856', false)) {
            return $this->loader->load('d856', $useragent);
        }

        if ($s->contains('d855', false)) {
            return $this->loader->load('d855', $useragent);
        }

        if ($s->contains('d805', false)) {
            return $this->loader->load('d805', $useragent);
        }

        if ($s->contains('d802tr', false)) {
            return $this->loader->load('d802tr', $useragent);
        }

        if ($s->contains('d802', false)) {
            return $this->loader->load('d802', $useragent);
        }

        if ($s->contains('d724', false)) {
            return $this->loader->load('d724', $useragent);
        }

        if ($s->contains('d722', false)) {
            return $this->loader->load('d722', $useragent);
        }

        if ($s->contains('d690', false)) {
            return $this->loader->load('d690', $useragent);
        }

        if ($s->contains('d686', false)) {
            return $this->loader->load('d686', $useragent);
        }

        if ($s->contains('d682tr', false)) {
            return $this->loader->load('d682tr', $useragent);
        }

        if ($s->contains('d682', false)) {
            return $this->loader->load('d682', $useragent);
        }

        if ($s->contains('d620', false)) {
            return $this->loader->load('d620', $useragent);
        }

        if ($s->contains('d618', false)) {
            return $this->loader->load('d618', $useragent);
        }

        if ($s->contains('d605', false)) {
            return $this->loader->load('d605', $useragent);
        }

        if ($s->contains('d415', false)) {
            return $this->loader->load('d415', $useragent);
        }

        if ($s->contains('d410', false)) {
            return $this->loader->load('d410', $useragent);
        }

        if ($s->contains('d373', false)) {
            return $this->loader->load('d373', $useragent);
        }

        if ($s->contains('d325', false)) {
            return $this->loader->load('d325', $useragent);
        }

        if ($s->contains('d320', false)) {
            return $this->loader->load('d320', $useragent);
        }

        if ($s->contains('d300', false)) {
            return $this->loader->load('d300', $useragent);
        }

        if ($s->contains('d295', false)) {
            return $this->loader->load('d295', $useragent);
        }

        if ($s->contains('d290', false)) {
            return $this->loader->load('d290', $useragent);
        }

        if ($s->contains('d285', false)) {
            return $this->loader->load('d285', $useragent);
        }

        if ($s->contains('d280', false)) {
            return $this->loader->load('d280', $useragent);
        }

        if ($s->contains('d213', false)) {
            return $this->loader->load('d213', $useragent);
        }

        if ($s->contains('d160', false)) {
            return $this->loader->load('d160', $useragent);
        }

        if ($s->contains('c660', false)) {
            return $this->loader->load('c660', $useragent);
        }

        if ($s->contains('c550', false)) {
            return $this->loader->load('c550', $useragent);
        }

        if ($s->contains('c330', false)) {
            return $this->loader->load('c330', $useragent);
        }

        if ($s->contains('c199', false)) {
            return $this->loader->load('c199', $useragent);
        }

        if ($s->contains('bl40', false)) {
            return $this->loader->load('bl40', $useragent);
        }

        if ($s->contains('lg900g', false)) {
            return $this->loader->load('900g', $useragent);
        }

        if ($s->contains('lg220c', false)) {
            return $this->loader->load('220c', $useragent);
        }

        return $this->loader->load('general lg device', $useragent);
    }
}
