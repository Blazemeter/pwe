<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;

use PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax\Table;

class TableTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var Table
     */
    protected $object;

    protected function setUp(): void
    {
        $this->object = new TableEmul(new \WikiRenderer());
    }

    public function testOpen()
    {
        $this->object->open();
    }

    public function testGetRenderedLine()
    {
        $this->object->detect("|| *Pragma*   || *Value*  ||");
        $this->object->getRenderedLine();
    }

}

class TableEmul extends Table
{

    public function detect($string, $inBlock = false)
    {
        $this->_detectMatch = array($string);
    }

}