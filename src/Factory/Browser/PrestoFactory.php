<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2018, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetector\Factory\Browser;

use BrowserDetector\Factory\FactoryInterface;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;
use UaResult\Os\OsInterface;

/**
 * Browser detection class
 */
class PrestoFactory implements FactoryInterface
{
    private $browsers = [
        '/ucweb.*opera mini/i'                                             => 'ucbrowser',
        'opera mini'                                                       => 'opera mini',
        'opera mobi'                                                       => 'opera mobile',
        '/(?:android|mtk|maui|samsung|windows ce|symbos).*(?:opera|opr)/i' => 'opera mobile',
        '/(?:opera|opr).*(?:android|mtk|maui|samsung|windows ce|symbos)/i' => 'opera mobile',
    ];

    /**
     * @var string
     */
    private $genericBrowser = 'opera';

    /**
     * @var \BrowserDetector\Loader\ExtendedLoaderInterface
     */
    private $loader;

    /**
     * @param \BrowserDetector\Loader\ExtendedLoaderInterface $loader
     */
    public function __construct(ExtendedLoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Gets the information about the browser by User Agent
     *
     * @param string                        $useragent
     * @param Stringy                       $s
     * @param \UaResult\Os\OsInterface|null $platform
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s, ?OsInterface $platform = null): array
    {
        foreach ($this->browsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load($this->genericBrowser, $useragent);
    }
}
