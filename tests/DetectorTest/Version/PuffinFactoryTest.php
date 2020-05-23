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

use BrowserDetector\Version\Puffin;
use BrowserDetector\Version\PuffinFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class PuffinFactoryTest extends TestCase
{
    /** @var \BrowserDetector\Version\PuffinFactory */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new PuffinFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        \assert($object instanceof PuffinFactory, sprintf('$object should be an instance of %s, but is %s', PuffinFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(Puffin::class, $result);
    }
}
