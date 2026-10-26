<?php

namespace PWE\Core;

use BadFunctionCallException;
use Exception;
use InvalidArgumentException;
use PWE\Exceptions\HTTP4xxException;
use PWE\Exceptions\HTTP5xxException;
use PWE\Modules\MenuGenerator;
use PWE\Modules\Outputable;
use PWE\Modules\PWEModule;
use PWEUnitTests;

require_once __DIR__ . '/../../PWEUnitTests.php';

class PWECoreTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var PWECore
     */
    protected $object;

    protected function setUp(): void
    {
        $this->object = new PWECoreImpl();
        $this->object->setDataDirectory(__DIR__);
        $this->object->setXMLDirectory(__DIR__ . '/coreXML');
        $this->object->setTempDirectory(PWEUnitTests::utGetCleanTMP());
    }

    protected function tearDown(): void
    {

    }

    public function testSetRootDirectory()
    {
        $this->object->setRootDirectory('');
    }

    public function testSetDataDirectory()
    {
        $this->object->setDataDirectory('');
    }

    public function testSetXMLDirectory()
    {
        $this->object->setXMLDirectory('');
    }

    public function testSetTempDirectory()
    {
        $this->object->setTempDirectory('');
    }

    public function testGetDataDirectory()
    {
        $this->object->getDataDirectory();
    }

    public function testGetXMLDirectory()
    {
        $this->object->getDataDirectory();
    }

    public function testGetTempDirectory()
    {
        $this->object->getTempDirectory();
    }

    public function testGetModuleInstance_noParam()
    {
        try {
            $arr = array();
            $this->object->getModuleInstance($arr);
            $this->fail();
        } catch (InvalidArgumentException $e) {

        }
    }

    public function testGetModuleInstance_SingleInstance()
    {
        $mod = $this->object->getModuleInstance("PWE\\Core\\DummyModule");
        $this->assertTrue($mod instanceof PWEModule);
    }

    public function testGetModuleInstance_MultiInstance()
    {
        $node = array();
        $node['!i']['class'] = "PWE\\Core\\DummyModule";
        $node['!a']['src'] = "test.html";
        $mod = $this->object->getModuleInstance($node);
        $this->assertTrue($mod instanceof PWEModule);
    }


    public function testSetURL_RootJTFC()
    {
        try {
            $this->object->process('/');
            throw new \Exception("Exception expected");
        } catch (\RuntimeException $e) {
            $this->assertEquals(302, $e->getMessage());
        }
    }

    public function testSetURL_Page1Success()
    {
        $this->object->process('/test/subnode/');
        $this->assertEquals("/test/subnode:", $this->object->getContent());
    }

    public function testSetURL_Redirect()
    {
        try {
            $this->object->process('/../123/');
            throw new Exception("Exception expected");
        } catch (\RuntimeException $e) {
            $this->assertEquals(301, $e->getMessage());
        }
    }

    public function testSetURL_AcceptParams()
    {
        $this->object->process('/accept/123/');
        $this->assertEquals("/accept:123", $this->object->getContent());
    }

    public function testEmptyTPL()
    {
        $this->object->process('/notpl/');
        $this->assertEquals("/notpl:", $this->object->getContent());
    }

    public function testSetURL_AcceptParamsFile()
    {
        $this->object->process('/accept/text.xml');
        $this->assertEquals("/accept:text.xml", $this->object->getContent());
    }

    public function test_Attr_Inheritance()
    {
        $this->object->process('/inheritance/');
        $this->assertEquals("/inheritance:", $this->object->getContent());
        $node = $this->object->getNode();
        $this->assertEquals("empty.tpl", $node['!i']['template']);
    }

    public function testSetURL_AcceptParamsFile_at_root()
    {
        try {
            $this->object->process('/robots.txt');
            $this->fail();
        } catch (HTTP4xxException $e) {
            if ($e->getCode() != HTTP4xxException::NOT_FOUND) {
                throw $e;
            }
        }
    }

    public function testSetURL_AcceptParamsExceeded()
    {
        try {
            $this->object->process('/accept/123/123/123/');
            $this->fail();
        } catch (HTTP4xxException $e) {
            if ($e->getCode() != HTTP4xxException::NOT_FOUND) {
                throw $e;
            }
        }
    }

    public function testSetURL_Page1FailWithParams()
    {
        try {
            $this->object->process('/test/123/');
            $this->fail();
        } catch (HTTP4xxException $e) {
            if ($e->getCode() != HTTP4xxException::NOT_FOUND) {
                throw $e;
            }
        }
    }

    public function testSetURL_MidParams_JustBase()
    {
        $this->object->process('/midaccept/');
        $node = $this->object->getNode();
        $this->assertArrayNotHasKey('marker', $node['!i']);
        $this->assertEquals("/midaccept:", $this->object->getContent());
    }

    public function testSetURL_MidParams_NotAll()
    {
        $this->object->process('/midaccept/123/');
        $this->assertEquals("/midaccept:123", $this->object->getContent());
    }

    public function testSetURL_MidParams_All()
    {
        $this->object->process('/midaccept/123/456/trailing/');
        $this->assertEquals("/midaccept/trailing:123/456", $this->object->getContent());
    }

    public function testSetURL_MidParamsExceeded()
    {
        try {
            $this->object->process('/midaccept/123/123/123/trailing/');
            $this->fail();
        } catch (HTTP4xxException $e) {
            if ($e->getCode() != HTTP4xxException::NOT_FOUND) {
                throw $e;
            }
        }
    }

    public function testSetURL_Notexistent()
    {
        try {
            $this->object->process('/321/123/');
            $this->fail();
        } catch (HTTP4xxException $e) {
            if ($e->getCode() != HTTP4xxException::NOT_FOUND) {
                throw $e;
            }
        }
    }

    public function testGetURL()
    {
        $this->object->process('/accept/123/');
        $this->object->getURL();
    }

    public function testProcess_JTFC302()
    {
        try {
            $this->object->process('/');
            $this->fail();
        } catch (\RuntimeException $e) {
            $this->assertEquals(302, $e->getMessage());
        }
    }

    public function testProcess_ok()
    {
        $res = $this->object->process('/test/subnode/');
        $this->assertGreaterThan(5000, strlen($res));
    }

    public function testProcess_404()
    {
        try {
            $this->object->process('/test/subnode/404/');
            $this->fail();
        } catch (HTTP4xxException $e) {

        }
    }

    public function test_getHeader()
    {
        $_SERVER['HTTP_TEST_TEST'] = "passed";
        $res = $this->object->getHeader('test-test');
        $this->assertEquals("passed", $res);
    }

    public function testSetDisplayTemplate()
    {
        $this->object->setDisplayTemplate('');
    }

    public function testGetDisplayTemplate()
    {
        $this->object->getDisplayTemplate();
    }

    public function testGetEmptyTemplate()
    {
        $this->object->getEmptyTemplate();
    }

    public function testGetErrorPage_ServerErrorDetailsHiddenFromRemote()
    {
        $html = $this->renderErrorPage(new HTTP5xxException('connection to server at 10.1.2.3 failed'), '192.0.2.1');
        $this->assertStringNotContainsString('10.1.2.3', $html);
        $this->assertStringContainsString('The request could not be completed.', $html);
        $this->assertStringContainsString('500 Internal Server Error', $html);
    }

    public function testGetErrorPage_ServerErrorDetailsShownLocally()
    {
        $html = $this->renderErrorPage(new HTTP5xxException('connection to server at 10.1.2.3 failed'), '127.0.0.1');
        $this->assertStringContainsString('10.1.2.3', $html);
    }

    public function testGetErrorPage_ClientErrorMessageShown()
    {
        $html = $this->renderErrorPage(new HTTP4xxException('Wiki page not found', HTTP4xxException::NOT_FOUND), '192.0.2.1');
        $this->assertStringContainsString('Wiki page not found', $html);
        $this->assertStringContainsString('404', $html);
    }

    public function testGetErrorPage_UnknownCode()
    {
        $html = $this->renderErrorPage(new Exception('internal detail', 7), '192.0.2.1');
        $this->assertStringNotContainsString('internal detail', $html);
    }

    private function renderErrorPage(Exception $e, $remoteAddr)
    {
        $this->object->process('/test/subnode/');
        $saved = $_SERVER;
        $_SERVER['REMOTE_ADDR'] = $remoteAddr;
        $_SERVER['SERVER_ADDR'] = '127.0.0.1';
        try {
            return $this->object->getErrorPage($e);
        } finally {
            $_SERVER = $saved;
        }
    }

}

class PWECoreImpl extends PWECore
{

    public function getModulesManager()
    {
        try {
            return parent::getModulesManager();
        } catch (BadFunctionCallException $e) {
            return null;
        }
    }

    public function sendHTTPStatusCode($code)
    {
        throw new \RuntimeException($code);
    }
}


class DummyModule extends PWEModule implements Outputable, MenuGenerator
{
    public function process()
    {
        $smarty = $this->PWE->getSmarty();
        $smarty->setTemplateFile(__DIR__ . '/flat.tpl');
        $smarty->assign('content', implode('/', $this->PWE->getURL()->getMatchedAsArray()) . ':' . implode('/', $this->PWE->getURL()->getParamsAsArray()));
        $this->PWE->addContent($smarty);
    }

    public function getMenuLevel($level)
    {

    }
}
