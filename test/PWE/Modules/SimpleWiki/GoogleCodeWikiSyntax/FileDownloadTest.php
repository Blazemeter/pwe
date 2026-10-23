<?php

namespace PWE\Modules\SimpleWiki\GoogleCodeWikiSyntax;


class FileDownloadTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var \WikiRenderer
     */
    protected $object;

    protected function setUp(): void
    {
        $cnf = new Config();
        $pwe = new \PWE\Core\UnitTestPWECore();
        $pwe->setXMLDirectory(__DIR__);
        $cnf->setPWE($pwe);
        $pwe->setURL('/');
        $this->object = new \WikiRenderer($cnf);
    }

    public function testGetRenderedLine_anchored()
    {
        $res = $this->object->render("<download:test.txt;some descr>");
        //$this->assertEquals('', $res);
    }

}
