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
namespace BrowserDetector\Factory;

use BrowserDetector\Loader\NotFoundException;
use Psr\Log\LoggerInterface;
use UaDisplaySize\TypeLoader;
use UaDisplaySize\Unknown;
use UaResult\Device\Display;
use UaResult\Device\DisplayInterface;
use UaResult\Device\Market;
use UaResult\Device\MarketInterface;

final class MarketFactory
{
    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param array                    $data
     *
     * @return \UaResult\Device\MarketInterface
     */
    public function fromArray(LoggerInterface $logger, array $data): MarketInterface
    {
        $vendors  = array_key_exists('vendors', $data) ? (array) $data['vendors'] : [];
        $regions = array_key_exists('regions', $data) ? (array) $data['regions'] : [];
        $countries  = array_key_exists('countries', $data) ? (array) $data['countries'] : [];

        return new Market($vendors, $regions, $countries);
    }
}
