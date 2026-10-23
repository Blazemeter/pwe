<?php

namespace PWE\Utils;

require_once __DIR__ . '/../../PWEUnitTests.php';

class PWEXMLFunctionsTest extends \PHPUnit\Framework\TestCase
{

    public function testFindNodeWithAttributeValue()
    {
        $nodes = array(
            array('!a' => array()),
            array('!a' => array('name' => "val")),
            array('!a' => array('name' => "val")),
        );
        $this->assertEquals(-1, PWEXMLFunctions:: findNodeWithAttributeValue($nodes, 'test', 'test'));
        $this->assertEquals(1, PWEXMLFunctions:: findNodeWithAttributeValue($nodes, 'name', 'val'));
        $this->assertEquals(0, PWEXMLFunctions:: findNodeWithAttributeValue($nodes, 'name', ''));
        $this->assertEquals(0, PWEXMLFunctions:: findNodeWithAttributeValue($nodes, 'name', null));
    }

}

