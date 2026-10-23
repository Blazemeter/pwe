<?php

namespace PWE\Modules;

use PWE\Core\UnitTestPWECore;

require_once __DIR__ . '/../../PWEUnitTests.php';

class PWEModulesManagerTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var PWEModulesManager
     */
    protected $object;
    private $pwe;

    protected function setUp(): void
    {
        $this->pwe = new UnitTestPWECore();
        $this->object = $this->pwe->getModulesManager();
    }

    public function testGetModuleSettings()
    {
        $this->object->getModuleSettings(__CLASS__);
    }

    public function testSetModuleSettings()
    {
        $this->object->setModuleSettings(__CLASS__, array('!a' => array('k' => 'v')));
        $settings = $this->object->getModuleSettings(__CLASS__);
        $this->assertEquals('v', $settings['!a']['k']);
    }

    public function testGetSingleInstanceModule()
    {
        $module = $this->object->getSingleInstanceModule(DummyTestModule::class);
        $this->assertInstanceOf(DummyTestModule::class, $module);
        $this->assertSame($this->pwe, $module->getPWE());
    }

    public function testGetMultiInstanceModule()
    {
        $a['!i']['class'] = DummyTestModule::class;
        $this->assertInstanceOf(DummyTestModule::class, $this->object->getMultiInstanceModule($a));
    }

    public function testRun()
    {
        $this->object->run();
    }

    public function testRegister()
    {
        $a['!a']['class'] = __CLASS__;
        $this->object->registerModule(__CLASS__);
    }

}


/** Minimal module for instantiation tests, test case classes cannot be constructed as modules. */
class DummyTestModule extends PWEModule
{
}
