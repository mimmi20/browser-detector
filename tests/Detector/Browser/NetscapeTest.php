<?php
namespace BrowserDetectorTest\Detector\Browser;

use BrowserDetector\Detector\Browser\Netscape;

/**
 * Test class for \BrowserDetector\Detector\Browser\Netscape
 */
class NetscapeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Browser\Netscape
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new Netscape();
    }

    /**
     * tests that a integer is returned
     */
    public function testGetWeight()
    {
        self::assertInternalType('integer', $this->object->getWeight());
    }
}
