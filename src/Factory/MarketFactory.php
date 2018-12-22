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

use UaResult\Device\Market;
use UaResult\Device\MarketInterface;

final class MarketFactory implements MarketFactoryInterface
{
    /**
     * @param array $data
     *
     * @return \UaResult\Device\MarketInterface
     */
    public function fromArray(array $data): MarketInterface
    {
        $vendors   = array_key_exists('vendors', $data) ? array_values((array) $data['vendors']) : [];
        $regions   = array_key_exists('regions', $data) ? array_values((array) $data['regions']) : [];
        $countries = array_key_exists('countries', $data) ? array_values((array) $data['countries']) : [];

        return new Market($vendors, $regions, $countries);
    }
}
