<?php

namespace Edify\Utils;
/**
 * GUID Tools
 */

/**
 * A GUID class for functions based around the production of GUID strings
 *
 * @author IrishAdo <irishado@hotmail.com>
 */
class Guid {
    /**
     * create a new GUID
     * @param ProjectName
     * @return String a Unique GUID string
     */
    function create($ProjectName, $wrap = true) {
        $guid = '';
        $uid = uniqid("", true);
        $data = $ProjectName;
        $data .= $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['SERVER_ADDR'];
        $data .= $_SERVER['SERVER_PORT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = ($wrap?'{':'') .
                substr($hash, 0, 8) .
                '-' .
                substr($hash, 8, 4) .
                '-' .
                substr($hash, 12, 4) .
                '-' .
                substr($hash, 16, 4) .
                '-' .
                substr($hash, 20, 12) .
                ($wrap?'}':'');
        return $guid;
    }
}

?>
