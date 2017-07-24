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
        'sgp612'               => 'sony sgp612',
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
        'c6602'                => 'sonyericsson c6602',
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
        'x10iv'                => 'sonyericsson x10iv',
        'x10i'                 => 'sonyericsson x10i',
        'x10a'                 => 'sonyericsson x10a',
        'x10'                  => 'sonyericsson x10',
        'u20iv'                => 'sonyericsson u20iv',
        'u20i'                 => 'sonyericsson u20i',
        'u20a'                 => 'sonyericsson u20a',
        'st27i'                => 'sonyericsson st27i',
        'st25iv'               => 'sonyericsson st25iv',
        'st25i'                => 'sonyericsson st25i',
        'st25a'                => 'sonyericsson st25a',
        'st18iv'               => 'sonyericsson st18iv',
        'st18i'                => 'sonyericsson st18i',
        'st17i'                => 'sonyericsson st17i',
        'st15i'                => 'sonyericsson st15i',
        'so-01g'               => 'sony so-01g',
        'so-05d'               => 'sony so-05d',
        'so-03e'               => 'sony so-03e',
        'so-03c'               => 'sony so-03c',
        'so-02e'               => 'sonyericsson so-02e',
        'so-02d'               => 'sony so-02d',
        'so-02c'               => 'sonyericsson so-02c',
        'sk17iv'               => 'sonyericsson sk17iv',
        'sk17i'                => 'sonyericsson sk17i',
        'r800iv'               => 'sonyericsson r800iv',
        'r800i'                => 'sonyericsson r800i',
        'r800a'                => 'sonyericsson r800a',
        'mt27i'                => 'sonyericsson mt27i',
        'mt15iv'               => 'sonyericsson mt15iv',
        'mt15i'                => 'sonyericsson mt15i',
        'mt15a'                => 'sonyericsson mt15a',
        'mt11i'                => 'sony mt11i',
        'mk16i'                => 'sonyericsson mk16i',
        'mk16a'                => 'sonyericsson mk16a',
        'lt28h'                => 'sonyericsson lt28h',
        'lt28at'               => 'sonyericsson lt28at',
        'lt26ii'               => 'sony lt26ii',
        'lt26i'                => 'sonyericsson lt26i',
        'lt22i'                => 'sonyericsson lt22i',
        'lt18iv'               => 'sonyericsson lt18iv',
        'lt18i'                => 'sonyericsson lt18i',
        'lt18a'                => 'sonyericsson lt18a',
        'lt18'                 => 'sonyericsson lt18',
        'lt15iv'               => 'sonyericsson lt15iv',
        'lt15i'                => 'sonyericsson lt15i',
        'e15iv'                => 'sonyericsson e15iv',
        'e15i'                 => 'sonyericsson e15i',
        'e15av'                => 'sonyericsson e15av',
        'e15a'                 => 'sonyericsson e15a',
        'e10iv'                => 'sonyericsson e10iv',
        'e10i'                 => 'sonyericsson e10i',
        'tablet s'             => 'sony tablet s',
        'tablet p'             => 'sony sgpt211',
        'netbox'               => 'sony netbox',
        'xst2'                 => 'sonyericsson xst2',
        'x2'                   => 'sonyericsson x2',
        'x1i'                  => 'sonyericsson x1i',
        'wt19iv'               => 'sonyericsson wt19iv',
        'wt19i'                => 'sonyericsson wt19i',
        'wt19a'                => 'sonyericsson wt19a',
        'wt13i'                => 'sonyericsson wt13i',
        'w995'                 => 'sonyericsson w995',
        'w910i'                => 'sonyericsson w910i',
        'W890i'                => 'sonyericsson w890i',
        'w760i'                => 'sonyericsson w760i',
        'w715v'                => 'sonyericsson w715v',
        'w705a'                => 'sonyericsson w705a',
        'w595'                 => 'sonyericsson w595',
        'w580i'                => 'sonyericsson w580i',
        'w508a'                => 'sonyericsson w508a',
        'w200i'                => 'sonyericsson w200i',
        'w150i'                => 'sonyericsson w150i',
        'w20i'                 => 'sonyericsson w20i',
        'u10i'                 => 'sonyericsson u10i',
        'u8i'                  => 'sonyericsson u8i',
        'u5i'                  => 'sonyericsson u5i',
        'u1iv'                 => 'sonyericsson u1iv',
        'u1i'                  => 'sonyericsson u1i',
        'u1'                   => 'sonyericsson u1',
        'so-01e'               => 'sonyericsson so-01e',
        'so-01d'               => 'sonyericsson so-01d',
        'so-01c'               => 'sonyericsson so-01c',
        'so-01b'               => 'sonyericsson so-01b',
        's500i'                => 'sonyericsson s500i',
        's312'                 => 'sonyericsson s312',
        'r800x'                => 'sonyericsson r800x',
        'k810i'                => 'sonyericsson k810i',
        'k800i'                => 'sonyericsson k800i',
        'k790i'                => 'sonyericsson k790i',
        'k770i'                => 'sonyericsson k770i',
        'j300'                 => 'sonyericsson j300',
        'j108i'                => 'sonyericsson j108i',
        'j20i'                 => 'sonyericsson j20i',
        'j10i2'                => 'sonyericsson j10i2',
        'g700'                 => 'sonyericsson g700',
        'ck15i'                => 'sonyericsson ck15i',
        'c905'                 => 'sonyericsson c905',
        'c902'                 => 'sonyericsson c902',
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
