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
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Ios;
use BrowserDetector\Version\IosFactory;
use PHPUnit\Framework\TestCase;

final class IosFactoryTest extends TestCase
{
    /** @var \BrowserDetector\Version\IosFactory */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new IosFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        \assert($object instanceof IosFactory, sprintf('$object should be an instance of %s, but is %s', IosFactory::class, get_class($object)));
        $result = $object();
        self::assertInstanceOf(Ios::class, $result);
    }
}
