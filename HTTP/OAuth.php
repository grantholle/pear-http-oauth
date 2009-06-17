<?php
/**
 * HTTP_OAuth
 *
 * PHP version 5.2.0+
 *
 * LICENSE: This source file is subject to the New BSD license that is
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/bsd-license.php. If you did not receive  
 * a copy of the New BSD License and are unable to obtain it through the web, 
 * please send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  HTTP
 * @package   HTTP_OAuth
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com> 
 * @copyright 2009 Jeff Hodsdon <jeffhodsdon@gmail.com> 
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://pear.php.net/package/HTTP_OAuth_Provider
 * @link      http://github.com/jeffhodsdon/HTTP_OAuth_Provider
 */

/**
 * HTTP_OAuth 
 * 
 * Main HTTP_OAuth class. Contains help encoding methods.
 *
 * @category  HTTP
 * @package   HTTP_OAuth
 * @copyright 2009 Jeff Hodsdon <jeffhodsdon@gmail.com> 
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com> 
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class HTTP_OAuth
{

    /**
     * Build HTTP Query 
     * 
     * @param array $params Name => value array of parameters
     *
     * @return string HTTP query
     */
    static public function buildHTTPQuery(array $params)
    {
        if (empty($params)) {
            return '';
        }

        $keys   = self::urlencode(array_keys($params));
        $values = self::urlencode(array_values($params));
        $params = array_combine($keys, $values);

        uksort($params, 'strcmp');

        $pairs = array();
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                natsort($value);
                foreach ($value as $dupe) {
                    $pairs[] = $key . '=' . $dupe;
                }

                continue;
            }

            $pairs[] =  $key . '=' . $value;
        }

        return implode('&', $pairs);
    }

    /**
     * URL Encode 
     * 
     * @param mixed $item string or array of items to url encode
     *
     * @return mixed url encoded string or array of strings
     */
    static public function urlencode($item)
    {
        static $search  = array('+', '%7E');
        static $replace = array(' ', '~');

        if (is_array($item)) {
            return array_map(array('HTTP_OAuth', 'urlencode'), $item);
        }

        if (is_scalar($item) === false) {
            throw new HTTP_OAuth_Exception;
        }

        return str_replace($search, $replace, rawurlencode($item));
    }

    /**
     * URL Decode 
     * 
     * @param string $string String to url decode
     *
     * @return string URL decoded string
     */
    static public function urldecode($string)
    {
        return urldecode($string);
    }

}

?>