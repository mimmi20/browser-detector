<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2020, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\Debian;
use BrowserDetector\Version\DebianFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class DebianFactoryTest extends TestCase
{
    /** @var \BrowserDetector\Version\DebianFactory */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new DebianFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        \assert($object instanceof DebianFactory, sprintf('$object should be an instance of %s, but is %s', DebianFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(Debian::class, $result);
    }
}
