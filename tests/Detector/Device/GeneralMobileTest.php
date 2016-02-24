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
        self::markTestSkipped('need to be changed');

        $this->object = new GeneralMobile();
    }

    /**
     * @dataProvider providerDetectDevice
     *
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
        return [
            ['Mozilla/5.0 (Windows NT 6.3; Win64; x64; Trident/7.0; Touch; rv:11.0) like Gecko', '\BrowserDetector\Detector\Device\GeneralMobile'],
        ];
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
        return [
            ['Mozilla/5.0 (Windows NT 6.3; Win64; x64; Trident/7.0; Touch; rv:11.0) like Gecko', '\UaDeviceType\Tablet'],
        ];
    }
}
