<?php

namespace PWE\Exceptions;

use PWE\Core\PWELogger;

require_once __DIR__ . '/../../PWEUnitTests.php';


class PWEHTTPExceptionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \HTTPException
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new HTTPExceptionImpl("test", 500);
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

class HTTPExceptionImpl extends PWEHTTPException
{

}
