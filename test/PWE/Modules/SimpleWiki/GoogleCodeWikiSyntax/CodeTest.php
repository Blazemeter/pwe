<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;

class CodeTest extends \PHPUnit\Framework\TestCase
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
        $res = $this->object->render("[[[python\nprint(1+varname)\n]]]");
        $this->assertStringContainsString("<style ", $res);
        $this->assertStringContainsString("print", $res);
        $this->assertStringContainsString("<pre", $res);
        $this->assertStringContainsString(".python", $res);
    }

}
