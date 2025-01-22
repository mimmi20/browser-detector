<?php

/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2025, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace BrowserDetectorTest\Version;

use BrowserDetector\Version\MicrosoftInternetExplorer;
use BrowserDetector\Version\MicrosoftInternetExplorerFactory;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function assert;
use function sprintf;

#[CoversClass(MicrosoftInternetExplorerFactory::class)]
final class MicrosoftInternetExplorerFactoryTest extends TestCase
{
    private MicrosoftInternetExplorerFactory $object;

    /** @throws void */
    #[Override]
    protected function setUp(): void
    {
        $this->object = new MicrosoftInternetExplorerFactory();
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testInvoke(): void
    {
        $object = $this->object;
        assert(
            $object instanceof MicrosoftInternetExplorerFactory,
            sprintf(
                '$object should be an instance of %s, but is %s',
                MicrosoftInternetExplorerFactory::class,
                $object::class,
            ),
        );
        $result = $object();
        self::assertInstanceOf(MicrosoftInternetExplorer::class, $result);
    }
}
