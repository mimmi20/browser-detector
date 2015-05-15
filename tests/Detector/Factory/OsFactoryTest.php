<?php
namespace BrowserDetectorTest\Detector\Factory;

use BrowserDetector\Detector\Factory\OsFactory;

/**
 * Test class for \BrowserDetector\Detector\Os\FirefoxOs
 */
class OsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array[]
     */
    public function providerDetectPlatform()
    {
        return array(
            array('Mozilla/5.0 (Linux; U; Android 4.3; de-de; SAMSUNG GT-I9305/I9305XXUEMKC Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30', '\BrowserDetector\Detector\Os\AndroidOs'),
            array('Mozilla/5.0 (Android; Tablet; rv:15.0) Gecko/15.0 Firefox/15.0.1', '\BrowserDetector\Detector\Os\AndroidOs'),
            array('Mozilla/5.0 (Android; Mobile; rv:15.0) Gecko/15.0 Firefox/15.0', '\BrowserDetector\Detector\Os\AndroidOs'),
            array('Mozilla/5.0 (Android; Tablet; rv:23.0) Gecko/23.0 Firefox/23.0', '\BrowserDetector\Detector\Os\AndroidOs'),
            array('Mozilla/5.0 (Android; Mobile; rv:16.0) Gecko/16.0 Firefox/16.0', '\BrowserDetector\Detector\Os\AndroidOs'),
            array('Mozilla/5.0 (Android; Tablet; rv:24.0) Gecko/24.0 Firefox/24.0', '\BrowserDetector\Detector\Os\AndroidOs'),
            array('Mozilla/5.0 (Mobile; ALCATELOneTouch4012X/SVN 01010B; rv:18.1) Gecko/18.1 Firefox/18.1', '\BrowserDetector\Detector\Os\FirefoxOs'),
            array('Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; Microsoft; Lumia 535) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537', '\BrowserDetector\Detector\Os\WindowsPhoneOs'),
            array('Mozilla/5.0 (iPad; CPU OS 8_0_2 like Mac OS X) AppleWebKit/537.51.1 (KHTML, like Gecko) GSA/4.1.0.31802 Mobile/12A405 Safari/9537.53', '\BrowserDetector\Detector\Os\Ios'),
        );
    }

    /**
     * @param string $userAgent
     * @param string $platform
     *
     * @dataProvider providerDetectPlatform
     */
    public function testDetectPlatform($userAgent, $platform = '\StdClass')
    {
        $result = OsFactory::detectPlatform($userAgent);

        self::assertInstanceOf($platform, $result);
    }
}
