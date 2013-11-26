<?php
namespace \Edify\Auth\Drivers;
/**
 * Forms Authentication is when you require a ser to fill in a form on a web
 * page to gain access to yoru system.
 *
 * @author IrishAdo <me@irishado.com>
 */
class Forms {
    
    /**
     * Retrieve a list of user authentication details
     * @return Array();
     */
    function getDetails(){
        return $_REQUEST;
    }
}

?>
