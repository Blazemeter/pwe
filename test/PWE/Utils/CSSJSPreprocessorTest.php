<?php
namespace PWE\Utils;


use PWE\Core\PWELogger;
use PWE\Core\UnitTestPWECore;

class CSSJSPreprocessorTest extends \PHPUnit\Framework\TestCase
{
    public function testProcess()
    {
        $pwe = new UnitTestPWECore();
        copy(__DIR__ . '/preprocess.tpl', $pwe->getTempDirectory() . '/test.tpl');

        $obj = new CSSJSPreprocessor($pwe);
        $obj->preprocess($pwe->getTempDirectory(), $pwe->getTempDirectory());

        $test_tpl = file_get_contents($pwe->getTempDirectory() . '/test.tpl');
        $pwe_js = file_get_contents($pwe->getTempDirectory() . '/pwe.js');
        $pwe_css = file_get_contents($pwe->getTempDirectory() . '/pwe.css');

        PWELogger::debug("TPL: $test_tpl");
        PWELogger::debug("JS: $pwe_js");
        PWELogger::debug("CSS: $pwe_css");

        $this->assertStringContainsString("do_process_css", $pwe_css);
        $this->assertStringNotContainsString("not_process_css", $pwe_css);
        $this->assertStringContainsString("not_process_css", $test_tpl);
        $this->assertStringNotContainsString("do_process_css", $test_tpl);

        $this->assertStringContainsString("do_process_js", $pwe_js);
        $this->assertStringNotContainsString("not_process_js", $pwe_js);
        $this->assertStringContainsString("not_process_js", $test_tpl);
        $this->assertStringNotContainsString("do_process_js", $test_tpl);
    }

}
 