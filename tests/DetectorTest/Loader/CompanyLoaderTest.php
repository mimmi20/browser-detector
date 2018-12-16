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
use BrowserDetector\Loader\Helper\Data;
use BrowserDetector\Loader\Helper\DataInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

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
        $data = $this->createMock(DataInterface::class);

        /* @var Data $data */
        $this->object = new CompanyLoader(new NullLogger(), $data);
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
        $object = $this->object;

        /** @var \UaResult\Company\CompanyInterface $result */
        $result = $object($companyKey);

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
}
