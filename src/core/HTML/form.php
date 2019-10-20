<?php


namespace AppCirque\core\HTML;

class form extends HTML
{

    /**
     * Ouvre le formulaire
     * @param $action
     * @param string $class
     * @param string $method
     * @param $enctype
     */
    public function open_form($action, $class = '', $method = 'POST', $enctype = ""): void
    {
        $attr = [
            'method' => (string)$method,
            'action' => (string)$action,
            'class' => (string)$class,
            'enctype' => (string)$enctype
        ];
        echo $this->Open_tag('form', $attr);
    }

    /**
     * Ferme le formulaire
     */
    public function close_form(): void
    {
        echo '</form>';
    }

    /**
     * @param $name
     * @param $type
     * @param $label
     * @param bool $required
     * @param array $attr
     * @return string
     */
    public function input($name, $type, $label, $required = false, $attr = []): string
    {
        $value = $_POST[$name] ?? '';

        if($required === true){
            $attr ['class']= 'input-form-control required';
        }
        echo $this->create_label($name, $label);

        $x = ($required) ? 'required=true' : '';

        $x = '<input type="' . $type . '" name="' . $name . '" ' . $this->Set_Attributes($attr) . ' value="' . $value . '" '. $x .'>';

        return $x;
    }

    /**
     * @param $value
     * @param array $attr
     * @return string
     */
    public function submit($value, $attr = []): string
    {
        $x = '<input type="submit" value="'. $value .'" name="'. $value .'" '. $this->Set_Attributes($attr) . '>';
        return $x;
    }

    /**
     * @param $name
     * @param $label
     * @param string $value
     * @param bool $required
     * @param array $attr
     * @param int $rows
     * @param int $col
     * @param string $maxlength
     * @return string
     */
    public function text_area($name, $label, $value = '', $required = false, $attr = [], $rows = 10, $col = 30, $maxlength = ""): string
    {
        $t = $_POST[$name] ?? '';
        $value = (!empty($value)) ? $value : $t;
        $z = (!empty($maxlength)) ? "maxlength=$maxlength" : '';
        $x = ($required) ? 'required' : '';

        echo $this->create_label($name, $label);

        $q = '<textarea name="'. $name .'" cols="'. $col .'" rows="'. $rows .'" '. $this->Set_Attributes($attr) . $z . $x .'>'. $value .'</textarea>';

        return $q;
    }

//-----------------------------------------------------------------------------------------------

    /**
     * @param $name
     * @param $label
     * @return string
     */
    private function create_label($name, $label): string
    {
        return '<label for="' . $name . '" class="' . $name . '">' . $label . '</label>';
    }
}