<?php

namespace Edify\Auth;

/**
 * Authentication factory module that will use some basic drivers to specify how
 * the authorisation will work whether the system needs to extract information
 * via NTLM, LDAP, FORM or OpenId
 *
 * The idea is that you can specify the type of driver to use for one application
 * lets say NTLM then you are asked to make the site accessable from the with a
 * login/register system.   by specifying which driver you are saying that the
 * factory gets the details of who you are through the drivers prefered source.
 *
 * The Factory then calls the correct class which is project specific and passes
 * the details as supplied by the driver to a validate function in the callback
 * class that then validates the user.
 *
 * @author IrishAdo <me@irishado.com>
 */
class Factory {
    /**
     * define the constant NTLM so that Intellisense will pick up the string.
     */

    Const NTLM = "\\Edify\\Auth\\Ntlm";
    /**
     * define the constant LDAP so that Intellisense will pick up the string.
     */
    Const LDAP = "\\Edify\\Auth\\Ldap";
    /**
     * define the constant OPENID so that Intellisense will pick up the string.
     */
    Const OPENID = "\\Edify\\Auth\\Openid";
    /**
     * define the constant FORM so that Intellisense will pick up the string.
     */
    Const FORM = "\\Edify\\Auth\\Form";

    private $driver = null;
    private $factoryType = null;
    private $isLoggedIn = false;

    //put your code here

    function __construct($driver) {
        $this->factoryType = $driver;
        $this->isLoggedIn = false;
        try {
            $this->driver = new $driver($this);
        } catch (Execption $e) {
            throw new \Edify\Exceptions\Auth("Unsupported driver $driver");
        }
    }

    function isLoggedIn() {
        return $this->isLoggedIn;
    }

    function getUserName() {
        if ($this->isLoggedIn()) {
            return $this->UserName;
        }
        throw new \Edify\Exceptions\Auth("No user is logged in.  Check with the \\edify\\Auth\\Factory->isLoggedIn() function first");
    }

    /**
     * the login function takes two parameters
     *
     * @param Mixed $username
     * @param Mixed $password
     */
    function login($username=null,$password=null){
        if ($this->isLoggedIn()===false) {
            if (\Edify\Auth\Factory::FORM == $this->factoryType){
                $this->driver->login($username,$password);
            } else {
                $this->driver->login($username,null);

            }
        } else {

        }
    }

}

?>
