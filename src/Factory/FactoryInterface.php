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
namespace BrowserDetector\Factory;

use Stringy\Stringy;

interface FactoryInterface
{
    /**
     * @param string           $useragent
     * @param \Stringy\Stringy $s
     *
     * @return mixed
     */
    public function detect(string $useragent, Stringy $s = null);
}
