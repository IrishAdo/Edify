<?php

namespace Edify\Utils;

/**
 * Series of functions designed to check if a value is of a specific type
 * mostly used to protect your application from invlaid data.
 */

/**
 * Sanitise your data
 *
 * @author IrishAdo <me@irishado.com>
 */
class Sanitise {

    /**
     * IsNatural the parameter a natural number
     *
     * A natural number is a whole number an Integer
     *
     * @param type $val
     * @param type $acceptzero
     * @return int
     * @author ja at krystof dot org (php.net manual)
     */
    function isNatural($val) {
        $return = ((string) $val === (string) (int) $val);
        if (!$return || (filter_var($val,FILTER_VALIDATE_INT) === false)){
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a natural whole number - 00000001");
        }
        return (int) $val;
    }

    /**
     * isText is used to test if a value is a string or not it strips tags from
     * the buffer as that would be HTML
     *
     * @throw Edify\Exception\Sanitise
     * @param type $val
     * @param type $maxLength
     * @return String
     */
    function isText($val, $maxLength = -1) {
        if (!is_string($val)) {
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a String - 00000002");
        }
        if ($maxLength!=-1 && strlen($val) > $maxLength) {
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a String - 00000003");
        }
        return (string) strip_tags($val);
    }


    /**
     * isHTML does exactly the same as isText except that it does not strip tags from the buffer
     *
     * @throw Edify\Exception\Sanitise
     * @param type $val
     * @param type $maxLength
     * @return String
     */
    function isHTML($val, $maxLength = -1) {
        if (!is_string($val)) {
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a String - 00000004");
        }
        if ($maxLength!=-1 && strlen($val) > $maxLength) {
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a String - 00000005");
        }
        return (string) $val;
    }
    /**
     * Is the parameter a real number
     *
     * A real number can have decimal places but no punctation or symbols
     *
     * @param type $val
     * @return float
     * @author ja at krystof dot org (php.net manual)
     */
    function isReal($val) {
        $return = ((string) $val === (string) (float) ($val));

        if($val!== "0" && floatval($val)==(float)0){
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a real number - 00000006");
        }
        // the example 123.40 when passed to floatval becomes 123.4
        if (!$return && floatval($val)==(float)0){
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a real number - 00000007");
        }
        return (float) $val;
    }

    /**
     * Is the parameter a GUID.
     *
     * A GUID number is a HEXIDECIMAL number made up of 5 parts seperated by hypens
     *
     * a 8 character String
     * a 4 character String
     * a 4 character String
     * a 4 character String
     * a 12 character String
     *
     * @param type $val
     * @return float
     * @author ja at krystof dot org (php.net manual)
     */
    function isGUID($val) {
        if(preg_match('/([0-9A-F]{8})\-([0-9A-F]{4})\-([0-9A-F]{4})\-([0-9A-F]{4})\-([0-9A-F]{12})/', $val)===false){
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a GUID - 00000008");
        }

        return (string) $val;
    }

    /**
     * check if a string is an email address
     * @param type $val
     * @return type String
     * @throws \Edify\Exceptions\Sanitise
     */
    function isEmail($val){
        $validAddress = filter_var($val, FILTER_VALIDATE_EMAIL);

        if($val!== $validAddress){
            throw new \Edify\Exceptions\Sanitise("Value supplied is not a Email - 00000009");
        }

        return (string) $validAddress;
    }
}

?>
