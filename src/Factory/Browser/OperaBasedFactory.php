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
namespace BrowserDetector\Factory\Browser;

use BrowserDetector\Factory\FactoryInterface;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;
use UaResult\Os\OsInterface;

/**
 * Browser detection class
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class OperaBasedFactory implements FactoryInterface
{
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
        if ($s->containsAny(['ucbrowser', 'ubrowser', 'uc browser', 'ucweb'], false) && $s->contains('opera mini', false)) {
            return $this->loader->load('ucbrowser', $useragent);
        }

        if ($s->containsAny(['opera mini', 'opios'], false)) {
            return $this->loader->load('opera mini', $useragent);
        }

        if ($s->contains('opera mobi', false)
            || ($s->containsAny(['opera', 'opr'], false) && $s->containsAny(['android', 'mtk', 'maui', 'samsung', 'windows ce', 'symbos'], false))
        ) {
            return $this->loader->load('opera mobile', $useragent);
        }

        $lastBrowsers = [
            'ucbrowser'                   => 'ucbrowser',
            'ubrowser'                    => 'ucbrowser',
            'uc browser'                  => 'ucbrowser',
            'ucweb'                       => 'ucbrowser',
            'ic opengraph crawler'        => 'ibm connections',
            'coast'                       => 'coast',
            'opr'                         => 'opera',
            'opera'                       => 'opera',
            'icabmobile'                  => 'icab mobile',
            'icab'                        => 'icab',
            'hggh phantomjs screenshoter' => 'hggh screenshot system with phantomjs',
            'bl.uk_lddc_bot'              => 'bl.uk_lddc_bot',
            'phantomas'                   => 'phantomas',
            'seznam screenshot-generator' => 'seznam screenshot generator',
            'phantomjs'                   => 'phantomjs',
            'yabrowser'                   => 'yabrowser',
            'kamelio'                     => 'kamelio app',
            'fban/messenger'              => 'facebook messenger app',
            'fbav'                        => 'facebook app',
            'acheetahi'                   => 'cm browser',
            'puffin'                      => 'puffin',
            'stagefright'                 => 'stagefright',
            'oculusbrowser'               => 'oculus-browser',
            'surfbrowser'                 => 'surfbrowser',
            'surf/'                       => 'surfbrowser',
            'avirascout'                  => 'avira scout',
            'samsungbrowser'              => 'samsungbrowser',
            'silk'                        => 'silk',
            'coc_coc_browser'             => 'coc_coc_browser',
            'navermatome'                 => 'matome',
            'flipboardproxy'              => 'flipboardproxy',
            'flipboard'                   => 'flipboard app',
            'seznambot'                   => 'seznambot',
            'seznam.cz'                   => 'seznam browser',
            'sznprohlizec'                => 'seznam browser',
            'aviator'                     => 'aviator',
            'netfrontlifebrowser'         => 'netfrontlifebrowser',
            'icedragon'                   => 'icedragon',
        ];

        foreach ($lastBrowsers as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load('opera', $useragent);
    }
}
