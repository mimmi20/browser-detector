<?php

namespace BrowserDetectorTest\Detector\Factory;

use BrowserDetector\Detector\Factory\CompanyFactory;

/**
 * Test class for \BrowserDetector\Detector\Company\Mobile\GeneralMobile
 */
class CompanyFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerGet
     *
     * @param string $companyKey
     * @param string $companyName
     * @param string $brand
     */
    public function testGet($companyKey, $companyName, $brand)
    {
        /** @var \UaResult\Company\CompanyInterface $result */
        $result = CompanyFactory::get($companyKey);

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
    public function providerGet()
    {
        return [
            [
                'A6Corp',
                'A6 Corp',
                'A6 Corp',
            ],
            [
                'does not exist',
                'unknown',
                'unknown',
            ],
        ];
    }
}
