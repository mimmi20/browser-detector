<?php
namespace BrowserDetectorTest\Detector\Device\Desktop;

use BrowserDetector\Detector\Device\Desktop\WindowsDesktop;

/**
 * Test class for \BrowserDetector\Detector\Device\WindowsDesktop
 */
class WindowsDesktopTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Device\Desktop\WindowsDesktop
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new WindowsDesktop();
    }

    /**
     * tests that a integer is returned
     */
    public function testGetWeight()
    {
        self::assertInternalType('integer', $this->object->getWeight());
    }
}
