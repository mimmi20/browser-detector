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
class AlcatelFactory implements Factory\FactoryInterface
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
        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)8008d/i', $useragent)) {
            return $this->loader->load('ot-8008d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)8000d/i', $useragent)) {
            return $this->loader->load('ot-8000d', $useragent);
        }

        if ($s->contains('7049d', false)) {
            return $this->loader->load('ot-7049d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7047d/i', $useragent)) {
            return $this->loader->load('ot-7047d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7041x/i', $useragent)) {
            return $this->loader->load('ot-7041x', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7041d/i', $useragent)) {
            return $this->loader->load('ot-7041d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)7025d/i', $useragent)) {
            return $this->loader->load('ot-7025d', $useragent);
        }

        if ($s->contains('6050a', false)) {
            return $this->loader->load('ot-6050a', $useragent);
        }

        if ($s->contains('6043d', false)) {
            return $this->loader->load('ot-6043d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6040d/i', $useragent)) {
            return $this->loader->load('ot-6040d', $useragent);
        }

        if ($s->contains('6036y', false)) {
            return $this->loader->load('ot-6036y', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6035r/i', $useragent)) {
            return $this->loader->load('ot-6035r', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6034r/i', $useragent)) {
            return $this->loader->load('ot-6034r', $useragent);
        }

        if ($s->contains('4034d', false)) {
            return $this->loader->load('ot-4034d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6033x/i', $useragent)) {
            return $this->loader->load('ot-6033x', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6032/i', $useragent)) {
            return $this->loader->load('ot-6032', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6030x/i', $useragent)) {
            return $this->loader->load('ot-6030x', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6030d/i', $useragent)) {
            return $this->loader->load('ot-6030d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6015x/i', $useragent)) {
            return $this->loader->load('ot-6015x', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6012d/i', $useragent)) {
            return $this->loader->load('ot-6012d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6010x/i', $useragent)) {
            return $this->loader->load('ot-6010x', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)6010d/i', $useragent)) {
            return $this->loader->load('ot-6010d', $useragent);
        }

        if ($s->contains('5042d', false)) {
            return $this->loader->load('ot-5042d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5036d/i', $useragent)) {
            return $this->loader->load('ot-5036d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5035d/i', $useragent)) {
            return $this->loader->load('ot-5035d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)5020d/i', $useragent)) {
            return $this->loader->load('ot-5020d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4037t/i', $useragent)) {
            return $this->loader->load('ot-4037t', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4030x/i', $useragent)) {
            return $this->loader->load('ot-4030x', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4030d/i', $useragent)) {
            return $this->loader->load('ot-4030d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4015x/i', $useragent)) {
            return $this->loader->load('ot-4015x', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4015d/i', $useragent)) {
            return $this->loader->load('ot-4015d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4012x/i', $useragent)) {
            return $this->loader->load('ot-4012x', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)4012a/i', $useragent)) {
            return $this->loader->load('ot-4012a', $useragent);
        }

        if ($s->contains('3075A', true)) {
            return $this->loader->load('ot-3075a', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)997d/i', $useragent)) {
            return $this->loader->load('ot-997d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)995/i', $useragent)) {
            return $this->loader->load('ot-995', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)992d/i', $useragent)) {
            return $this->loader->load('ot-992d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991t/i', $useragent)) {
            return $this->loader->load('ot-991t', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991d/i', $useragent)) {
            return $this->loader->load('ot-991d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)991/i', $useragent)) {
            return $this->loader->load('ot-991', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)990/i', $useragent)) {
            return $this->loader->load('ot-990', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)985d/i', $useragent)) {
            return $this->loader->load('ot-985d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)980/i', $useragent)) {
            return $this->loader->load('ot-980', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)918d/i', $useragent)) {
            return $this->loader->load('ot-918d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)918/i', $useragent)) {
            return $this->loader->load('ot-918', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)908/i', $useragent)) {
            return $this->loader->load('ot-908', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)903d/i', $useragent)) {
            return $this->loader->load('ot-903d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)890d/i', $useragent)) {
            return $this->loader->load('one touch 890d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)890/i', $useragent)) {
            return $this->loader->load('ot-890', $useragent);
        }

        if ($s->contains('OT871A', true)) {
            return $this->loader->load('ot-871a', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)818/i', $useragent)) {
            return $this->loader->load('ot-818', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)710d/i', $useragent)) {
            return $this->loader->load('ot-710d', $useragent);
        }

        if (preg_match('/(ot\-|one[ _]touch[ _]|onetouch)216/i', $useragent)) {
            return $this->loader->load('ot-216', $useragent);
        }

        if ($s->contains('Vodafone 975N', true)) {
            return $this->loader->load('975n', $useragent);
        }

        if ($s->containsAny(['V860', 'Vodafone Smart II'], true)) {
            return $this->loader->load('v860', $useragent);
        }

        if ($s->contains('P321', true)) {
            return $this->loader->load('ot-p321', $useragent);
        }

        if ($s->contains('P320X', true)) {
            return $this->loader->load('ot-p320x', $useragent);
        }

        if ($s->contains('P310X', true)) {
            return $this->loader->load('ot-p310x', $useragent);
        }

        if ($s->contains('P310A', true)) {
            return $this->loader->load('ot-p310a', $useragent);
        }

        if ($s->contains('ONE TOUCH TAB 8HD', true)) {
            return $this->loader->load('ot-tab8hd', $useragent);
        }

        if ($s->contains('ONE TOUCH TAB 7HD', true)) {
            return $this->loader->load('ot-tab7hd', $useragent);
        }

        if ($s->contains('ALCATEL ONE TOUCH Fierce', true)) {
            return $this->loader->load('fierce', $useragent);
        }

        return $this->loader->load('general alcatel device', $useragent);
    }
}
