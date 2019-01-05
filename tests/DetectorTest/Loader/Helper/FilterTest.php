<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2019, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader\Helper;

use BrowserDetector\Loader\BrowserLoaderFactory;
use BrowserDetector\Loader\Helper\Filter;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    /**
     * @return void
     */
    public function testInvokeFail(): void
    {
        $object = new Filter();

        $result = $object(BrowserLoaderFactory::DATA_PATH, 'json');

        self::assertInstanceOf(\Iterator::class, $result);
    }
}
