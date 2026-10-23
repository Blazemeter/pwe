<?php

namespace PWE\Core;

class CMDLinePWECoreTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var CMDLinePWECore
     */
    protected $object;

    public function testGetNode()
    {
        $this->object = new CMDLinePWECore();
        $this->object->getNode();
    }

}

