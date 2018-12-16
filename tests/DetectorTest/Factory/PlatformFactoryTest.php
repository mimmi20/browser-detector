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
namespace BrowserDetectorTest\Factory;

use BrowserDetector\Factory\PlatformFactory;
use BrowserDetector\Loader\CompanyLoader;
use PHPUnit\Framework\TestCase;

class PlatformFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\PlatformFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        self::markTestIncomplete();

        $companyLoader = $this->createMock(CompanyLoader::class);

        /* @var CompanyLoader $companyLoader */
        $this->object = new PlatformFactory($companyLoader);
    }

    /**
     * @return void
     */
    public function testToArray(): void
    {
        self::markTestIncomplete();
    }
}
