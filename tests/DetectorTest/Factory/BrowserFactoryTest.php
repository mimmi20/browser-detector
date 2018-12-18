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

use BrowserDetector\Factory\BrowserFactory;
use BrowserDetector\Loader\CompanyLoaderInterface;
use PHPUnit\Framework\TestCase;

class BrowserFactoryTest extends TestCase
{
    /**
     * @var \BrowserDetector\Factory\BrowserFactory
     */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $companyLoader = $this->createMock(CompanyLoaderInterface::class);

        /* @var \BrowserDetector\Loader\CompanyLoaderInterface $companyLoader */
        $this->object = new BrowserFactory($companyLoader);
    }

    /**
     * @return void
     */
    public function testFromArray(): void
    {
        self::markTestIncomplete();
    }
}
