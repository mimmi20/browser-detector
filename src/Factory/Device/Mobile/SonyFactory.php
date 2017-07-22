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
class SonyFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'e5333'                => 'sony e5333',
        'e6833'                => 'sony e6833',
        'f8131'                => 'sony f8131',
        'f8132'                => 'sony f8132',
        'e5303'                => 'sony e5303',
        'e5306'                => 'sony e5306',
        'e5353'                => 'sony e5353',
        'f5122'                => 'sony f5122',
        'f3211'                => 'sony f3211',
        'f3212'                => 'sony f3212',
        'f3215'                => 'sony f3215',
        'f3216'                => 'sony f3216',
        'f3213'                => 'sony f3213',
        'g8231'                => 'sony g8231',
        'g8232'                => 'sony g8232',
        'e5653'                => 'sony e5653',
        'd5322'                => 'sony d5322',
        'e5633'                => 'sony e5633',
        'f8331'                => 'sony f8331',
        'f8332'                => 'sony f8332',
        'g3121'                => 'sony g3121',
        'g3112'                => 'sony g3112',
        'g3125'                => 'sony g3125',
        'g3116'                => 'sony g3116',
        'g3123'                => 'sony g3123',
        'xperia m2'            => 'sony xperia m2',
        'f5321'                => 'sony f5321',
        'f5121'                => 'sony f5121',
        'f3311'                => 'sony f3311',
        'f3111'                => 'sony f3111',
        'e6853'                => 'sony e6853',
        'e6653'                => 'sony e6653',
        'e6553'                => 'sony e6553',
        'e5823'                => 'sony e5823',
        'e5603'                => 'sony e5603',
        'e2303'                => 'sony e2303',
        'e2105'                => 'sony e2105',
        'e2003'                => 'sony e2003',
        'c5502'                => 'sony c5502',
        'c5303'                => 'sony c5303',
        'c5302'                => 'sony c5302',
        'xperia s'             => 'sony xperia s',
        'c6902'                => 'sony c6902',
        'l36h'                 => 'sony l36h',
        'd5503'                => 'sony d5503',
        'xperia z1 compact'    => 'sony d5503',
        'xperia z1'            => 'sony c6903',
        'c6903'                => 'sony c6903',
        'c6833'                => 'sony c6833',
        'c6606'                => 'sony c6606',
        'c6602'                => 'sony c6602',
        'xperia z'             => 'sony c6603',
        'c6603'                => 'sony c6603',
        'c6503'                => 'sony c6503',
        'c2305'                => 'sony c2305',
        'c2105'                => 'sony c2105',
        'c2005'                => 'sony c2005',
        'c1905'                => 'sony c1905',
        'c1904'                => 'sony c1904',
        'c1605'                => 'sony c1605',
        'c1505'                => 'sony c1505',
        'd5803'                => 'sony d5803',
        'd6633'                => 'sony d6633',
        'd6603'                => 'sony d6603',
        'l50u'                 => 'sony l50u',
        'd6503'                => 'sony d6503',
        'd5833'                => 'sony d5833',
        'd5303'                => 'sony d5303',
        'd5103'                => 'sony d5103',
        'd2403'                => 'sony d2403',
        'd2306'                => 'sony d2306',
        'd2303'                => 'sony d2303',
        'd2302'                => 'sony d2302',
        'd2212'                => 'sony d2212',
        'd2203'                => 'sony d2203',
        'd2202'                => 'sony d2202',
        'd2105'                => 'sony d2105',
        'd2005'                => 'sony d2005',
        'sgpt13'               => 'sony sgpt13',
        'sgpt12'               => 'sony sgpt12',
        'sgp771'               => 'sony sgp771',
        'sgp712'               => 'sony sgp712',
        'sgp621'               => 'sony sgp621',
        'sgp611'               => 'sony sgp611',
        'SGP521'               => 'sony sgp521',
        'sgp512'               => 'sony sgp512',
        'sgp511'               => 'sony sgp511',
        'sgp412'               => 'sony sgp412',
        'sgp321'               => 'sony sgp321',
        'sgp312'               => 'sony sgp312',
        'sgp311'               => 'sony sgp311',
        'st26i'                => 'sony st26i',
        'st26a'                => 'sony st26a',
        'st23i'                => 'sony st23i',
        'st21iv'               => 'sony st21iv',
        'st21i2'               => 'sony st21i2',
        'st21i'                => 'sony st21i',
        'lt30p'                => 'sony lt30p',
        'xperia t'             => 'sony lt30p',
        'lt29i'                => 'sony lt29i',
        'lt26w'                => 'sony lt26w',
        'lt25i'                => 'sony lt25i',
        'x10iv'                => 'sony x10iv',
        'x10i'                 => 'sony x10i',
        'x10a'                 => 'sony x10a',
        'x10'                  => 'sonyericsson x10',
        'u20iv'                => 'sony u20iv',
        'u20i'                 => 'sony u20i',
        'u20a'                 => 'sony u20a',
        'st27i'                => 'sony st27i',
        'st25iv'               => 'sony st25iv',
        'st25i'                => 'sony st25i',
        'st25a'                => 'sony st25a',
        'st18iv'               => 'sony st18iv',
        'st18i'                => 'sony st18i',
        'st17i'                => 'sony st17i',
        'st15i'                => 'sony st15i',
        'so-01g'               => 'sony so-01g',
        'so-05d'               => 'sony so-05d',
        'so-03e'               => 'sony so-03e',
        'so-03c'               => 'sony so-03c',
        'so-02e'               => 'sony so-02e',
        'so-02d'               => 'sony so-02d',
        'so-02c'               => 'sony so-02c',
        'sk17iv'               => 'sony sk17iv',
        'sk17i'                => 'sony sk17i',
        'r800iv'               => 'sony r800iv',
        'r800i'                => 'sony r800i',
        'r800a'                => 'sony r800a',
        'mt27i'                => 'sony mt27i',
        'mt15iv'               => 'sony mt15iv',
        'mt15i'                => 'sony mt15i',
        'mt15a'                => 'sony mt15a',
        'mt11i'                => 'sony mt11i',
        'mk16i'                => 'sony mk16i',
        'mk16a'                => 'sony mk16a',
        'lt28h'                => 'sony lt28h',
        'lt28at'               => 'sony lt28at',
        'lt26ii'               => 'sony lt26ii',
        'lt26i'                => 'sony lt26i',
        'lt22i'                => 'sony lt22i',
        'lt18iv'               => 'sony lt18iv',
        'lt18i'                => 'sony lt18i',
        'lt18a'                => 'sony lt18a',
        'lt18'                 => 'sony lt18',
        'lt15iv'               => 'sony lt15iv',
        'lt15i'                => 'sony lt15i',
        'e15iv'                => 'sony e15iv',
        'e15i'                 => 'sony e15i',
        'e15av'                => 'sony e15av',
        'e15a'                 => 'sony e15a',
        'e10iv'                => 'sony e10iv',
        'e10i'                 => 'sony e10i',
        'tablet s'             => 'sony tablet s',
        'tablet p'             => 'sony sgpt211',
        'netbox'               => 'sony netbox',
        'xst2'                 => 'sony xst2',
        'x2'                   => 'sonyericsson x2',
        'x1i'                  => 'sony x1i',
        'wt19iv'               => 'sony wt19iv',
        'wt19i'                => 'sony wt19i',
        'wt19a'                => 'sony wt19a',
        'wt13i'                => 'sony wt13i',
        'w995'                 => 'sony w995',
        'w910i'                => 'sony w910i',
        'W890i'                => 'sony w890i',
        'w760i'                => 'sony w760i',
        'w715v'                => 'sony w715v',
        'w705a'                => 'sonyericsson w705a',
        'w595'                 => 'sony w595',
        'w580i'                => 'sony w580i',
        'w508a'                => 'sony w508a',
        'w200i'                => 'sony w200i',
        'w150i'                => 'sony w150i',
        'w20i'                 => 'sony w20i',
        'u10i'                 => 'sony u10i',
        'u8i'                  => 'sony u8i',
        'u5i'                  => 'sony u5i',
        'u1iv'                 => 'sony u1iv',
        'u1i'                  => 'sony u1i',
        'u1'                   => 'sonyericsson u1',
        'so-01e'               => 'sony so-01e',
        'so-01d'               => 'sony so-01d',
        'so-01c'               => 'sony so-01c',
        'so-01b'               => 'sony so-01b',
        's500i'                => 'sony s500i',
        's312'                 => 'sony s312',
        'r800x'                => 'sony r800x',
        'k810i'                => 'sony k810i',
        'k800i'                => 'sony k800i',
        'k790i'                => 'sony k790i',
        'k770i'                => 'sony k770i',
        'j300'                 => 'sony j300',
        'j108i'                => 'sony j108i',
        'j20i'                 => 'sony j20i',
        'j10i2'                => 'sony j10i2',
        'g700'                 => 'sony g700',
        'ck15i'                => 'sony ck15i',
        'c905'                 => 'sony c905',
        'c902'                 => 'sony c902',
        'a5000'                => 'sony a5000',
        'ebrd1201'             => 'sony prst1',
        'ebrd1101'             => 'sony prst1',
        'playstation vita'     => 'sony playstation vita',
        'playstation portable' => 'sony playstation portable',
        'psp'                  => 'sony playstation portable',
        'playstation 4'        => 'sony playstation 4',
        'playstation 3'        => 'sony playstation 3',
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

        return $this->loader->load('general sony device', $useragent);
    }
}
