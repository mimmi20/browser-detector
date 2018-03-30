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
namespace BrowserDetector\Factory\Device\Mobile;

use BrowserDetector\Factory;
use BrowserDetector\Loader\ExtendedLoaderInterface;
use Stringy\Stringy;

class MicromaxFactory implements Factory\FactoryInterface
{
    /**
     * @var array
     */
    private $devices = [
        'p650'      => 'micromax p650',
        'p600'      => 'micromax p600',
        'p560'      => 'micromax p560',
        'p410i'     => 'micromax p410i',
        'p410'      => 'micromax p410',
        'p362'      => 'micromax p362',
        'p360'      => 'micromax p360',
        'p350'      => 'micromax p350',
        'q413'      => 'micromax q413',
        'q392'      => 'micromax q392',
        'q391'      => 'micromax q391',
        'q380'      => 'micromax q380',
        'q372'      => 'micromax q372',
        'q345'      => 'micromax q345',
        'q332'      => 'micromax q332',
        'q327'      => 'micromax q327',
        'e481'      => 'micromax e481',
        'e455'      => 'micromax e455',
        'e352'      => 'micromax e352',
        'e313'      => 'micromax e313',
        'd321'      => 'micromax d321',
        'aq5001'    => 'micromax aq5001',
        'aq4501'    => 'micromax aq4501',
        'a300'      => 'micromax a300',
        'a177'      => 'micromax a177',
        'a120'      => 'micromax a120',
        'a116i'     => 'micromax a116i',
        'a116'      => 'micromax a116',
        'a114'      => 'micromax a114',
        'a110'      => 'micromax a110',
        'a107'      => 'micromax a107',
        'a106'      => 'micromax a106',
        'a101'      => 'micromax a101',
        'a093'      => 'micromax a093',
        'a065'      => 'micromax a065',
        'a99'       => 'micromax a99',
        'a96'       => 'micromax a96',
        'a87'       => 'micromax a87',
        'a59'       => 'micromax a59',
        'a50'       => 'micromax a50',
        'a47'       => 'micromax a47',
        'a40'       => 'micromax a40',
        'a35'       => 'micromax a35',
        'a27'       => 'micromax a27',
        'p280'      => 'micromax p280',
        'p250'      => 'micromax p250',
        'p275'      => 'micromax p275',
        'p500'      => 'micromax p500',
        'x351'      => 'micromax x351',
        'x321'      => 'micromax x321',
        'x324'      => 'micromax x324',
        'x325'      => 'micromax x325',
        'x328'      => 'micromax x328',
        'x329'      => 'micromax x329',
        'x446'      => 'micromax x446',
        'x1i ultra' => 'micromax x1i ultra',
        'x103i'     => 'micromax x103i',
        'x101i'     => 'micromax x101i',
        'x295'      => 'micromax x295',
        'x263'      => 'micromax x263',
        'x267'      => 'micromax x267',
        'x272'      => 'micromax x272',
        'x335'      => 'micromax x335',
        'x335c'     => 'micromax x335c',
        'q50'       => 'micromax q50',
        'q5'        => 'micromax q5',
        'x292i'     => 'micromax x292i',
        'x292'      => 'micromax x292',
        'x279i'     => 'micromax x279i',
        'x279'      => 'micromax x279',
        'x336'      => 'micromax x336',
        'x337'      => 'micromax x337',
        'x367'      => 'micromax x367',
        'x282'      => 'micromax x282',
        'x288'      => 'micromax x288',
        'x070'      => 'micromax x070',
        'x088'      => 'micromax x088',
        'x085'      => 'micromax x085',
        'x084'      => 'micromax x084',
        'x081'      => 'micromax x081',
        'x097'      => 'micromax x097',
        'x098'      => 'micromax x098',
        'x247'      => 'micromax x247',
        'x455i'     => 'micromax x455i',
        'x456'      => 'micromax x456',
        'x457'      => 'micromax x457',
        'x458'      => 'micromax x458',
        'x352'      => 'micromax x352',
        'x353'      => 'micromax x353',
        'x501'      => 'micromax x501',
        'x650'      => 'micromax x650',
    ];

    /**
     * @var string
     */
    private $genericDevice = 'general micromax device';

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
     * detects the device name from the given user agent
     *
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return array
     */
    public function detect(string $useragent, Stringy $s): array
    {
        $matches = [];

        if (preg_match('/micromax[ _](a?[adepqsx]\d{1,4}[bciqrs]?)/i', $useragent, $matches)) {
            $key = 'micromax ' . mb_strtolower($matches[1]);

            if ($this->loader->has($key)) {
                return $this->loader->load($key, $useragent);
            }
        }

        foreach ($this->devices as $search => $key) {
            if ($s->contains($search, false)) {
                return $this->loader->load($key, $useragent);
            }
        }

        return $this->loader->load($this->genericDevice, $useragent);
    }
}
