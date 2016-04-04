<?php
/**
 * Copyright (c) 2012-2015, Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
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
 * @author    Thomas Mueller <t_mueller_stolzenhain@yahoo.de>
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 * @link      https://github.com/mimmi20/BrowserDetector
 */

namespace BrowserDetector\Version;

/**
 * a general version detector
 *
 * @category  BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Version implements VersionInterface, \Serializable
{
    const STABILITY_REGEX = '[-|_|\.]{0,1}([R|r][C|c]|pl|a|alpha|[B|b][E|e][T|t][A|a]|b|B|patch|stable|p|[D|d][E|e][V|v]|[D|d])\.{0,1}(\d*)';

    /**
     * @var string the detected major version
     */
    private $major = null;

    /**
     * @var string the detected minor version
     */
    private $minor = null;

    /**
     * @var string the detected micro version
     */
    private $micro = null;

    /**
     * @var string
     */
    private $stability = null;

    /**
     * @var string
     */
    private $build = null;

    /**
     * @param int|string $major
     * @param int|string $minor
     * @param int|string $patch
     * @param array|string $preRelease OPTIONAL
     * @param array|string $build OPTIONAL
     */
    public function __construct($major = '0', $minor = '0', $patch = '0', $preRelease = null, $build = null)
    {
        if ((!is_int($major) && !is_string($major)) || $major < 0) {
            throw new \InvalidArgumentException('Major version must be a non-negative integer or a string');
        }
        if ((!is_int($minor) && !is_string($minor)) || $minor < 0) {
            throw new \InvalidArgumentException('Minor version must be a non-negative integer or a string');
        }
        if ((!is_int($patch) && !is_string($patch)) || $patch < 0) {
            throw new \InvalidArgumentException('Patch version must be a non-negative integer or a string');
        }

        $this->major = (string) $major;
        $this->minor = (string) $minor;
        $this->micro = (string) $patch;
        $this->stability = $preRelease;
        $this->build = $build;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize(
            [
                'major'      => $this->major,
                'minor'      => $this->minor,
                'micro'      => $this->micro,
                'preRelease' => $this->stability,
                'build'      => $this->build,
            ]
        );
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     */
    public function unserialize($serialized)
    {
        $unseriliazedData = unserialize($serialized);

        $this->major     = $unseriliazedData['major'];
        $this->minor     = $unseriliazedData['minor'];
        $this->micro     = $unseriliazedData['micro'];
        $this->stability = $unseriliazedData['preRelease'];
        $this->build     = $unseriliazedData['build'];
    }

    /**
     * @return int
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * @return int
     */
    public function getMinor()
    {
        return $this->minor;
    }

    /**
     * @return int
     */
    public function getMicro()
    {
        return $this->micro;
    }

    /**
     * @return null|string
     */
    public function getBuild()
    {
        return $this->build;
    }

    /**
     * @return null|string
     */
    public function getStability()
    {
        return $this->stability;
    }

    /**
     * converts the version object into a string
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->getVersion(
                VersionInterface::COMPLETE
            );
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * returns the detected version
     *
     * @param int $mode
     *
     * @throws \UnexpectedValueException
     * @return string
     */
    public function getVersion($mode = VersionInterface::COMPLETE)
    {
        $versions = [];
        if (VersionInterface::MAJORONLY & $mode) {
            $versions[0] = $this->major;
        }

        if (VersionInterface::MINORONLY & $mode) {
            $versions[1] = $this->minor;
        }

        if (VersionInterface::MICROONLY & $mode) {
            $versions[2] = $this->micro;
            $versions[3] = $this->stability;
            $versions[4] = $this->build;
        }

        $microIsEmpty = false;
        if (empty($versions[2]) || '0' === $versions[2] || '' === $versions[2]) {
            $microIsEmpty = true;
        }

        if (VersionInterface::IGNORE_MICRO & $mode) {
            unset($versions[2], $versions[3], $versions[4]);
        } elseif (VersionInterface::IGNORE_MICRO_IF_EMPTY & $mode && $microIsEmpty) {
            unset($versions[2], $versions[3], $versions[4]);
        }

        $minorIsEmpty = false;

        if (VersionInterface::IGNORE_MINOR & $mode) {
            unset($versions[1], $versions[2], $versions[3], $versions[4]);
            $minorIsEmpty = true;
        } elseif (VersionInterface::IGNORE_MINOR_IF_EMPTY & $mode) {
            if ($microIsEmpty
                && (empty($versions[1]) || '0' === $versions[1] || '00' === $versions[1] || '' === $versions[1])
            ) {
                $minorIsEmpty = true;
            }

            if ($minorIsEmpty) {
                unset($versions[1], $versions[2], $versions[3], $versions[4]);
            }
        }

        $macroIsEmpty = false;

        if (VersionInterface::IGNORE_MACRO_IF_EMPTY & $mode) {
            if ((empty($versions[0]) || '0' === $versions[0] || '' === $versions[0]) && $minorIsEmpty) {
                $macroIsEmpty = true;
            }

            if ($macroIsEmpty) {
                unset($versions[0], $versions[1], $versions[2], $versions[3], $versions[4]);
            }
        }

        if (!isset($versions[0])) {
            if (VersionInterface::GET_ZERO_IF_EMPTY & $mode) {
                return '0';
            }

            return '';
        }

        return $versions[0]
            . (isset($versions[1]) ? '.' . (string) $versions[1] : '')
            . (isset($versions[2]) ? '.' . (string) $versions[2] : '')
            . ((isset($versions[3]) && 'stable' !== $versions[3]) ? '-' . (string) $versions[3] : '')
            . (isset($versions[4]) ? '+' . (string) $versions[4] : '');
    }
}
