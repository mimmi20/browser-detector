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
        if ($s->contains('genm14', false)) {
            return $this->loader->load('xl2', $useragent);
        }

        if ($s->contains('nokia_xl', false)) {
            return $this->loader->load('xl', $useragent);
        }

        if ($s->containsAny(['lumia 650', 'id336'], false)) {
            return $this->loader->load('lumia 650', $useragent);
        }

        if ($s->contains('lumia 510', false)) {
            return $this->loader->load('lumia 510', $useragent);
        }

        if ($s->containsAny(['rm-1113', 'lumia 640 lte'], false)) {
            return $this->loader->load('rm-1113', $useragent);
        }

        if ($s->contains('rm-1090', false)) {
            return $this->loader->load('rm-1090', $useragent);
        }

        if ($s->contains('rm-1089', false)) {
            return $this->loader->load('rm-1089', $useragent);
        }

        if ($s->contains('rm-1072', false)) {
            return $this->loader->load('rm-1072', $useragent);
        }

        if ($s->contains('rm-1073', false)) {
            return $this->loader->load('rm-1073', $useragent);
        }

        if ($s->contains('rm-1074', false)) {
            return $this->loader->load('rm-1074', $useragent);
        }

        if ($s->contains('rm-1076', false)) {
            return $this->loader->load('rm-1076', $useragent);
        }

        if ($s->contains('rm-1077', false)) {
            return $this->loader->load('rm-1077', $useragent);
        }

        if ($s->containsAny(['rm-1075', 'lumia 640 dual sim'], false)) {
            return $this->loader->load('rm-1075', $useragent);
        }

        if ($s->contains('rm-1062', false)) {
            return $this->loader->load('rm-1062', $useragent);
        }

        if ($s->contains('rm-1063', false)) {
            return $this->loader->load('rm-1063', $useragent);
        }

        if ($s->contains('rm-1064', false)) {
            return $this->loader->load('rm-1064', $useragent);
        }

        if ($s->contains('rm-1065', false)) {
            return $this->loader->load('rm-1065', $useragent);
        }

        if ($s->contains('rm-1066', false)) {
            return $this->loader->load('rm-1066', $useragent);
        }

        if ($s->contains('rm-1067', false)) {
            return $this->loader->load('rm-1067', $useragent);
        }

        if ($s->contains('rm-1045', false)) {
            return $this->loader->load('rm-1045', $useragent);
        }

        if ($s->contains('rm-1038', false)) {
            return $this->loader->load('rm-1038', $useragent);
        }

        if ($s->containsAny(['rm-1031', 'lumia 532'], false)) {
            return $this->loader->load('rm-1031', $useragent);
        }

        if ($s->contains('rm-1010', false)) {
            return $this->loader->load('rm-1010', $useragent);
        }

        if ($s->contains('rm-994', false)) {
            return $this->loader->load('rm-994', $useragent);
        }

        if ($s->contains('rm-978', false)) {
            return $this->loader->load('rm-978', $useragent);
        }

        if ($s->contains('rm-976', false)) {
            return $this->loader->load('rm-976', $useragent);
        }

        if ($s->contains('rm-974', false)) {
            return $this->loader->load('rm-974', $useragent);
        }

        if ($s->contains('rm-914', false)) {
            return $this->loader->load('lumia 520 rm-914', $useragent);
        }

        if ($s->contains('rm-846', false)) {
            return $this->loader->load('rm-846', $useragent);
        }

        if ($s->contains('rm-997', false)) {
            return $this->loader->load('rm-997', $useragent);
        }

        if ($s->contains('lumia 521', false)) {
            return $this->loader->load('lumia 521', $useragent);
        }

        if ($s->contains('lumia 520', false)) {
            return $this->loader->load('lumia 520', $useragent);
        }

        if ($s->contains('lumia 530', false)) {
            return $this->loader->load('lumia 530', $useragent);
        }

        if ($s->contains('lumia 535', false)) {
            return $this->loader->load('lumia 535', $useragent);
        }

        if ($s->contains('lumia 540', false)) {
            return $this->loader->load('lumia 540', $useragent);
        }

        if ($s->contains('lumia 550', false)) {
            return $this->loader->load('lumia 550', $useragent);
        }

        if ($s->contains('lumia 610', false)) {
            return $this->loader->load('lumia 610', $useragent);
        }

        if ($s->contains('lumia 620', false)) {
            return $this->loader->load('lumia 620', $useragent);
        }

        if ($s->contains('lumia 625', false)) {
            return $this->loader->load('lumia 625', $useragent);
        }

        if ($s->contains('lumia 630', false)) {
            return $this->loader->load('lumia 630', $useragent);
        }

        if ($s->contains('lumia 635', false)) {
            return $this->loader->load('lumia 635', $useragent);
        }

        if ($s->contains('lumia 640 xl', false)) {
            return $this->loader->load('lumia 640 xl', $useragent);
        }

        if ($s->contains('lumia 640', false)) {
            return $this->loader->load('lumia 640', $useragent);
        }

        if ($s->contains('lumia 710', false)) {
            return $this->loader->load('lumia 710', $useragent);
        }

        if ($s->contains('lumia 720', false)) {
            return $this->loader->load('lumia 720', $useragent);
        }

        if ($s->contains('lumia 730', false)) {
            return $this->loader->load('lumia 730', $useragent);
        }

        if ($s->contains('lumia 735', false)) {
            return $this->loader->load('lumia 735', $useragent);
        }

        if ($s->contains('lumia 800', false)) {
            return $this->loader->load('lumia 800', $useragent);
        }

        if ($s->contains('lumia 820', false)) {
            return $this->loader->load('lumia 820', $useragent);
        }

        if ($s->contains('lumia 830', false)) {
            return $this->loader->load('lumia 830', $useragent);
        }

        if ($s->contains('lumia 900', false)) {
            return $this->loader->load('lumia 900', $useragent);
        }

        if ($s->contains('lumia 920', false)) {
            return $this->loader->load('lumia 920', $useragent);
        }

        if ($s->containsAny(['lumia 925', 'nokia 925'], false)) {
            return $this->loader->load('lumia 925', $useragent);
        }

        if ($s->contains('lumia 928', false)) {
            return $this->loader->load('lumia 928', $useragent);
        }

        if ($s->contains('lumia 930', false)) {
            return $this->loader->load('lumia 930', $useragent);
        }

        if ($s->contains('lumia 950 xl', false)) {
            return $this->loader->load('lumia 950 xl', $useragent);
        }

        if ($s->contains('lumia 950', false)) {
            return $this->loader->load('lumia 950', $useragent);
        }

        if ($s->containsAny(['lumia 1020', 'nokia; 909', 'arm; 909'], false)) {
            return $this->loader->load('lumia 1020', $useragent);
        }

        if ($s->contains('lumia 1320', false)) {
            return $this->loader->load('lumia 1320', $useragent);
        }

        if ($s->contains('lumia 1520', false)) {
            return $this->loader->load('lumia 1520', $useragent);
        }

        if ($s->contains('lumia 435', false)) {
            return $this->loader->load('lumia 435', $useragent);
        }

        if ($s->contains('lumia', false)) {
            return $this->loader->load('lumia', $useragent);
        }

        if ($s->contains(' N1 ', true)) {
            return $this->loader->load('n1', $useragent);
        }

        if ($s->contains('nokian81', false)) {
            return $this->loader->load('n81', $useragent);
        }

        if ($s->contains('nokian82', false)) {
            return $this->loader->load('n82', $useragent);
        }

        if ($s->contains('nokian85', false)) {
            return $this->loader->load('n85', $useragent);
        }

        if ($s->contains('nokian86', false)) {
            return $this->loader->load('n86', $useragent);
        }

        if ($s->contains('nokian8-00', false)) {
            return $this->loader->load('n8-00', $useragent);
        }

        if ($s->contains('nokian8', false)) {
            return $this->loader->load('n8', $useragent);
        }

        if ($s->contains('nokian90', false)) {
            return $this->loader->load('n90', $useragent);
        }

        if ($s->contains('nokian91', false)) {
            return $this->loader->load('n91', $useragent);
        }

        if ($s->contains('nokian95', false)) {
            return $this->loader->load('n95', $useragent);
        }

        if ($s->contains('nokian96', false)) {
            return $this->loader->load('n96', $useragent);
        }

        if ($s->contains('nokian97', false)) {
            return $this->loader->load('n97', $useragent);
        }

        if ($s->contains('nokian900', false)) {
            return $this->loader->load('n900', $useragent);
        }

        if ($s->contains('nokian9', false)) {
            return $this->loader->load('n9', $useragent);
        }

        if ($s->containsAny(['nokian70', 'nokia n70'], false)) {
            return $this->loader->load('n70', $useragent);
        }

        if ($s->containsAny(['nokian78', 'nokia n78'], false)) {
            return $this->loader->load('n78', $useragent);
        }

        if ($s->containsAny(['nokian79', 'nokia n79'], false)) {
            return $this->loader->load('n79', $useragent);
        }

        if ($s->contains('NokiaX2DS', false)) {
            return $this->loader->load('x2ds', $useragent);
        }

        if ($s->contains('NokiaX2-00', false)) {
            return $this->loader->load('x2-00', $useragent);
        }

        if ($s->contains('NokiaX2-01', false)) {
            return $this->loader->load('x2-01', $useragent);
        }

        if ($s->contains('NokiaX2-02', false)) {
            return $this->loader->load('x2-02', $useragent);
        }

        if ($s->contains('NokiaX2-05', false)) {
            return $this->loader->load('x2-05', $useragent);
        }

        if ($s->contains('NokiaX2', false)) {
            return $this->loader->load('x2', $useragent);
        }

        if ($s->contains('NokiaX3-02', false)) {
            return $this->loader->load('x3-02', $useragent);
        }

        if ($s->contains('NokiaX3-00', false)) {
            return $this->loader->load('x3-00', $useragent);
        }

        if ($s->contains('NokiaX3', false)) {
            return $this->loader->load('x3', $useragent);
        }

        if ($s->contains('NokiaX6-00', false)) {
            return $this->loader->load('x6-00', $useragent);
        }

        if ($s->contains('NokiaX6', false)) {
            return $this->loader->load('x6', $useragent);
        }

        if ($s->contains('NokiaX7-00', false)) {
            return $this->loader->load('x7-00', $useragent);
        }

        if ($s->contains('NokiaX7', false)) {
            return $this->loader->load('x7', $useragent);
        }

        if ($s->contains('NokiaE7-00', false)) {
            return $this->loader->load('e7-00', $useragent);
        }

        if ($s->contains('NokiaE71-1', false)) {
            return $this->loader->load('e71-1', $useragent);
        }

        if ($s->contains('NokiaE71', false)) {
            return $this->loader->load('e71', $useragent);
        }

        if ($s->contains('NokiaE72', false)) {
            return $this->loader->load('e72', $useragent);
        }

        if ($s->contains('NokiaE75', false)) {
            return $this->loader->load('e75', $useragent);
        }

        if ($s->contains('NokiaE7', false)) {
            return $this->loader->load('e7', $useragent);
        }

        if ($s->contains('NokiaE6-00', false)) {
            return $this->loader->load('e6-00', $useragent);
        }

        if ($s->contains('NokiaE62', false)) {
            return $this->loader->load('e62', $useragent);
        }

        if ($s->contains('NokiaE63', false)) {
            return $this->loader->load('e63', $useragent);
        }

        if ($s->contains('NokiaE66', false)) {
            return $this->loader->load('e66', $useragent);
        }

        if ($s->contains('NokiaE6', false)) {
            return $this->loader->load('e6', $useragent);
        }

        if ($s->contains('NokiaE5-00', false)) {
            return $this->loader->load('e5-00', $useragent);
        }

        if ($s->contains('NokiaE50', false)) {
            return $this->loader->load('e50', $useragent);
        }

        if ($s->contains('NokiaE51', false)) {
            return $this->loader->load('e51', $useragent);
        }

        if ($s->contains('NokiaE52', false)) {
            return $this->loader->load('e52', $useragent);
        }

        if ($s->contains('NokiaE55', false)) {
            return $this->loader->load('e55', $useragent);
        }

        if ($s->contains('NokiaE56', false)) {
            return $this->loader->load('e56', $useragent);
        }

        if ($s->contains('NokiaE5', false)) {
            return $this->loader->load('e5', $useragent);
        }

        if ($s->contains('NokiaE90', false)) {
            return $this->loader->load('e90', $useragent);
        }

        if ($s->contains('NokiaC7-00', false)) {
            return $this->loader->load('c7-00', $useragent);
        }

        if ($s->contains('NokiaC7', false)) {
            return $this->loader->load('nokia c7', $useragent);
        }

        if ($s->contains('NokiaC6-00', false)) {
            return $this->loader->load('c6-00', $useragent);
        }

        if ($s->contains('NokiaC6-01', false)) {
            return $this->loader->load('c6-01', $useragent);
        }

        if ($s->contains('NokiaC6', false)) {
            return $this->loader->load('c6', $useragent);
        }

        if ($s->contains('NokiaC5-00', false)) {
            return $this->loader->load('c5-00', $useragent);
        }

        if ($s->contains('NokiaC5-03', false)) {
            return $this->loader->load('c5-03', $useragent);
        }

        if ($s->contains('NokiaC5-05', false)) {
            return $this->loader->load('c5-05', $useragent);
        }

        if ($s->contains('NokiaC5', false)) {
            return $this->loader->load('c5', $useragent);
        }

        if ($s->contains('NokiaC3-00', false)) {
            return $this->loader->load('c3-00', $useragent);
        }

        if ($s->contains('NokiaC3-01', false)) {
            return $this->loader->load('c3-01', $useragent);
        }

        if ($s->contains('NokiaC3', false)) {
            return $this->loader->load('c3', $useragent);
        }

        if ($s->contains('NokiaC2-01', false)) {
            return $this->loader->load('c2-01', $useragent);
        }

        if ($s->contains('NokiaC2-02', false)) {
            return $this->loader->load('c2-02', $useragent);
        }

        if ($s->contains('NokiaC2-03', false)) {
            return $this->loader->load('c2-03', $useragent);
        }

        if ($s->contains('NokiaC2-05', false)) {
            return $this->loader->load('c2-05', $useragent);
        }

        if ($s->contains('NokiaC2-06', false)) {
            return $this->loader->load('c2-06', $useragent);
        }

        if ($s->contains('NokiaC2', false)) {
            return $this->loader->load('nokia c2', $useragent);
        }

        if ($s->contains('NokiaC1-01', false)) {
            return $this->loader->load('c1-01', $useragent);
        }

        if ($s->contains('NokiaC1', false)) {
            return $this->loader->load('c1', $useragent);
        }

        if ($s->contains('Nokia9500', false)) {
            return $this->loader->load('9500', $useragent);
        }

        if ($s->contains('Nokia7510', false)) {
            return $this->loader->load('7510', $useragent);
        }

        if ($s->contains('Nokia7230', false)) {
            return $this->loader->load('7230', $useragent);
        }

        if ($s->contains('Nokia6730c', false)) {
            return $this->loader->load('6730 classic', $useragent);
        }

        if ($s->contains('Nokia6720c', false)) {
            return $this->loader->load('6720 classic', $useragent);
        }

        if ($s->contains('Nokia6710s', false)) {
            return $this->loader->load('6710 slide', $useragent);
        }

        if ($s->contains('Nokia6700s', false)) {
            return $this->loader->load('6700s', $useragent);
        }

        if ($s->contains('Nokia6700c', false)) {
            return $this->loader->load('6700 classic', $useragent);
        }

        if ($s->contains('Nokia6630', false)) {
            return $this->loader->load('6630', $useragent);
        }

        if ($s->contains('Nokia6610I', false)) {
            return $this->loader->load('6610i', $useragent);
        }

        if ($s->contains('Nokia6555', false)) {
            return $this->loader->load('6555', $useragent);
        }

        if ($s->contains('Nokia6500s', false)) {
            return $this->loader->load('6500 slide', $useragent);
        }

        if ($s->contains('Nokia6500c', false)) {
            return $this->loader->load('6500 classic', $useragent);
        }

        if ($s->contains('Nokia6303iclassic', false)) {
            return $this->loader->load('6303i classic', $useragent);
        }

        if ($s->contains('Nokia6303classic', false)) {
            return $this->loader->load('6303 classic', $useragent);
        }

        if ($s->contains('Nokia6300', false)) {
            return $this->loader->load('6300', $useragent);
        }

        if ($s->contains('Nokia6220c', false)) {
            return $this->loader->load('6220 classic', $useragent);
        }

        if ($s->contains('Nokia6210', false)) {
            return $this->loader->load('6210', $useragent);
        }

        if ($s->contains('Nokia6131', false)) {
            return $this->loader->load('6131', $useragent);
        }

        if ($s->contains('Nokia6120c', false)) {
            return $this->loader->load('6120c', $useragent);
        }

        if ($s->contains('Nokia5800d', false)) {
            return $this->loader->load('5800 xpressmusic', $useragent);
        }

        if ($s->contains('Nokia5800', false)) {
            return $this->loader->load('5800', $useragent);
        }

        if ($s->contains('Nokia5530c', false)) {
            return $this->loader->load('nokia 5530 classic', $useragent);
        }

        if ($s->contains('Nokia5530', false)) {
            return $this->loader->load('nokia 5530 classic', $useragent);
        }

        if ($s->contains('Nokia5330c', false)) {
            return $this->loader->load('5330 classic', $useragent);
        }

        if ($s->contains('Nokia5310', false)) {
            return $this->loader->load('5310 xpressmusic', $useragent);
        }

        if ($s->contains('Nokia5250', false)) {
            return $this->loader->load('5250', $useragent);
        }

        if ($s->contains('Nokia5233', false)) {
            return $this->loader->load('5233', $useragent);
        }

        if ($s->contains('Nokia5230', false)) {
            return $this->loader->load('5230', $useragent);
        }

        if ($s->contains('Nokia5228', false)) {
            return $this->loader->load('5228', $useragent);
        }

        if ($s->contains('Nokia5220XpressMusic', false)) {
            return $this->loader->load('5220 xpressmusic', $useragent);
        }

        if ($s->contains('5130c-2', false)) {
            return $this->loader->load('5130c-2', $useragent);
        }

        if ($s->contains('Nokia5130c', false)) {
            return $this->loader->load('5130 classic', $useragent);
        }

        if ($s->contains('Nokia3710', false)) {
            return $this->loader->load('3710', $useragent);
        }

        if ($s->contains('Nokia301.1', false)) {
            return $this->loader->load('301.1', $useragent);
        }

        if ($s->contains('Nokia301', false)) {
            return $this->loader->load('301', $useragent);
        }

        if ($s->contains('Nokia2760', false)) {
            return $this->loader->load('2760', $useragent);
        }

        if ($s->contains('Nokia2730c', false)) {
            return $this->loader->load('2730 classic', $useragent);
        }

        if ($s->contains('Nokia2720a', false)) {
            return $this->loader->load('2720a', $useragent);
        }

        if ($s->contains('Nokia2700c', false)) {
            return $this->loader->load('2700 classic', $useragent);
        }

        if ($s->contains('nokia2630', false)) {
            return $this->loader->load('2630', $useragent);
        }

        if ($s->contains('nokia2330c', false)) {
            return $this->loader->load('2330 classic', $useragent);
        }

        if ($s->contains('nokia2323c', false)) {
            return $this->loader->load('2323c', $useragent);
        }

        if ($s->contains('nokia2320c', false)) {
            return $this->loader->load('2320c', $useragent);
        }

        if ($s->contains('nokia808pureview', false)) {
            return $this->loader->load('808 pureview', $useragent);
        }

        if ($s->contains('nokia701', false)) {
            return $this->loader->load('701', $useragent);
        }

        if ($s->contains('nokia700', false)) {
            return $this->loader->load('700', $useragent);
        }

        if ($s->contains('nokia603', false)) {
            return $this->loader->load('603', $useragent);
        }

        if ($s->contains('nokia515', false)) {
            return $this->loader->load('515', $useragent);
        }

        if ($s->contains('nokia501', false)) {
            return $this->loader->load('501', $useragent);
        }

        if ($s->containsAny(['nokia500', 'nokiaasha500'], false)) {
            return $this->loader->load('500', $useragent);
        }

        if ($s->contains('nokia311', false)) {
            return $this->loader->load('311', $useragent);
        }

        if ($s->contains('nokia309', false)) {
            return $this->loader->load('309', $useragent);
        }

        if ($s->contains('nokia308', false)) {
            return $this->loader->load('308', $useragent);
        }

        if ($s->contains('nokia306', false)) {
            return $this->loader->load('306', $useragent);
        }

        if ($s->contains('nokia305', false)) {
            return $this->loader->load('305', $useragent);
        }

        if ($s->contains('nokia303', false)) {
            return $this->loader->load('303', $useragent);
        }

        if ($s->contains('nokia302', false)) {
            return $this->loader->load('302', $useragent);
        }

        if ($s->contains('nokia300', false)) {
            return $this->loader->load('300', $useragent);
        }

        if ($s->contains('nokia220', false)) {
            return $this->loader->load('220', $useragent);
        }

        if ($s->contains('nokia210', false)) {
            return $this->loader->load('210', $useragent);
        }

        if ($s->contains('nokia206', false)) {
            return $this->loader->load('206', $useragent);
        }

        if ($s->contains('nokia205', false)) {
            return $this->loader->load('205', $useragent);
        }

        if ($s->contains('nokia203', false)) {
            return $this->loader->load('203', $useragent);
        }

        if ($s->contains('nokia201', false)) {
            return $this->loader->load('201', $useragent);
        }

        if ($s->contains('nokia200', false)) {
            return $this->loader->load('200', $useragent);
        }

        if ($s->contains('nokia113', false)) {
            return $this->loader->load('113', $useragent);
        }

        if ($s->contains('nokia112', false)) {
            return $this->loader->load('112', $useragent);
        }

        if ($s->contains('nokia110', false)) {
            return $this->loader->load('110', $useragent);
        }

        if ($s->contains('nokia109', false)) {
            return $this->loader->load('109', $useragent);
        }

        return $this->loader->load('general nokia device', $useragent);
    }
}
