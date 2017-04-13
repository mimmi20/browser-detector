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

/**
 * a general version detector factory
 *
 * @category  BrowserDetector
 *
 * @copyright 2012-2017 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
interface VersionCacheFactoryInterface
{
    /**
     * detects the bit count by this browser from the given user agent
     *
     * @param string $useragent
     *
     * @return \BrowserDetector\Version\Version
     */
    public function detectVersion($useragent);
}
