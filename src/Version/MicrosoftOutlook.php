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
namespace BrowserDetector\Version;

use BrowserDetector\Helper\MicrosoftOffice as MicrosoftOfficeHelper;

/**
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class MicrosoftOutlook implements VersionCacheFactoryInterface
{
    /**
     * returns the version of the operating system/platform
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public function detectVersion($useragent)
    {
        $doMatch = preg_match('/microsoft office outlook ([\d\.]+)/i', $useragent, $matches);

        $helper = new MicrosoftOfficeHelper();

        if ($doMatch) {
            return VersionFactory::set($helper->mapVersion($matches[1]));
        }

        $doMatch = preg_match('/microsoft outlook ([\d\.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return VersionFactory::set($helper->mapVersion($matches[1]));
        }

        return VersionFactory::set('0.0');
    }
}
