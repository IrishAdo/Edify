<?php
namespace \Edify\Auth;
/**
 * NTLM Authentication is a version of single signin.
 * By logging into your computer you are tellign your computer I am this
 * person.  In a corporate environment this is handy as a local "intranet"
 * could then say I will allow a computer to tell me that it trusts this person
 * then the intranet can say well you are logged on to our network already so
 * I will trust that you are this person.
 *
 * Browsers will send your username automatically on a local network for this
 * purpose.
 */

/**
 * Description of Ntlm
 *
 * @author IrishAdo <me@irishado.com>
 */
class Ntlm {

    private $parentFactory = null;

    /**
     * The constructor for a driver for the cache factory.
     *
     * @param Edify\Cache\Factory $parentFactory
     */
    function __construct($parentFactory){
        $this->parentFactory = $parentFactory;
    }
    

    function login($username=null,$password=null){

    }
}

?>
