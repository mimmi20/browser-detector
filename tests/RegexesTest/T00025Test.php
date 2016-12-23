<?php
/**
 * Copyright (c) 1998-2014 Browser Capabilities Project
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the LICENSE file distributed with this package.
 *
 * @category   CompareTest
 *
 * @copyright 2012-2016 Thomas Mueller
 * @license   http://www.opensource.org/licenses/MIT MIT License
 */

namespace BrowserDetectorTest\RegexesTest;

use BrowserDetectorTest\RegexesTest;

/**
 * Class RegexesTest
 *
 * @category   CompareTest
 *
 * @author     Thomas Mueller <mimmi20@live.de>
 * @group      useragenttest
 */
class T00025Test extends RegexesTest
{
    /**
     * @var string
     */
    protected $sourceDirectory = 'tests/issues/00025/';

    /**
     * @dataProvider userAgentDataProvider
     *
     * @param string $userAgent
     *
     *
     * @throws \Exception
     * @group  integration
     * @group  useragenttest
     * @group  00025
     */
    public function testUserAgents($userAgent)
    {
        parent::testUserAgents($userAgent);
    }
}
