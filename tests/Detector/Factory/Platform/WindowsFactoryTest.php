<?php

namespace BrowserDetectorTest\Detector\Factory\Platform;

use BrowserDetector\Detector\Factory\Platform\WindowsFactory;

/**
 * Test class for \BrowserDetector\Detector\Device\Mobile\GeneralMobile
 */
class WindowsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $platform
     * @param string $version
     * @param string $manufacturer
     * @param int    $bits
     */
    public function testDetect($agent, $platform, $version, $manufacturer, $bits)
    {
        /** @var \UaResult\Os\OsInterface $result */
        $result = WindowsFactory::detect($agent);

        self::assertInstanceOf('\UaResult\Os\OsInterface', $result);
        self::assertSame(
            $platform,
            $result->getName(),
            'Expected platform name to be "' . $platform . '" (was "' . $result->getName() . '")'
        );

        self::assertInstanceOf('\BrowserDetector\Version\Version', $result->getVersion());
        self::assertSame(
            $version,
            $result->getVersion()->getVersion(),
            'Expected version to be "' . $version . '" (was "' . $result->getVersion()->getVersion() . '")'
        );

        self::assertSame(
            $manufacturer,
            $result->getManufacturer(),
            'Expected manufacturer name to be "' . $manufacturer . '" (was "' . $result->getManufacturer() . '")'
        );

        self::assertSame(
            $bits,
            $result->getBits(),
            'Expected bits count to be "' . $bits . '" (was "' . $result->getBits() . '")'
        );
    }

    /**
     * @return array[]
     */
    public function providerDetect()
    {
        return [
            [
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C; .NET4.0E)',
                'Windows NT 5.2',
                '0.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko',
                'Windows NT 6.3',
                '0.0.0',
                'Microsoft Corporation',
                64,
            ],
            [
                'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0',
                'Windows NT 10.0',
                '0.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) Opera 8.60 [en]',
                'Windows NT 5.1',
                '0.0.0',
                'Microsoft Corporation',
                32,
            ],
            [
                'Mozilla/5.0 (Windows; U; MSIE 9.0; Windows NT 9.0; en-US)',
                'Windows NT',
                '0.0.0',
                'Microsoft Corporation',
                32,
            ],
        ];
    }
}
