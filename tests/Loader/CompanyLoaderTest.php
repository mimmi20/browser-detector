<?php

namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoader;
use Cache\Adapter\Filesystem\FilesystemCachePool;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Test class for \BrowserDetector\Loader\CompanyLoader
 */
class CompanyLoaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Loader\CompanyLoader
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $adapter      = new Local(__DIR__ . '/../../cache/');
        $cache        = new FilesystemCachePool(new Filesystem($adapter));
        $this->object = new CompanyLoader($cache);
    }

    /**
     * @dataProvider providerLoad
     *
     * @param string $companyKey
     * @param string $companyName
     * @param string $brand
     */
    public function testLoadAvailable($companyKey, $companyName, $brand)
    {
        /** @var \UaResult\Company\CompanyInterface $result */
        $result = $this->object->load($companyKey, 'test-ua');

        self::assertInstanceOf('\UaResult\Company\CompanyInterface', $result);
        self::assertInstanceOf('\UaResult\Company\Company', $result);

        self::assertSame(
            $companyName,
            $result->getName(),
            'Expected Company name to be "' . $companyName . '" (was "' . $result->getName() . '")'
        );
        self::assertSame(
            $brand,
            $result->getBrandName(),
            'Expected brand name to be "' . $brand . '" (was "' . $result->getBrandName() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerLoad()
    {
        return [
            [
                'A6Corp',
                'A6 Corp',
                'A6 Corp',
            ],
        ];
    }

    /**
     * @expectedException \BrowserDetector\Loader\NotFoundException
     * @expectedExceptionMessage the company with key "does not exist" was not found
     */
    public function testLoadNotAvailable()
    {
        $this->object->load('does not exist', 'test-ua');
    }
}
