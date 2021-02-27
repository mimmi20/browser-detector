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

use BrowserDetector\Version\ObigoQ;
use BrowserDetector\Version\ObigoQFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

final class ObigoQFactoryTest extends TestCase
{
    /** @var \BrowserDetector\Version\ObigoQFactory */
    private $object;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->object = new ObigoQFactory();
    }

    /**
     * @return void
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        \assert($object instanceof ObigoQFactory, sprintf('$object should be an instance of %s, but is %s', ObigoQFactory::class, get_class($object)));
        $result = $object(new NullLogger());
        self::assertInstanceOf(ObigoQ::class, $result);
    }
}
