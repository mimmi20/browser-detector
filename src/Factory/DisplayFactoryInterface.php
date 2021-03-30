<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2021, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetector\Factory;

use Psr\Log\LoggerInterface;
use UaResult\Device\DisplayInterface;

interface DisplayFactoryInterface
{
    /**
     * @param array<string, (int|bool|float|null)> $data
     */
    public function fromArray(LoggerInterface $logger, array $data): DisplayInterface;
}
