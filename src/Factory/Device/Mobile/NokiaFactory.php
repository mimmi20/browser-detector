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
        'genm14'               => 'xl2',
        'nokia_xl'             => 'xl',
        'nokia_x'              => 'nokia x',
        'lumia 650'            => 'lumia 650',
        'id336'                => 'lumia 650',
        'lumia 510'            => 'lumia 510',
        'rm-1154'              => 'microsoft rm-1154',
        'rm-1141'              => 'microsoft rm-1141',
        'rm-1127'              => 'microsoft rm-1127',
        'rm-1114'              => 'microsoft rm-1114',
        'rm-1113'              => 'rm-1113',
        'lumia 640 lte'        => 'rm-1113',
        'rm-1109'              => 'microsoft rm-1109',
        'rm-1099'              => 'microsoft rm-1099',
        'rm-1092'              => 'microsoft rm-1092',
        'rm-1090'              => 'rm-1090',
        'rm-1089'              => 'rm-1089',
        'rm-1072'              => 'rm-1072',
        'rm-1073'              => 'rm-1073',
        'rm-1074'              => 'rm-1074',
        'rm-1076'              => 'rm-1076',
        'rm-1077'              => 'rm-1077',
        'rm-1075'              => 'rm-1075',
        'lumia 640 dual sim'   => 'rm-1075',
        'rm-1062'              => 'rm-1062',
        'rm-1063'              => 'rm-1063',
        'rm-1064'              => 'rm-1064',
        'rm-1065'              => 'rm-1065',
        'rm-1066'              => 'rm-1066',
        'rm-1067'              => 'rm-1067',
        'rm-1045'              => 'rm-1045',
        'rm-1038'              => 'rm-1038',
        'rm-1031'              => 'rm-1031',
        'lumia 532'            => 'rm-1031',
        'rm-1010'              => 'rm-1010',
        'rm-994'               => 'rm-994',
        'rm-978'               => 'rm-978',
        'rm-976'               => 'rm-976',
        'rm-974'               => 'rm-974',
        'rm-914'               => 'lumia 520 rm-914',
        'rm-846'               => 'rm-846',
        'rm-997'               => 'rm-997',
        'lumia 521'            => 'lumia 521',
        'lumia 520'            => 'lumia 520',
        'lumia 530'            => 'lumia 530',
        'lumia 535'            => 'lumia 535',
        'lumia 540'            => 'lumia 540',
        'lumia 550'            => 'lumia 550',
        'lumia 610'            => 'lumia 610',
        'lumia 620'            => 'lumia 620',
        'lumia 625'            => 'lumia 625',
        'lumia 630'            => 'lumia 630',
        'lumia 635'            => 'lumia 635',
        'lumia 640 xl'         => 'lumia 640 xl',
        'lumia 710'            => 'lumia 710',
        'lumia 720'            => 'lumia 720',
        'lumia 730'            => 'lumia 730',
        'lumia 735'            => 'lumia 735',
        'lumia 800'            => 'lumia 800',
        'lumia 820'            => 'lumia 820',
        'lumia 830'            => 'lumia 830',
        'lumia 900'            => 'lumia 900',
        'lumia 920'            => 'lumia 920',
        'lumia 925'            => 'lumia 925',
        'nokia 925'            => 'lumia 925',
        'lumia 928'            => 'lumia 928',
        'lumia 929'            => 'nokia lumia 929',
        'lumia 930'            => 'lumia 930',
        'lumia 950 xl'         => 'lumia 950 xl',
        'lumia 950'            => 'lumia 950',
        'lumia 1020'           => 'lumia 1020',
        'nokia; 909'           => 'lumia 1020',
        'arm; 909'             => 'lumia 1020',
        'lumia 1320'           => 'lumia 1320',
        'lumia 1520'           => 'lumia 1520',
        'lumia 435'            => 'lumia 435',
        ' n1 '                 => 'n1',
        'nokian80'             => 'nokia n80',
        'nokian81'             => 'n81',
        'nokian82'             => 'n82',
        'nokian85'             => 'n85',
        'nokian86'             => 'n86',
        'nokian8-00'           => 'n8-00',
        'nokian90'             => 'n90',
        'nokian91'             => 'n91',
        'nokian95'             => 'n95',
        'nokian96'             => 'n96',
        'nokian97'             => 'n97',
        'n900'                 => 'n900',
        'nokian9'              => 'n9',
        'nokian70'             => 'n70',
        'nokia n70'            => 'n70',
        'nokian73'             => 'nokia n73',
        'nokian76'             => 'nokia n76',
        'nokian78'             => 'n78',
        'nokia n78'            => 'n78',
        'nokian79'             => 'n79',
        'nokia n79'            => 'n79',
        'nokiax2ds'            => 'x2ds',
        'nokiax2-00'           => 'x2-00',
        'nokiax2-01'           => 'x2-01',
        'nokiax2-02'           => 'x2-02',
        'nokiax2-05'           => 'x2-05',
        'nokiax3-02'           => 'x3-02',
        'nokiax3-00'           => 'x3-00',
        'nokiax6-00'           => 'x6-00',
        'nokiax7-00'           => 'x7-00',
        'nokiax7'              => 'x7',
        'nokiae7-00'           => 'e7-00',
        'nokiae71-1'           => 'e71-1',
        'nokiae71'             => 'e71',
        'nokiae72'             => 'e72',
        'nokiae75'             => 'e75',
        'nokiae7'              => 'e7',
        'nokiae6-00'           => 'e6-00',
        'nokiae61i'            => 'nokia e61i',
        'nokiae61'             => 'nokia e61',
        'nokiae62'             => 'e62',
        'nokiae63'             => 'e63',
        'nokiae66'             => 'e66',
        'nokiae6'              => 'e6',
        'nokiae5-00'           => 'e5-00',
        'nokiae50'             => 'e50',
        'nokiae51'             => 'e51',
        'nokiae52'             => 'e52',
        'nokiae55'             => 'e55',
        'nokiae5'              => 'e5',
        'nokiae90'             => 'e90',
        'nokiae-90'            => 'e90',
        'nokiac7-00'           => 'c7-00',
        'nokiac7'              => 'nokia c7',
        'nokiac6-00'           => 'c6-00',
        'nokiac6-01'           => 'c6-01',
        'nokiac6'              => 'c6',
        'nokiac5-00'           => 'c5-00',
        'nokiac5-03'           => 'c5-03',
        'nokiac5-05'           => 'c5-05',
        'nokiac5'              => 'c5',
        'nokiac3-00'           => 'c3-00',
        'nokiac3-01'           => 'c3-01',
        'nokiac3'              => 'c3',
        'nokiac2-01'           => 'c2-01',
        'nokiac2-02'           => 'c2-02',
        'nokiac2-03'           => 'c2-03',
        'nokiac2-05'           => 'c2-05',
        'nokiac2-06'           => 'c2-06',
        'nokiac2'              => 'nokia c2',
        'nokiac1-01'           => 'c1-01',
        'nokiac1'              => 'c1',
        'nokia9500'            => '9500',
        'nokia7510'            => '7510',
        'nokia7230'            => '7230',
        'nokia6730c'           => '6730 classic',
        'nokia6720c'           => '6720 classic',
        'nokia6710s'           => '6710 slide',
        'nokia6700s'           => '6700s',
        'nokia6700c'           => '6700 classic',
        'nokia6630'            => '6630',
        'nokia6610i'           => '6610i',
        'nokia6555'            => '6555',
        'nokia6500s'           => '6500 slide',
        'nokia6500c'           => '6500 classic',
        'nokia6303iclassic'    => '6303i classic',
        'nokia6303classic'     => '6303 classic',
        'nokia6300'            => '6300',
        'nokia6220c'           => '6220 classic',
        'nokia6210'            => '6210',
        'nokia6131'            => '6131',
        'nokia6124c'           => 'nokia 6124c',
        'nokia6120c'           => '6120c',
        'nokia6120'            => 'nokia 6120',
        'nokia5730s'           => 'nokia 5730s',
        '6650d'                => 'nokia 6650d',
        'nokia5800d'           => '5800 xpressmusic',
        'nokia5800'            => '5800',
        'nokia5530c'           => 'nokia 5530 classic',
        'nokia5530'            => 'nokia 5530 classic',
        'nokia5320di'          => 'nokia 5320di',
        'nokia5320d'           => 'nokia 5320d',
        'nokia5310'            => '5310 xpressmusic',
        'nokia5250'            => '5250',
        'nokia5235'            => 'nokia 5235',
        'nokia5233'            => '5233',
        'nokia5230'            => '5230',
        'nokia5228'            => '5228',
        'nokia5220xpressmusic' => '5220 xpressmusic',
        '5130c-2'              => '5130c-2',
        'nokia3710'            => '3710',
        'nokia301.1'           => '301.1',
        'nokia301'             => '301',
        'nokia2760'            => '2760',
        'nokia2730c'           => '2730 classic',
        'nokia2720a'           => '2720a',
        'nokia2700c'           => '2700 classic',
        'nokia2630'            => '2630',
        'nokia2330c'           => '2330 classic',
        'nokia2323c'           => '2323c',
        'nokia2320c'           => '2320c',
        'nokia808pureview'     => '808 pureview',
        'nokia701'             => '701',
        'nokia700'             => '700',
        'nokia603'             => '603',
        'nokia515'             => '515',
        'nokia501'             => '501',
        'nokia500'             => '500',
        'nokiaasha500'         => '500',
        'nokia311'             => '311',
        'nokia309'             => '309',
        'nokia308'             => '308',
        'nokia306'             => '306',
        'nokia305'             => '305',
        'nokia303'             => '303',
        'nokia302'             => '302',
        'nokia300'             => '300',
        'nokia220'             => '220',
        'nokia210'             => '210',
        'nokia206'             => '206',
        'nokia205'             => '205',
        'nokia203'             => '203',
        'nokia202'             => 'nokia 202',
        'nokia201'             => '201',
        'nokia200'             => '200',
        'nokia113'             => '113',
        'nokia112'             => '112',
        'nokia110'             => '110',
        'nokia109'             => '109',
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
