<?php

namespace Edify\Exceptions;
/**
 * Exception raised in the Authorisation factory
 */

/**
 * Description of Auth
 *
 * @author IrishAdo <me@irishado.com>
 */
class Auth extends \Exception{

    protected $severity;

    public function __construct($message, $code=0, $severity=1, $filename=__FILE__, $lineno=__LINE__) {
        $this->message = $message;
        $this->code = $code;
        $this->severity = $severity;
        $this->file = $filename;
        $this->line = $lineno;
    }

    public function getSeverity() {
        return $this->severity;
    }
}

?>
