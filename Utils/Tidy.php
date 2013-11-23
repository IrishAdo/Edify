<?php

namespace Edify\Utils;
/**
 * A wrapper class for the php tidy function. This class defines a default configuration.
 */

/**
 * A wrapper for the php tidy function which will fix html content.
 *
 * @author IrishAdo <irishado@php-programmers.net>
 */
class Tidy {

/**
 * basic configuration options for tidy function.
 * @access private
 * @var type 
 */
    private $config = array(
        'show-body-only' => true,
        'clean' => true,
        'char-encoding' => 'utf8',
        'add-xml-decl' => true,
        'add-xml-space' => true,
        'output-html' => false,
        'output-xml' => false,
        'output-xhtml' => true,
        'numeric-entities' => false,
        'ascii-chars' => false,
        'doctype' => 'strict',
        'bare' => true,
        'fix-uri' => true,
        'indent' => true,
        'indent-spaces' => 4,
        'tab-size' => 4,
        'wrap-attributes' => true,
        'wrap' => 0,
        'indent-attributes' => true,
        'join-classes' => false,
        'join-styles' => false,
        'enclose-block-text' => true,
        'fix-bad-comments' => true,
        'fix-backslash' => true,
        'replace-color' => false,
        'wrap-asp' => false,
        'wrap-jste' => false,
        'wrap-php' => false,
        'write-back' => true,
        'drop-proprietary-attributes' => true,
        'hide-comments' => false,
        'hide-endtags' => false,
        'literal-attributes' => false,
        'drop-empty-paras' => true,
        'enclose-text' => true,
        'quote-ampersand' => true,
        'quote-marks' => false,
        'quote-nbsp' => true,
        'vertical-space' => true,
        'wrap-script-literals' => false,
        'tidy-mark' => true,
        'merge-divs' => false,
        'repeated-attributes' => 'keep-last',
        'break-before-br' => true,
    );

    /**
     * getter function to return a configuration value
     *
     * @param String $name
     * @return type
     */
    public function __get($name) {
        return $this->config[$config];
    }

    /**
     * setter function
     * @param String $name
     * @param mixed $value
     */
    public function __set($name, $value) {
        $this->config[$config] = $value;
    }

    /**
     * get the default configuration 
     * 
     * @return Array
     */
    public function getConfig() {
        return $this->config;
    }

    /**
     * replace the default configuration.
     * 
     * @param type $config
     */
    public function setConfig($config) {
        $this->config = $config;
    }

    /**
     * Clean a html buffer.
     * 
     * @param String $what_to_clean
     * @param Array $tidy_config
     * @return String
     */
    function clean($what_to_clean, $tidy_config = '') {
        if ($tidy_config == '') {
            $tidy_config = &$this->config;
        }

        $tidy = new \tidy();
        $out = $tidy->repairString($what_to_clean, $tidy_config, 'UTF8');
        unset($tidy);
        unset($tidy_config);
        return $out;
    }

}

?>
