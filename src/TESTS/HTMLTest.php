<?php

use PHPUnit\Framework\TestCase;
use AppCirque\core\HTML\HTML;

require '../vendor/autoload.php';

class HTMLTest extends TestCase {

    public function test_open_tag_validation(): void
    {
        $attr = ['class' => 'test'];
        $this->assertEquals('<p class="test" >', (new HTML)->open_tag('p', $attr));
    }

    public function test_Close_tag_With_Not_String(): void
    {
        $this->assertEquals('</div>', (new HTML)->Close_Tag(125));
    }

    public function test_set_attr_valid(): void
    {
        $attr = [
            'class' => 'test other class',
            'id' => 'test-id'
        ];
        $this->assertEquals('class="test other class" id="test-id" ', (new HTML)->Set_Attributes($attr));
    }

    public function test_set_attr_no_valid(): void
    {
        $attr = [
            'test other class',
            'test-id'
        ];
        $attrib = 'test errors';
        $this->assertEquals('', (new HTML)->Set_Attributes($attrib));
    }

    public function test_surround_with_string(): void
    {
        $this->assertEquals('<div>element</div>', (new HTML)->surround_Element('element'));
    }

    public function test_surround_with_string_and_attr(): void
    {
        $this->assertEquals('<div class="ma-class" >element</div>', (new HTML)->surround_Element('element', 'div', ['class' => 'ma-class']));
    }

    public function test_surround_with_tab_and_attr(): void
    {
        $element = [
            (new HTML)->surround_Element('element', 'p'),
            (new HTML)->surround_Element('element', 'p')
        ];
        $this->assertEquals('<div class="ma-class" ><p>element</p><p>element</p></div>', (new HTML)->surround_Element($element, 'div', ['class' => 'ma-class']));
    }

}

