<?php
/**
 * Created by PhpStorm.
 * User: celeb
 * Date: 4/28/15
 * Time: 9:20 AM
 */


/**
 * Class LMS_PageFunctions
 *
 */
class LMS_PageFunctions{
    /**
     * Returns the admin full page url when provided with the right args.
     *
     * @param $whichPage
     * @param bool $isSSL
     * @return string
     */
    public static function getAdminUrlPage($whichPage, $isSSL = false)
    {
        if ($isSSL)
            $_url = "https://";
        else
            $_url = "http://";

        list($real_uri, $query_string) = explode("?", $_SERVER['REQUEST_URI']);
        $_url .= $_SERVER['HTTP_HOST'] . $real_uri . "?" . $whichPage;
        return $_url;
    }

    public static function debugPrint($msg){
        echo "<pre>". $msg ."</pre>";
    }

    public static function hasFormBeenSubmitted(){
        return ($_SERVER['REQUEST_METHOD'] == 'POST');
    }


/*
    public static function students_home_url()
    {
        return self::getAdminUrlPage(STUDENTS_ADMIN_PAGE,is_SSL());
    }
*/
}
?>