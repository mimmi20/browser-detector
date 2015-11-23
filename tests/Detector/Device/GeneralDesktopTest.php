<?php
namespace BrowserDetectorTest\Detector\Device;

use BrowserDetector\Detector\Device\GeneralDesktop;

/**
 * Test class for \BrowserDetector\Detector\Device\GeneralDesktop
 */
class GeneralDesktopTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Device\GeneralDesktop
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new GeneralDesktop();
    }

    /**
     * tests that a integer is returned
     */
    public function testGetWeight()
    {
        self::assertInternalType('integer', $this->object->getWeight());
    }
}
