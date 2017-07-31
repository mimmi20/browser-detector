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
        'x210ds'        => 'lg x210ds',
        'x210'          => 'lg x210',
        'ms330'         => 'lg ms330',
        'ls675'         => 'lg ls675',
        'f180l'         => 'lg f180l',
        'f180k'         => 'lg f180k',
        'f180s'         => 'lg f180s',
        'f180'          => 'lg f180',
        'k220ds'        => 'lg k220ds',
        'k220'          => 'lg k220',
        'ls755'         => 'lg ls755',
        'us610'         => 'lg us610',
        'k450'          => 'lg k450',
        'h955'          => 'lg h955',
        'ls996'         => 'lg ls996',
        'h950'          => 'lg h950',
        'us995'         => 'lg us995',
        'k100'          => 'lg k100',
        'k500n'         => 'lg k500n',
        'k500ds'        => 'lg k500ds',
        'f200k'         => 'lg f200k',
        'f200s'         => 'lg f200s',
        'v400'          => 'lg v400',
        'nexus 5 caf'   => 'lg nexus 5 caf',
        'nexus5 v6.1'   => 'lg nexus 5 v6.1',
        'h815'          => 'lg h815',
        'd335e'         => 'lg d335e',
        'd335'          => 'lg d335',
        'd331'          => 'lg d331',
        'f320k'         => 'lg f320k',
        'f320l'         => 'lg f320l',
        'f320s'         => 'lg f320s',
        'k420'          => 'lg k420',
        'h960'          => 'lg h960',
        'h840'          => 'lg h840',
        'h845'          => 'lg h845',
        'v480'          => 'lg v480',
        'h818'          => 'lg h818',
        'k120'          => 'lg k120',
        'k130'          => 'lg k130',
        'vs995'         => 'lg vs995',
        'h990n'         => 'lg h990n',
        'h990ds'        => 'lg h990ds',
        'h910'          => 'lg h910',
        'h918'          => 'lg h918',
        'ls997'         => 'lg ls997',
        'us996'         => 'lg us996',
        'h990t'         => 'lg h990t',
        'm210'          => 'lg m210',
        'ms210'         => 'lg ms210',
        'k600'          => 'lg k600',
        'h220'          => 'lg h220',
        'lgls676'       => 'lg ls676',
        'k350'          => 'lg k350',
        'k580'          => 'lg k580',
        'f400s'         => 'lg f400s',
        'vs810pp'       => 'lg vs810 pp',
        'd838'          => 'lg d838',
        'd405'          => 'lg d405',
        'lgl34c'        => 'lg l34c',
        'e467f'         => 'lg e467f',
        'x150'          => 'lg x150',
        'h440n'         => 'lg h440n',
        'h500'          => 'lg h500',
        'h850'          => 'lg h850',
        'h525n'         => 'lg h525n',
        'h345'          => 'lg h345',
        'h340n'         => 'lg h340n',
        'h320'          => 'lg h320',
        'vs980'         => 'lg vs980',
        'vs880'         => 'lg vs880',
        'vs840'         => 'lg vs840 4g',
        'vs700'         => 'lg vs700',
        'vm701'         => 'lg vm701',
        'vm670'         => 'lg vm670',
        'v935'          => 'lg v935',
        'v900'          => 'lg v900',
        'v700'          => 'lg v700',
        'v500'          => 'lg v500',
        'v490'          => 'lg v490',
        't500'          => 'lg t500',
        't385'          => 'lg t385',
        't300'          => 'lg t300',
        'su760'         => 'lg su760',
        'su660'         => 'lg su660',
        'p999'          => 'lg p999',
        'p990'          => 'lg p990',
        'optimus 2x'    => 'lg p990',
        'p970'          => 'lg p970',
        'optimus-black' => 'lg p970',
        'p940'          => 'lg p940',
        'p936'          => 'lg p936',
        'p925'          => 'lg p925',
        'p920'          => 'lg p920',
        'p895'          => 'lg p895',
        'p880'          => 'lg p880',
        'p875'          => 'lg p875',
        'p765'          => 'lg p765',
        'p760'          => 'lg p760',
        'p720'          => 'lg p720',
        'p713'          => 'lg p713',
        'p712'          => 'lg p712',
        'p710'          => 'lg p710',
        'p705'          => 'lg p705',
        'p700'          => 'lg p700',
        'p698'          => 'lg p698',
        'p690'          => 'lg p690',
        'p509'          => 'lg p509',
        'optimus-t'     => 'lg p509',
        'p505r'         => 'lg p505r',
        'p505'          => 'lg p505',
        'kp500'         => 'lg kp500',
        'p500h'         => 'lg p500h',
        'p500'          => 'lg p500',
        'p350'          => 'lg p350',
        'nexus 5x'      => 'lg nexus 5x',
        'nexus5x'       => 'lg nexus 5x',
        'nexus 5'       => 'lg nexus 5',
        'nexus5'        => 'lg nexus 5',
        'nexus 4'       => 'lg nexus 4',
        'nexus4'        => 'lg nexus 4',
        'ms690'         => 'lg ms690',
        'ms500'         => 'lg ms500',
        'ms323'         => 'lg ms323',
        'ls860'         => 'lg ls860',
        'ls740'         => 'lg ls740',
        'ls670'         => 'lg ls670',
        'ln510'         => 'lg ln510',
        'l160l'         => 'lg l160l',
        'ku800'         => 'lg ku800',
        'ks365'         => 'lg ks365',
        'ks20'          => 'lg ks20',
        'km900'         => 'lg km900',
        'kc910'         => 'lg kc910',
        'hb620t'        => 'lg hb620t',
        'gw300'         => 'lg gw300',
        'gt550'         => 'lg gt550',
        'gt540'         => 'lg gt540',
        'gs290'         => 'lg gs290',
        'gm360'         => 'lg gm360',
        'gd880'         => 'lg gd880',
        'gd350'         => 'lg gd350',
        ' g3 '          => 'lg g3',
        'f240s'         => 'lg f240s',
        'f240k'         => 'lg f240k',
        'f220k'         => 'lg f220k',
        'f160k'         => 'lg f160k',
        'f100s'         => 'lg f100s',
        'f100l'         => 'lg f100l',
        'eve'           => 'lg eve',
        'e989'          => 'lg e989',
        'e988'          => 'lg e988',
        'e980h'         => 'lg e980h',
        'e975'          => 'lg e975',
        'e970'          => 'lg e970',
        'e906'          => 'lg e906',
        'e900'          => 'lg e900',
        'e739'          => 'lg e739',
        'e730'          => 'lg e730',
        'e720'          => 'lg e720',
        'e615'          => 'lg e615',
        'e612'          => 'lg e612',
        'e610'          => 'lg e610',
        'e510'          => 'lg e510',
        'e460'          => 'lg e460',
        'e440'          => 'lg e440',
        'e430'          => 'lg e430',
        'e425'          => 'lg e425',
        'e400'          => 'lg e400',
        'd958'          => 'lg d958',
        'd955'          => 'lg d955',
        'd856'          => 'lg d856',
        'd855'          => 'lg d855',
        'd805'          => 'lg d805',
        'd802tr'        => 'lg d802tr',
        'd802'          => 'lg d802',
        'd724'          => 'lg d724',
        'd722'          => 'lg d722',
        'd690'          => 'lg d690',
        'd686'          => 'lg d686',
        'd682tr'        => 'lg d682tr',
        'd682'          => 'lg d682',
        'd620'          => 'lg d620',
        'd618'          => 'lg d618',
        'd605'          => 'lg d605',
        'd415'          => 'lg d415',
        'd410'          => 'lg d410',
        'd373'          => 'lg d373',
        'd325'          => 'lg d325',
        'd320'          => 'lg d320',
        'd300'          => 'lg d300',
        'd295'          => 'lg d295',
        'd290'          => 'lg d290',
        'd285'          => 'lg d285',
        'd280'          => 'lg d280',
        'd213'          => 'lg d213',
        'd160'          => 'lg d160',
        'c660'          => 'lg c660',
        'c550'          => 'lg c550',
        'c330'          => 'lg c330',
        'c199'          => 'lg c199',
        'bl40'          => 'lg bl40',
        'lg900g'        => 'lg 900g',
        'lg220c'        => 'lg 220c',
        'lg272'         => 'lg 272',
        'vn271'         => 'lg vn271',
        'ln240'         => 'lg ln240',
        'kt770'         => 'lg kt770',
        'kt615'         => 'lg kt615',
        'ks10'          => 'lg ks10',
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
