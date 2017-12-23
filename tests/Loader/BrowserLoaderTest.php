<?php
/**
 * This file is part of the browser-detector package.
 *
 * Copyright (c) 2012-2017, Thomas Mueller <mimmi20@live.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\BrowserLoader;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Test class for \BrowserDetector\Loader\BrowserLoader
 *
 * @author Thomas Müller <mimmi20@live.de>
 */
class BrowserLoaderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \BrowserDetector\Loader\BrowserLoader
     */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $cache        = new FilesystemAdapter('', 0, __DIR__ . '/../../cache/');
        $logger       = new NullLogger();
        $this->object = new BrowserLoader($cache, $logger);
    }

    /**
     * @return void
     * @throws \Psr\Cache\InvalidArgumentException
     * @throws \Seld\JsonLint\ParsingException
     */
    public function testLoadNotAvailable(): void
    {
        $this->expectException('\BrowserDetector\Loader\NotFoundException');
        $this->expectExceptionMessage('the browser with key "does not exist" was not found');

        $this->object->load('does not exist', 'test-ua');
    }
}
