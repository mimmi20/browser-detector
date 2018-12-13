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
namespace BrowserDetector\Loader\Helper;

use BrowserDetector\Cache\CacheInterface;
use ExceptionalJSON\DecodeErrorException;
use JsonClass\Json;
use JsonClass\JsonInterface;
use Symfony\Component\Finder\Finder;

interface DataInterface extends CacheInterface
{
    /**
     * @return bool
     */
    public function isInitialized(): bool;

    /**
     * @return void
     */
    public function __invoke(): void;
}
