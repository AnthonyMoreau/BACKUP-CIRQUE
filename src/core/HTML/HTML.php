<?php


namespace AppCirque\core\HTML;

use AppCirque\APP\app\AppArray;

class HTML
{

    public function surround_Element($element, $tag = 'div', $attr = []): string
    {
        $x = '';
        $open = $this->Open_Tag($tag, $attr);
        $close = $this->Close_Tag($tag);
        if (is_array($element) && AppArray::array_get_type($element) === 'no_key') {foreach ($element as $value){$x .= $value;} $element = $x;}
        return $open . $element . $close;
    }

    public function Set_Attributes($attr = []): string
    {
        $x = '';
        if(!is_array($attr)){return '';}
        if(AppArray::array_get_type($attr) === 'key'){
            foreach ($attr as $attribute => $value){
                $x .= "$attribute=\"$value\" ";
            }
        }
        return $x;
    }

    public function Open_Tag($tag = 'div', $attr = []): string
    {
        $x = '';
        if (!empty($attr)){
            $x = $this->Set_Attributes($attr);
        }
        if(!is_string($tag) || empty($tag)){
            $tag = 'div';
        }
        if(!empty($x)){return "<$tag $x>";}
        return "<$tag>";

    }

    public function Close_Tag($tag = 'div'): string
    {
        if(!is_string($tag)){
            $tag = 'div';
        }
        return "</$tag>";
    }

}

