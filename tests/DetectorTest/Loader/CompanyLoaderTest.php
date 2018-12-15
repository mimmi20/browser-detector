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
namespace BrowserDetectorTest\Loader;

use BrowserDetector\Loader\CompanyLoader;
use BrowserDetector\Loader\NotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Test class for \BrowserDetector\Loader\CompanyLoader
 */
class CompanyLoaderTest extends TestCase
{
    /**
     * @var \BrowserDetector\Loader\CompanyLoader
     */
    private $object;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @throws \ExceptionalJSON\DecodeErrorException when the decode operation fails
     * @throws \RuntimeException
     *
     * @return void
     */
    protected function setUp(): void
    {
        self::markTestIncomplete();
        $this->object = CompanyLoader::getInstance();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        CompanyLoader::resetInstance();
    }

    /**
     * @dataProvider providerLoad
     *
     * @param string $companyKey
     * @param string $companyName
     * @param string $brand
     *
     * @return void
     */
    public function testLoadAvailable(string $companyKey, string $companyName, string $brand): void
    {
        self::markTestIncomplete();
        /** @var \UaResult\Company\CompanyInterface $result */
        $result = $this->object->load($companyKey);

        self::assertInstanceOf(\UaResult\Company\CompanyInterface::class, $result);

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
     * @dataProvider providerLoadByName
     *
     * @param string      $nameToSearch
     * @param string|null $companyName
     * @param string|null $brand
     *
     * @return void
     */
    public function testLoadByName(string $nameToSearch, ?string $companyName, ?string $brand): void
    {
        self::markTestIncomplete();
        /** @var \UaResult\Company\CompanyInterface $result */
        $result = $this->object->loadByName($nameToSearch);

        self::assertInstanceOf(\UaResult\Company\CompanyInterface::class, $result);

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
    public function providerLoadByName()
    {
        return [
            [
                'Google Inc.',
                'Google Inc.',
                'Google',
            ],
        ];
    }

    /**
     * @dataProvider providerLoadByBrandName
     *
     * @param string      $brandnameToSearch
     * @param string|null $companyName
     * @param string|null $brand
     *
     * @return void
     */
    public function testLoadByBrandName(string $brandnameToSearch, ?string $companyName, ?string $brand): void
    {
        self::markTestIncomplete();
        /** @var \UaResult\Company\CompanyInterface $result */
        $result = $this->object->loadByBrandName($brandnameToSearch);

        self::assertInstanceOf(\UaResult\Company\CompanyInterface::class, $result);

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
    public function providerLoadByBrandName()
    {
        return [
            [
                'Google',
                'Google Inc.',
                'Google',
            ],
        ];
    }

    /**
     * @return void
     */
    public function testLoadNotAvailable(): void
    {
        self::markTestIncomplete();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the company with key "does not exist" was not found');

        $this->object->load('does not exist');
    }

    /**
     * @return void
     */
    public function testLoadByBrandNameNotAvailable(): void
    {
        self::markTestIncomplete();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the company with brand name "This company does not exist" was not found');

        $this->object->loadByBrandName('This company does not exist');
    }

    /**
     * @return void
     */
    public function testLoadByNameNotAvailable(): void
    {
        self::markTestIncomplete();
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('the company with name "This company does not exist" was not found');

        $this->object->loadByName('This company does not exist');
    }

    /**
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testGetContents(): void
    {
        $class    = new \ReflectionClass($this->object);
        $function = $class->getMethod('getContents');
        $function->setAccessible(true);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('file_get_contents(some-not-existing-file.txt): failed to open stream: No such file or directory');
        $function->invoke($this->object, 'some-not-existing-file.txt');
    }
}
