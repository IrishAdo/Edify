<?php

/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Object
 *
 * @author IrishAdo <me@irishado.com>
 */
class Obj {

    private $data = null;
    private $template = null;

    function __constructor($data = Array(), $template = null) {
        if (!is_array($data)) {
            throw new \Edify\Exceptions\Model('You must supply data as an array');
        }
        $this->data = $data;
        $this->setTemplate($template);
    }

    function assign($key, $value) {
        \Edify\Utils\Log::Issue("[Edify\View\Obj]", "Adding $key of type ". gettype($value)." to data source for template");
        $this->data[$key] = $value;
    }

    function fetch($template = null) {
        if (!is_null($template)) {
            $this->setTemplate($template);
        }
        \Edify\Utils\Log::Issue("[Edify\View\Obj]", "fetching");
        ob_start();
        $data = $this->data;
        require $this->template;
        $buffer = ob_get_contents();
        ob_clean();
        return $buffer;
    }

    private function setTemplate($template) {
        if (is_null($template)) {
            return 0;
        }
        if (!file_exists($template)) {
            throw new \Edify\Exceptions\Model('Template \'' . $template . '\' not found');
        }
        $this->template = $template;
        return 1;
    }

}

?>
