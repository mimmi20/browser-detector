<?php
declare(ENCODING = 'utf-8');
namespace Browscap\Browser\Khtml;

/**
 * Copyright(c) 2011 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or(at your option) any later version.
 *
 * Refer to the COPYING file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */

use Browscap\Browser\Handler as BrowserHandler;

/**
 * MaemoUserAgentHandler
 *
 *
 * @category   WURFL
 * @package    WURFL_Handlers
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
class MaemoBrowser extends BrowserHandler
{
    protected $prefix = 'MaemoBrowser';

    public function __construct($wurflContext, $userAgentNormalizer = null)
    {
        parent::__construct($wurflContext, $userAgentNormalizer);
    }

    /**
     *
     * @param string $userAgent
     * @return string
     */
    public function canHandle($userAgent)
    {
        return WURFL_Handlers_Utils::checkIfContains($userAgent, 'Maemo');
    }

    public function lookForMatchingUserAgent($userAgent)
    {
         $tolerance = WURFL_Handlers_Utils::firstSpace($userAgent);
        return parent::applyRisWithTollerance(array_keys($this->userAgentsWithDeviceID), $userAgent, $tolerance);
    }




}
