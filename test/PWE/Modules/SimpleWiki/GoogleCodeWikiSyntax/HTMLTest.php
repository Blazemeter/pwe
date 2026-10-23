<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;

class HTMLTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \WikiRenderer
     */
    protected $object;

    protected function setUp(): void
    {
        $this->object = new \WikiRenderer(new Config());
    }

    public function testGetRenderedLine_anchored()
    {
        $res = $this->object->render('<i><font color=gray size="1">Nov 4, 2010</font></i>');
        $this->assertEquals('<p><i><font color=gray size="1">Nov 4, 2010</font></i></p>', $res);
    }

}
