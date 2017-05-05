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
class LgFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'x150'          => 'x150',
        'h850'          => 'h850',
        'h525n'         => 'h525n',
        'h345'          => 'h345',
        'h340n'         => 'h340n',
        'h320'          => 'h320',
        'vs980'         => 'vs980',
        'vs880'         => 'vs880',
        'vs840'         => 'vs840 4g',
        'vs700'         => 'vs700',
        'vm701'         => 'vm701',
        'vm670'         => 'vm670',
        'v935'          => 'v935',
        'v900'          => 'v900',
        'v700'          => 'v700',
        'v500'          => 'v500',
        'v490'          => 'v490',
        't500'          => 't500',
        't385'          => 't385',
        't300'          => 't300',
        'su760'         => 'su760',
        'su660'         => 'su660',
        'p999'          => 'p999',
        'p990'          => 'p990',
        'optimus 2x'    => 'p990',
        'p970'          => 'p970',
        'optimus-black' => 'p970',
        'p940'          => 'p940',
        'p936'          => 'p936',
        'p925'          => 'p925',
        'p920'          => 'p920',
        'p895'          => 'p895',
        'p880'          => 'p880',
        'p875'          => 'p875',
        'p765'          => 'p765',
        'p760'          => 'p760',
        'p720'          => 'p720',
        'p713'          => 'p713',
        'p710'          => 'p710',
        'p705'          => 'p705',
        'p700'          => 'p700',
        'p698'          => 'p698',
        'p690'          => 'p690',
        'p509'          => 'p509',
        'optimus-t'     => 'p509',
        'p505r'         => 'p505r',
        'p505'          => 'p505',
        'kp500'         => 'kp500',
        'p500h'         => 'p500h',
        'p500'          => 'p500',
        'p350'          => 'p350',
        'nexus 5x'      => 'nexus 5x',
        'nexus5x'       => 'nexus 5x',
        'nexus 5'       => 'nexus 5',
        'nexus5'        => 'nexus 5',
        'nexus 4'       => 'nexus 4',
        'nexus4'        => 'nexus 4',
        'ms690'         => 'ms690',
        'ms323'         => 'ms323',
        'ls860'         => 'ls860',
        'ls740'         => 'ls740',
        'ls670'         => 'ls670',
        'ln510'         => 'ln510',
        'l160l'         => 'l160l',
        'ku800'         => 'ku800',
        'ks365'         => 'ks365',
        'ks20'          => 'ks20',
        'km900'         => 'km900',
        'kc910'         => 'kc910',
        'hb620t'        => 'hb620t',
        'gw300'         => 'gw300',
        'gt550'         => 'gt550',
        'gt540'         => 'gt540',
        'gs290'         => 'gs290',
        'gm360'         => 'gm360',
        'gd880'         => 'gd880',
        'gd350'         => 'gd350',
        ' g3 '          => 'g3',
        'f240s'         => 'f240s',
        'f240k'         => 'f240k',
        'f220k'         => 'f220k',
        'f200k'         => 'f200k',
        'f160k'         => 'f160k',
        'f100s'         => 'f100s',
        'f100l'         => 'f100l',
        'eve'           => 'eve',
        'e989'          => 'e989',
        'e988'          => 'e988',
        'e980h'         => 'e980h',
        'e975'          => 'e975',
        'e970'          => 'e970',
        'e906'          => 'e906',
        'e900'          => 'e900',
        'e739'          => 'e739',
        'e730'          => 'e730',
        'e720'          => 'e720',
        'e615'          => 'e615',
        'e612'          => 'e612',
        'e610'          => 'e610',
        'e510'          => 'e510',
        'e460'          => 'e460',
        'e440'          => 'e440',
        'e430'          => 'e430',
        'e425'          => 'e425',
        'e400'          => 'e400',
        'd958'          => 'd958',
        'd955'          => 'd955',
        'd856'          => 'd856',
        'd855'          => 'd855',
        'd805'          => 'd805',
        'd802tr'        => 'd802tr',
        'd802'          => 'd802',
        'd724'          => 'd724',
        'd722'          => 'd722',
        'd690'          => 'd690',
        'd686'          => 'd686',
        'd682tr'        => 'd682tr',
        'd682'          => 'd682',
        'd620'          => 'd620',
        'd618'          => 'd618',
        'd605'          => 'd605',
        'd415'          => 'd415',
        'd410'          => 'd410',
        'd373'          => 'd373',
        'd325'          => 'd325',
        'd320'          => 'd320',
        'd300'          => 'd300',
        'd295'          => 'd295',
        'd290'          => 'd290',
        'd285'          => 'd285',
        'd280'          => 'd280',
        'd213'          => 'd213',
        'd160'          => 'd160',
        'c660'          => 'c660',
        'c550'          => 'c550',
        'c330'          => 'c330',
        'c199'          => 'c199',
        'bl40'          => 'bl40',
        'lg900g'        => '900g',
        'lg220c'        => '220c',
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

        return $this->loader->load('general lg device', $useragent);
    }
}
