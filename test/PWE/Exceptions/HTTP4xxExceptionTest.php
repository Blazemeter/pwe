<?php

namespace PWE\Exceptions;

use PWE\Core\PWELogger;

require_once __DIR__ . '/../../PWEUnitTests.php';


class HTTP4xxExceptionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var HTTP4xxException
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new HTTP4xxException("test");
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {

    }

    public function testInst()
    {
        PWELogger::debug("done");
    }

}
