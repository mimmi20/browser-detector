<?php
namespace BrowserDetectorTest\Detector\Os;

use BrowserDetector\Detector\Browser\FakeBrowser;

/**
 * Test class for \BrowserDetector\Detector\Browser\FakeBrowser
 */
class FakeBrowserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BrowserDetector\Detector\Browser\FakeBrowser
     */
    private $object = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->object = new FakeBrowser();
    }

    /**
     * tests that a integer is returned
     */
    public function testGetWeight()
    {
        self::assertInternalType('integer', $this->object->getWeight());
    }
}
