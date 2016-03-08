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

namespace UaResult;

use UaMatcher\Version\VersionInterface;

/**
 * a general version detector
 *
 * @category  BrowserDetector
 * @copyright 2012-2015 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */
class Version implements VersionInterface, \Serializable
{
    /**
     * @var string the user agent to handle
     */
    private $useragent = null;

    /**
     * @var string the detected complete version
     */
    private $version = null;

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
     * @var string the default version
     */
    private $default = '';

    /**
     * @var int
     */
    private $mode = VersionInterface::COMPLETE;

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
                'version'   => $this->version,
                'mode'      => $this->mode,
                'useragent' => $this->useragent,
                'default'   => $this->default,
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

        $this->version   = $unseriliazedData['version'];
        $this->mode      = $unseriliazedData['mode'];
        $this->useragent = $unseriliazedData['useragent'];
        $this->default   = $unseriliazedData['default'];

        $this->setVersion($this->version);
    }

    /**
     * sets the user agent to be handled
     *
     * @param string $userAgent
     *
     * @return Version
     */
    public function setUserAgent($userAgent)
    {
        $this->useragent = $userAgent;

        return $this;
    }

    /**
     * sets the user agent to be handled
     *
     * @param int $mode
     *
     * @return Version
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * sets the default version, which is used, if no version could be detected
     *
     * @param string $version
     *
     * @throws \UnexpectedValueException
     * @return Version
     */
    public function setDefaulVersion($version)
    {
        if (!is_string($version)) {
            throw new \UnexpectedValueException(
                'the default version needs to be a string'
            );
        }

        $this->default = $version;
    }

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
    public function getVersion($mode = null)
    {
        if (null === $this->version) {
            if (null === $this->useragent) {
                throw new \UnexpectedValueException(
                    'You have to set the useragent before calling this function'
                );
            }

            $this->detectVersion();
        } elseif (null === $this->major) {
            $this->setVersion($this->version);
        }

        if (null === $mode) {
            $mode = $this->mode;
        }

        $versions = [];
        if (VersionInterface::MAJORONLY & $mode) {
            $versions[0] = $this->major;
        }

        if (VersionInterface::MINORONLY & $mode) {
            $versions[1] = $this->minor;
        }

        if (VersionInterface::MICROONLY & $mode) {
            $versions[2] = $this->micro;
        }

        $microIsEmpty = false;
        if (empty($versions[2]) || '0' === $versions[2] || '' === $versions[2]) {
            $microIsEmpty = true;
        }

        if (VersionInterface::IGNORE_MICRO & $mode) {
            unset($versions[2]);
        } elseif (VersionInterface::IGNORE_MICRO_IF_EMPTY & $mode && $microIsEmpty) {
            unset($versions[2]);
        }

        $minorIsEmpty = false;

        if (VersionInterface::IGNORE_MINOR & $mode) {
            unset($versions[1]);
            unset($versions[2]);
            $minorIsEmpty = true;
        } elseif (VersionInterface::IGNORE_MINOR_IF_EMPTY & $mode) {
            if ($microIsEmpty
                && (empty($versions[1]) || '0' === $versions[1] || '00' === $versions[1] || '' === $versions[1])
            ) {
                $minorIsEmpty = true;
            }

            if ($minorIsEmpty) {
                unset($versions[1]);
                unset($versions[2]);
            }
        }

        $macroIsEmpty = false;

        if (VersionInterface::IGNORE_MACRO_IF_EMPTY & $mode) {
            if ((empty($versions[0]) || '0' === $versions[0] || '' === $versions[0]) && $minorIsEmpty) {
                $macroIsEmpty = true;
            }

            if ($macroIsEmpty) {
                unset($versions[0]);
                unset($versions[1]);
                unset($versions[2]);
            }
        }

        $version = implode('.', $versions);

        if ('0' === $version || '0.0' === $version || '0.0.0' === $version) {
            $version = '';
        }

        if (VersionInterface::GET_ZERO_IF_EMPTY & $mode && '' === $version) {
            $version = '0';
        }

        return $version;
    }

    /**
     * sets the detected version
     *
     * @param string $version
     *
     * @throws \UnexpectedValueException
     * @return Version
     */
    public function setVersion($version)
    {
        $version  = trim(trim(str_replace('_', '.', $version)), '.');
        $splitted = explode('.', $version, 3);

        $this->major = (!empty($splitted[0]) ? $splitted[0] : '0');
        $this->minor = (!empty($splitted[1]) ? $splitted[1] : '0');
        $this->micro = (!empty($splitted[2]) ? $splitted[2] : '0');

        $this->version = $version;

        return $this;
    }

    /**
     * detects the bit count by this browser from the given user agent
     *
     * @param string|array $searches
     *
     * @throws \UnexpectedValueException
     * @return Version
     */
    public function detectVersion($searches = '')
    {
        if (!is_array($searches) && !is_string($searches)) {
            throw new \UnexpectedValueException(
                'a string or an array of strings is expected as parameter'
            );
        }

        if (!is_array($searches)) {
            $searches = [$searches];
        }

        $modifiers = [
            ['\/', ''],
            ['\(', '\)'],
            [' ', ''],
            ['', ''],
            [' \(', '\;'],
        ];

        /** @var $version string */
        $version   = $this->default;
        $useragent = $this->useragent;

        if (false !== strpos($useragent, '%')) {
            $useragent = urldecode($useragent);
        }

        foreach ($searches as $search) {
            if (!is_string($search)) {
                continue;
            }

            if (false !== strpos($search, '%')) {
                $search = urldecode($search);
            }

            $found = false;

            foreach ($modifiers as $modifier) {
                $compareString = '/' . $search . $modifier[0] . '(\d+[\d\.\_ab]*)' . $modifier[1] . '/';

                $doMatch = preg_match(
                    $compareString,
                    $useragent,
                    $matches
                );

                if ($doMatch) {
                    $version = $matches[1];
                    $found   = true;
                    break;
                }
            }

            if ($found) {
                break;
            }
        }

        return $this->setVersion($version);
    }

    /**
     * detects if the version is makred as Alpha
     *
     * @return bool
     */
    public function isAlpha()
    {
        return (false !== strpos($this->version, 'a'));
    }

    /**
     * detects if the version is makred as Beta
     *
     * @return bool
     */
    public function isBeta()
    {
        return (false !== strpos($this->version, 'b'));
    }
}
