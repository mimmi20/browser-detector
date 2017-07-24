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
class NokiaFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'genm14'               => 'nokia xl2',
        'nokia_xl'             => 'nokia xl',
        'nokia_x'              => 'nokia x',
        'lumia 650'            => 'microsoft lumia 650',
        'id336'                => 'microsoft lumia 650',
        'lumia 510'            => 'nokia lumia 510',
        'rm-1154'              => 'microsoft rm-1154',
        'rm-1141'              => 'microsoft rm-1141',
        'rm-1127'              => 'microsoft rm-1127',
        'rm-1114'              => 'microsoft rm-1114',
        'rm-1113'              => 'microsoft rm-1113',
        'lumia 640 lte'        => 'microsoft rm-1113',
        'rm-1109'              => 'microsoft rm-1109',
        'rm-1099'              => 'microsoft rm-1099',
        'rm-1092'              => 'microsoft rm-1092',
        'rm-1090'              => 'microsoft rm-1090',
        'rm-1089'              => 'microsoft rm-1089',
        'rm-1072'              => 'microsoft rm-1072',
        'rm-1073'              => 'microsoft rm-1073',
        'rm-1074'              => 'microsoft rm-1074',
        'rm-1076'              => 'microsoft rm-1076',
        'rm-1077'              => 'microsoft rm-1077',
        'rm-1075'              => 'microsoft rm-1075',
        'lumia 640 dual sim'   => 'microsoft rm-1075',
        'rm-1062'              => 'microsoft rm-1062',
        'rm-1063'              => 'microsoft rm-1063',
        'rm-1064'              => 'microsoft rm-1064',
        'rm-1065'              => 'microsoft rm-1065',
        'rm-1066'              => 'microsoft rm-1066',
        'rm-1067'              => 'microsoft rm-1067',
        'rm-1045'              => 'nokia rm-1045',
        'rm-1038'              => 'nokia rm-1038',
        'rm-1031'              => 'microsoft rm-1031',
        'lumia 532'            => 'microsoft rm-1031',
        'rm-1010'              => 'microsoft rm-1010',
        'rm-994'               => 'microsoft rm-994',
        'rm-978'               => 'nokia rm-978',
        'rm-976'               => 'nokia rm-976',
        'rm-974'               => 'nokia rm-974',
        'rm-914'               => 'nokia lumia 520 rm-914',
        'rm-846'               => 'nokia rm-846',
        'rm-997'               => 'nokia rm-997',
        'lumia 521'            => 'nokia lumia 521',
        'lumia 520'            => 'nokia lumia 520',
        'lumia 530'            => 'nokia lumia 530',
        'lumia 535'            => 'microsoft lumia 535',
        'lumia 540'            => 'microsoft lumia 540',
        'lumia 550'            => 'nokia lumia 550',
        'lumia 610'            => 'nokia lumia 610',
        'lumia 620'            => 'nokia lumia 620',
        'lumia 625'            => 'nokia lumia 625',
        'lumia 630'            => 'nokia lumia 630',
        'lumia 635'            => 'nokia lumia 635',
        'lumia 640 xl'         => 'nokia lumia 640 xl',
        'lumia 710'            => 'nokia lumia 710',
        'lumia 720'            => 'nokia lumia 720',
        'lumia 730'            => 'nokia lumia 730',
        'lumia 735'            => 'nokia lumia 735',
        'lumia 800'            => 'nokia lumia 800',
        'lumia 820'            => 'nokia lumia 820',
        'lumia 830'            => 'nokia lumia 830',
        'lumia 900'            => 'nokia lumia 900',
        'lumia 920'            => 'nokia lumia 920',
        'lumia 925'            => 'nokia lumia 925',
        'nokia 925'            => 'nokia lumia 925',
        'lumia 928'            => 'nokia lumia 928',
        'lumia 929'            => 'nokia lumia 929',
        'lumia 930'            => 'nokia lumia 930',
        'lumia 950 xl'         => 'nokia lumia 950 xl',
        'lumia 950'            => 'nokia lumia 950',
        'lumia 1020'           => 'nokia lumia 1020',
        'nokia; 909'           => 'nokia lumia 1020',
        'arm; 909'             => 'nokia lumia 1020',
        'lumia 1320'           => 'nokia lumia 1320',
        'lumia 1520'           => 'nokia lumia 1520',
        'lumia 435'            => 'microsoft lumia 435',
        ' n1 '                 => 'nokia n1',
        'nokian80'             => 'nokia n80',
        'nokian81'             => 'nokia n81',
        'nokian82'             => 'nokia n82',
        'nokian85'             => 'nokia n85',
        'nokian86'             => 'nokia n86',
        'nokian8-00'           => 'nokia n8-00',
        'nokian90'             => 'nokia n90',
        'nokian91'             => 'nokia n91',
        'nokian95'             => 'nokia n95',
        'nokian96'             => 'nokia n96',
        'nokian97'             => 'nokia n97',
        'n900'                 => 'nokia n900',
        'nokian9'              => 'nokia n9',
        'nokian70'             => 'nokia n70',
        'nokia n70'            => 'nokia n70',
        'nokian73'             => 'nokia n73',
        'nokian76'             => 'nokia n76',
        'nokian78'             => 'nokia n78',
        'nokia n78'            => 'nokia n78',
        'nokian79'             => 'nokia n79',
        'nokia n79'            => 'nokia n79',
        'nokiax2ds'            => 'nokia x2ds',
        'nokiax2-00'           => 'nokia x2-00',
        'nokiax2-01'           => 'nokia x2-01',
        'nokiax2-02'           => 'nokia x2-02',
        'nokiax2-05'           => 'nokia x2-05',
        'nokiax3-02'           => 'nokia x3-02',
        'nokiax3-00'           => 'nokia x3-00',
        'nokiax6-00'           => 'nokia x6-00',
        'nokiax7-00'           => 'nokia x7-00',
        'nokiax7'              => 'nokia x7',
        'nokiae7-00'           => 'nokia e7-00',
        'nokiae71-1'           => 'nokia e71-1',
        'nokiae71'             => 'nokia e71',
        'nokiae72'             => 'nokia e72',
        'nokiae75'             => 'nokia e75',
        'nokiae7'              => 'nokia e7',
        'nokiae6-00'           => 'nokia e6-00',
        'nokiae61i'            => 'nokia e61i',
        'nokiae61'             => 'nokia e61',
        'nokiae62'             => 'nokia e62',
        'nokiae63'             => 'nokia e63',
        'nokiae66'             => 'nokia e66',
        'nokiae6'              => 'nokia e6',
        'nokiae5-00'           => 'nokia e5-00',
        'nokiae50'             => 'nokia e50',
        'nokiae51'             => 'nokia e51',
        'nokiae52'             => 'nokia e52',
        'nokiae55'             => 'nokia e55',
        'nokiae5'              => 'nokia e5',
        'nokiae90'             => 'nokia e90',
        'nokiae-90'            => 'nokia e90',
        'nokiac7-00'           => 'nokia c7-00',
        'nokiac7'              => 'nokia c7',
        'nokiac6-00'           => 'nokia c6-00',
        'nokiac6-01'           => 'nokia c6-01',
        'nokiac6'              => 'nokia c6',
        'nokiac5-00'           => 'nokia c5-00',
        'nokiac5-03'           => 'nokia c5-03',
        'nokiac5-05'           => 'nokia c5-05',
        'nokiac5'              => 'nokia c5',
        'nokiac3-00'           => 'nokia c3-00',
        'nokiac3-01'           => 'nokia c3-01',
        'nokiac3'              => 'nokia c3',
        'nokiac2-01'           => 'nokia c2-01',
        'nokiac2-02'           => 'nokia c2-02',
        'nokiac2-03'           => 'nokia c2-03',
        'nokiac2-05'           => 'nokia c2-05',
        'nokiac2-06'           => 'nokia c2-06',
        'nokiac2'              => 'nokia c2',
        'nokiac1-01'           => 'nokia c1-01',
        'nokiac1'              => 'nokia c1',
        'nokia9500'            => 'nokia 9500',
        'nokia7510'            => 'nokia 7510',
        'nokia7230'            => 'nokia 7230',
        'nokia6790s'           => 'nokia 6790s',
        'nokia6730c'           => 'nokia 6730 classic',
        'nokia6720c'           => 'nokia 6720 classic',
        'nokia6710s'           => 'nokia 6710 slide',
        'nokia6700s'           => 'nokia 6700s',
        'nokia6700c'           => 'nokia 6700 classic',
        'nokia6630'            => 'nokia 6630',
        'nokia6610i'           => 'nokia 6610i',
        'nokia6555'            => 'nokia 6555',
        'nokia6500s'           => 'nokia 6500 slide',
        'nokia6500c'           => 'nokia 6500 classic',
        'nokia6303iclassic'    => 'nokia 6303i classic',
        'nokia6303classic'     => 'nokia 6303 classic',
        'nokia6300'            => 'nokia 6300',
        'nokia6220c'           => 'nokia 6220 classic',
        'nokia6210'            => 'nokia 6210',
        'nokia6131'            => 'nokia 6131',
        'nokia6124c'           => 'nokia 6124c',
        'nokia6120c'           => 'nokia 6120c',
        'nokia6120'            => 'nokia 6120',
        'nokia5730s'           => 'nokia 5730s',
        '6650d'                => 'nokia 6650d',
        'nokia5800d'           => 'nokia 5800 xpressmusic',
        'nokia5800'            => 'nokia 5800',
        'nokia5530c'           => 'nokia 5530 classic',
        'nokia5530'            => 'nokia 5530 classic',
        'nokia5320di'          => 'nokia 5320di',
        'nokia5320d'           => 'nokia 5320d',
        'nokia5310'            => 'nokia 5310 xpressmusic',
        'nokia5250'            => 'nokia 5250',
        'nokia5235'            => 'nokia 5235',
        'nokia5233'            => 'nokia 5233',
        'nokia5230'            => 'nokia 5230',
        'nokia5228'            => 'nokia 5228',
        'nokia5220xpressmusic' => 'nokia 5220 xpressmusic',
        '5130c-2'              => 'nokia 5130c-2',
        'nokia3710'            => 'nokia 3710',
        'nokia301.1'           => 'nokia 301.1',
        'nokia301'             => 'nokia 301',
        'nokia2760'            => 'nokia 2760',
        'nokia2730c'           => 'nokia 2730 classic',
        'nokia2720a'           => 'nokia 2720a',
        'nokia2700c'           => 'nokia 2700 classic',
        'nokia2630'            => 'nokia 2630',
        'nokia2330c'           => 'nokia 2330 classic',
        'nokia2323c'           => 'nokia 2323c',
        'nokia2320c'           => 'nokia 2320c',
        'nokia808pureview'     => 'nokia 808 pureview',
        'nokia701'             => 'nokia 701',
        'nokia700'             => 'nokia 700',
        'nokia603'             => 'nokia 603',
        'nokia515'             => 'nokia 515',
        'nokia501'             => 'nokia 501',
        'nokia500'             => 'nokia 500',
        'nokiaasha500'         => 'nokia 500',
        'nokia311'             => 'nokia 311',
        'nokia309'             => 'nokia 309',
        'nokia308'             => 'nokia 308',
        'nokia306'             => 'nokia 306',
        'nokia305'             => 'nokia 305',
        'nokia303'             => 'nokia 303',
        'nokia302'             => 'nokia 302',
        'nokia300'             => 'nokia 300',
        'nokia220'             => 'nokia 220',
        'nokia210'             => 'nokia 210',
        'nokia206'             => 'nokia 206',
        'nokia205'             => 'nokia 205',
        'nokia203'             => 'nokia 203',
        'nokia202'             => 'nokia 202',
        'nokia201'             => 'nokia 201',
        'nokia200'             => 'nokia 200',
        'nokia113'             => 'nokia 113',
        'nokia112'             => 'nokia 112',
        'nokia110'             => 'nokia 110',
        'nokia109'             => 'nokia 109',
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

        return $this->loader->load('general nokia device', $useragent);
    }
}
