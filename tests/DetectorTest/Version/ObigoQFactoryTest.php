<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2023, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\ObigoQ;
use BrowserDetector\Version\ObigoQFactory;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

use function assert;
use function sprintf;

final class ObigoQFactoryTest extends TestCase
{
    private ObigoQFactory $object;

    /** @throws void */
    protected function setUp(): void
    {
        $this->object = new ObigoQFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof ObigoQFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                ObigoQFactory::class,
                $object::class,
            ),
        );
        $result = $object(new NullLogger());
        self::assertInstanceOf(ObigoQ::class, $result);
    }
}
