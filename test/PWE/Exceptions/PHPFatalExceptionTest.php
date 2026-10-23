<?php

namespace PWE\Exceptions;

require_once __DIR__ . '/../../PWEUnitTests.php';


class PHPFatalExceptionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var PHPFatalException
     */
    protected $object;

    protected function setUp(): void
    {
        $this->object = PHPFatalException::activate();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
        restore_error_handler();
    }

    /**
     * @todo Implement test__toString().
     */
    public function test__toString()
    {
        try {
            trigger_error('test warning', E_USER_WARNING);
            $this->fail('Warning was not converted to PHPFatalException');
        } catch (PHPFatalException $e) {
            $this->assertStringContainsString('test warning', $e->__toString());
        }
    }

    /**
     * @todo Implement testErrorHandler().
     */
    public function testErrorHandler()
    {
        try {
            /** @noinspection PhpParamsInspection */
            PHPFatalException::errorHandler("-1", "Test", "file", 59); # intended to be wrong
        } catch (PHPFatalException $e) {
            echo("Caught: " . $e->__toString());
        }
    }

}
