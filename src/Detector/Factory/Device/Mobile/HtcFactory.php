<?php
/**
 * Copyright (c) 2012-2016, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  BrowserDetector
 *
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 *
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Detector\Factory\Device\Mobile;

use BrowserDetector\Detector\Device\Mobile\Htc;
use BrowserDetector\Detector\Factory\FactoryInterface;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class HtcFactory implements FactoryInterface
{
    /**
     * detects the device name from the given user agent
     *
     * @param string $useragent
     *
     * @return \UaResult\Device\DeviceInterface
     */
    public static function detect($useragent)
    {
        if (preg_match('/(Nexus[ \-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/Nexus 9/i', $useragent)) {
            return new Htc\HtcNexus9($useragent, []);
        }

        if (preg_match('/nexus(hd2| evohd2)/i', $useragent)) {
            return new Htc\HtcNexusHd2($useragent, []);
        }

        if (preg_match('/One\_M8/i', $useragent)) {
            return new Htc\HtcOneM8($useragent, []);
        }

        if (preg_match('/(One[ _]X\+|OneXplus)/i', $useragent)) {
            return new Htc\HtcOneXplus($useragent, []);
        }

        if (preg_match('/One[ _]XL/i', $useragent)) {
            return new Htc\HtcOneXl($useragent, []);
        }

        if (preg_match('/(One[ _]X|OneX|PJ83100)/i', $useragent)) {
            return new Htc\HtcOneX($useragent, []);
        }

        if (preg_match('/One[ _]V/i', $useragent)) {
            return new Htc\HtcOneV($useragent, []);
        }

        if (preg_match('/(One[ _]SV|OneSV)/i', $useragent)) {
            return new Htc\HtcOneSv($useragent, []);
        }

        if (preg_match('/(One[ _]S|OneS)/i', $useragent)) {
            return new Htc\HtcOneS($useragent, []);
        }

        if (preg_match('/one[ _]mini[ _]2/i', $useragent)) {
            return new Htc\HtcOneMini2($useragent, []);
        }

        if (preg_match('/one[ _]mini/i', $useragent)) {
            return new Htc\HtcOneMini($useragent, []);
        }

        if (preg_match('/one/i', $useragent)) {
            return new Htc\HtcOne($useragent, []);
        }

        if (preg_match('/(Smart Tab III 7|SmartTabIII7)/i', $useragent)) {
            return new Htc\VodafoneSmartTabIii7($useragent, []);
        }

        if (preg_match('/(X315e|Runnymede)/i', $useragent)) {
            return new Htc\HtcX315eSensationXlBeats($useragent, []);
        }

        if (preg_match('/(Sensation XE|SensationXE)/i', $useragent)) {
            return new Htc\HtcZ715eSensationXeBeats($useragent, []);
        }

        if (preg_match('/(HTC\_Sensation\-orange\-LS|HTC\_Sensation\-LS)/i', $useragent)) {
            return new Htc\HtcZ710SensationLs($useragent, []);
        }

        if (preg_match('/Sensation[ _]Z710e/i', $useragent)) {
            return new Htc\HtcZ710e($useragent, []);
        }

        if (preg_match('/sensation/i', $useragent)) {
            return new Htc\HtcZ710($useragent, []);
        }

        if (preg_match('/Xda\_Diamond\_2/i', $useragent)) {
            return new Htc\HtcXdaDiamond2($useragent, []);
        }

        if (preg_match('/(EVO[ _]3D|EVO3D|x515m)/i', $useragent)) {
            return new Htc\HtcX515m($useragent, []);
        }

        if (preg_match('/x515e/i', $useragent)) {
            return new Htc\HtcX515e($useragent, []);
        }

        if (preg_match('/x515/i', $useragent)) {
            return new Htc\HtcX515($useragent, []);
        }

        if (preg_match('/desirez\_a7272/i', $useragent)) {
            return new Htc\HtcDesireZA7272($useragent, []);
        }

        if (preg_match('/(desire[ _]z|desirez)/i', $useragent)) {
            return new Htc\HtcDesireZ($useragent, []);
        }

        if (preg_match('/(desire[ _]x|desirex)/i', $useragent)) {
            return new Htc\HtcDesireX($useragent, []);
        }

        if (preg_match('/(desire[ _]v|desirev)/i', $useragent)) {
            return new Htc\HtcDesireV($useragent, []);
        }

        if (preg_match('/(desire[ _]sv|desiresv)/i', $useragent)) {
            return new Htc\HtcDesireSv($useragent, []);
        }

        if (preg_match('/(desire[ _]s|desires)/i', $useragent)) {
            return new Htc\HtcDesireS($useragent, []);
        }

        if (preg_match('/WildfireS\-orange\-LS|WildfireS\-LS/i', $useragent)) {
            return new Htc\HtcWildfireSLs($useragent, []);
        }

        if (preg_match('/ a315c /i', $useragent)) {
            return new Htc\HtcA315c($useragent, []);
        }

        if (preg_match('/Wildfire\_A3333/i', $useragent)) {
            return new Htc\HtcA3333($useragent, []);
        }

        if (preg_match('/(Wildfire S A510e|WildfireS_A510e)/i', $useragent)) {
            return new Htc\HtcA510e($useragent, []);
        }

        if (preg_match('/ADR6230/i', $useragent)) {
            return new Htc\HtcAdr6230($useragent, []);
        }

        if (preg_match('/Wildfire[ |]S/i', $useragent)) {
            return new Htc\HtcA510($useragent, []);
        }

        if (preg_match('/Wildfire/i', $useragent)) {
            return new Htc\HtcWildfire($useragent, []);
        }

        if (preg_match('/Vision/i', $useragent)) {
            return new Htc\HtcVision($useragent, []);
        }

        if (preg_match('/Velocity 4G/i', $useragent)) {
            return new Htc\HtcVelocity4G($useragent, []);
        }

        if (preg_match('/Velocity/i', $useragent)) {
            return new Htc\HtcVelocity($useragent, []);
        }

        if (preg_match('/Touch\_HD\_T8282/i', $useragent)) {
            return new Htc\HtcTouchHdT8282($useragent, []);
        }

        if (preg_match('/Touch\_Diamond2/i', $useragent)) {
            return new Htc\HtcTouchDiamond2($useragent, []);
        }

        if (preg_match('/titan/i', $useragent)) {
            return new Htc\HtcTitan($useragent, []);
        }

        if (preg_match('/tattoo/i', $useragent)) {
            return new Htc\HtcTattoo($useragent, []);
        }

        if (preg_match('/(HD7|Mondrian)/i', $useragent)) {
            return new Htc\HtcT9292($useragent, []);
        }

        if (preg_match('/7 Mozart/i', $useragent)) {
            return new Htc\HtcT8698($useragent, []);
        }

        if (preg_match('/T8282/i', $useragent)) {
            return new Htc\HtcT8282($useragent, []);
        }

        if (preg_match('/7 Pro T7576/i', $useragent)) {
            return new Htc\HtcT7576($useragent, []);
        }

        if (preg_match('/Touch\_Pro2\_T7373/i', $useragent)) {
            return new Htc\HtcT7373($useragent, []);
        }

        if (preg_match('/Touch2/i', $useragent)) {
            return new Htc\HtcT3335($useragent, []);
        }

        if (preg_match('/T328w/i', $useragent)) {
            return new Htc\HtcT328w($useragent, []);
        }

        if (preg_match('/(7 Trophy|mwp6985)/i', $useragent)) {
            return new Htc\HtcSpark($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        if (preg_match('/(Nexus[ |\-]One|NexusOne)/i', $useragent)) {
            return new Htc\GalaxyNexusOne($useragent, []);
        }

        return new Htc($useragent, []);
    }
}
