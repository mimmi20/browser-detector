<?php
namespace BrowserDetectorTest\Detector\Factory;

use BrowserDetector\Detector\Factory\PlatformFactory;
use BrowserDetector\Detector\Version;

/**
 * Test class for \BrowserDetector\Detector\Device\GeneralMobile
 */
class PlatformFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerDetect
     *
     * @param string $agent
     * @param string $platform
     * @param string $version
     */
    public function testDetect($agent, $platform, $version)
    {
        /** @var \Monolog\Logger $logger */
        $logger = $this->getMock('\Monolog\Logger', array(), array(), '', false);

        /** @var \UaMatcher\Os\OsInterface $result */
        $result = PlatformFactory::detect($agent, $logger);

        self::assertInstanceOf('\UaMatcher\Os\OsInterface', $result);
        self::assertSame($platform, $result->getName());

        self::assertInstanceOf('\BrowserDetector\Detector\Version', $result->detectVersion());
        self::assertSame($version, $result->detectVersion()->getVersion(Version::MAJORMINOR));

        self::assertInstanceOf('\BrowserDetector\Detector\Company\CompanyInterface', $result->getManufacturer());
    }

    public function providerDetect()
    {
        return array(
            array(
                'Mozilla/5.0 (iPad; CPU OS 8_1_2 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12B440 Safari/600.1.4',
                'iOS',
                '8.1'
            ),
            array(
                'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.2; Trident/4.0; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; .NET4.0C; .NET4.0E)',
                'Windows',
                'XP.0'
            ),
            array(
                'Mozilla/5.0 (Linux; U; Android 4.3; de-de; GT-I9300 Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30',
                'Android',
                '4.3'
            ),
            array(
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko)',
                'Mac OS X',
                '10.10'
            ),
            array(
                'Mozilla/5.0 (Windows NT 6.3; WOW64; Trident/7.0; Touch; rv:11.0) like Gecko',
                'Windows',
                '8.1'
            ),
            array(
                'Mozilla/5.0 (BB10; Touch) AppleWebKit/537.35+ (KHTML, like Gecko) Version/10.2.2.1609 Mobile Safari/537.35+',
                'RIM OS',
                '10.2'
            ),
            array(
                'Mozilla/5.0 (Nintendo 3DS; U; ; de) Version/1.7567.EU',
                'Nintendo OS',
                ''
            ),
            array(
                'Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; NOKIA; Lumia 930) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537',
                'Windows Phone OS',
                '8.1'
            ),
            array(
                'Mozilla/5.0 (Windows NT 10.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0',
                'Windows',
                '10.0'
            ),
        );
    }
}
