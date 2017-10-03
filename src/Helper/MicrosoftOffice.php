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
namespace BrowserDetector\Helper;

/**
 * @author Thomas Müller <mimmi20@live.de>
 */
class MicrosoftOffice
{
    /**
     * maps the version
     *
     * @param string $version
     *
     * @return string
     */
    public function mapVersion(string $version): string
    {
        if (in_array((int) $version, [2007, 2010, 2013, 2016])) {
            return (string) (int) $version;
        }

        if (16 === (int) $version) {
            return '2016';
        }

        if (15 === (int) $version) {
            return '2013';
        }

        if (14 === (int) $version) {
            return '2010';
        }

        if (12 === (int) $version) {
            return '2007';
        }

        return '0';
    }

    /**
     * detects the browser version from the given user agent
     *
     * @param string $useragent
     *
     * @return string
     */
    public function detectInternalVersion(string $useragent): string
    {
        $doMatch = preg_match('/MSOffice ([\d\.]+)/', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match('/Office\/([\d\.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match('/Office Mobile\/([\d\.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        $doMatch = preg_match('/Office Mobile for Symbian\/([\d\.]+)/i', $useragent, $matches);

        if ($doMatch) {
            return $matches[1];
        }

        return '0.0';
    }
}
