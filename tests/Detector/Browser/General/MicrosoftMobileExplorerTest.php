<?php
namespace BrowserDetectorTest\Detector\Browser\General;

use BrowserDetector\Detector\Browser\General\MicrosoftMobileExplorer;

/**
 * Test class for \BrowserDetector\Detector\Browser\General\AppleMail
 */
class MicrosoftMobileExplorerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Browser\General\AppleMail
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new MicrosoftMobileExplorer();
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
            array('Mozilla/5.0 (Mobile; Windows Phone 8.1; Android 4.0; ARM; Trident/7.0; Touch; rv:11.0; IEMobile/11.0; Microsoft; Lumia 535) like iPhone OS 7_0_3 Mac OS X AppleWebKit/537 (KHTML, like Gecko) Mobile Safari/537'),
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
            array('Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile'),
            array('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/538.1 (KHTML, like Gecko) crawler Safari/538.1'),
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
