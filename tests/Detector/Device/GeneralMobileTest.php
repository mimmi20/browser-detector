<?php
namespace BrowserDetectorTest\Detector\Device;

use BrowserDetector\Detector\Device\GeneralMobile;

/**
 * Test class for \BrowserDetector\Detector\Device\GeneralMobile
 */
class GeneralMobileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Device\GeneralMobile
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new GeneralMobile();
    }

    /**
     * @dataProvider providerCanHandlePositive
     * @param string $agent
     */
    public function testCanHandlePositive($agent)
    {
        $this->object->setUserAgent($agent);

        self::assertTrue($this->object->canHandle());
    }

    public function providerCanHandlePositive()
    {
        return array(
            array('Mozilla/5.0 (Windows NT 6.3; Win64; x64; Trident/7.0; Touch; rv:11.0) like Gecko'),
        );
    }

    /**
     * @dataProvider providerCanHandleNegative
     * @param string $agent
     */
    public function testCanHandleNegative($agent)
    {
        $this->object->setUserAgent($agent);

        self::assertFalse($this->object->canHandle());
    }

    public function providerCanHandleNegative()
    {
        return array(
            array('Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)'),
            array('Mozilla/5.0 (Windows; U; Windows NT 5.1; pl; rv:1.9) Gecko/2008052906 Firefox/3.0'),
            array('Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)'),
            array('Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4'),
        );
    }

    /**
     * @dataProvider providerDetectDevice
     * @param string $agent
     * @param string $device
     */
    public function testDetectDevice($agent, $device)
    {
        $this->object->setUserAgent($agent);

        self::assertInstanceOf($device, $this->object->detectDevice());
    }

    public function providerDetectDevice()
    {
        return array(
            array('Mozilla/5.0 (Windows NT 6.3; Win64; x64; Trident/7.0; Touch; rv:11.0) like Gecko', '\BrowserDetector\Detector\Device\GeneralMobile'),
        );
    }

    /**
     * @dataProvider providerGetDeviceType
     *
     * @param string $agent
     * @param string $deviceType
     */
    public function testGetDeviceType($agent, $deviceType)
    {
        self::markTestSkipped('has to be changed');
        $this->object->setUserAgent($agent);

        $device = $this->object->detectDevice();
        $device->detectSpecialProperties();

        self::assertInstanceOf($deviceType, $this->object->getDeviceType());
    }

    public function providerGetDeviceType()
    {
        return array(
            array('Mozilla/5.0 (Windows NT 6.3; Win64; x64; Trident/7.0; Touch; rv:11.0) like Gecko', '\UaDeviceType\Tablet'),
        );
    }

    /**
     * tests that a integer is returned
     */
    public function testGetWeight()
    {
        self::assertInternalType('integer', $this->object->getWeight());
    }
}
