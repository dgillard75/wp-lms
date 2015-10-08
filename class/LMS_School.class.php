<?php
/**
 * Created by PhpStorm.
 * User: celeb
 * Date: 7/15/15
 * Time: 11:03 AM
 */

include_once(LMS_PLUGIN_PATH."class/LMS_DBFunctions.class.php");

define("IS_AUTH_TYPE_COURSE","BY COURSE");
define("IS_AUTH_TYPE_MODULE","BY MODULE");
define("IS_AUTH_TYPE_UNIT","BY UNIT");

define("LMS_SCHOOL_IS_AUTHORIZED","1");
define("LMS_SCHOOL_NOT_LOGGED_IN","2");
define("LMS_SCHOOL_NOT_AUTHORIZED", "3");


class LMS_School {

    public static $message = array(
        LMS_SCHOOL_IS_AUTHORIZED => "Authorized",
        LMS_SCHOOL_NOT_LOGGED_IN => "You cannot view this unit as you are not logged in.",
        LMS_SCHOOL_NOT_AUTHORIZED => "Sorry, but you're not allowed to access this course."
    );


    protected static function is_course_valid($course_id){
        $course = LMS_DBFunctions::retrieve_course($course_id);
        if(empty($course)){
            return false;
        }

        return true;
    }

    protected static function is_module_valid($course_id, $module_id)
    {
        $row = LMS_DBFunctions::get_course_module_by_id($module_id);
        //LMS_Log::print_r($row);
        if(!empty($row) && $row['course_id']==$course_id){
            return true;
        }
        return false;
    }

    public static function get_lesson_url()
    {
        // Get Lesson Url from Databas, for now hard code
        $lesson_url =  "https://".$_SERVER["HTTP_HOST"]."/school/lessons";
        return $lesson_url;

    }

	public static function get_quiz_url()
	{
		// Get Lesson Url from Databas, for now hard code
		$url = "http://localhost/school/quiz";
		return $url;

	}
    /**
     * @param $student_info
     */
    public static function register($student_info){

    }
    /**
     * @param $user_id
     * @param $who_granted
     * @param $course_id
     * @param string $access_type
     * @param null $module_id_list
     * @return bool|int
     */
    public static function enroll($user_id, $course_id, $who_granted)
    {
        //validate course_id
        if (!self::is_course_valid($course_id)) {
            return false;
        }


        $data[USER_COURSES_TBL_COURSE_ID] = $course_id;
        $data[USER_COURSES_TBL_USER_ID] = $user_id;
        $data[USER_COURSES_TBL_GRANTOR] = $who_granted;
        //LMS_Log::print_r($data);
        $trans_id = LMS_DBFunctions::add_user_course_entry($data);
        if(!$trans_id){
            return false;
        }

        LMS_Log::print_r($trans_id);

        //Add Course and AllModules
        $modules = LMS_DBFunctions::get_course_modules($course_id, true);
        //LMS_Log::print_r($modules);
        foreach ($modules as $m) {

            if(!self::enroll_by_module($user_id, $course_id, $m->module_id,$who_granted,$trans_id)){
                //  **** ADD LOGGING HERE *****/
            }
        }
        return 0;
    }


    /**
     * @param $user_id
     * @param $course_id
     * @param $module_id
     * @param $who_granted
     * @param null $trans_id
     * @return bool
     */
    public static function enroll_by_module($user_id, $course_id, $module_id, $who_granted, $trans_id=NULL)
    {
        //validate course_id
        if (!self::is_course_valid($course_id)) {
            return false;
        }

        //validate
        if (!empty($module_id) && !self::is_module_valid($course_id, $module_id)) {
            return false;
        }

        //Get Transaction ID from User_course table
        if(empty($trans_id)) {
            $user_course = LMS_DBFunctions::get_user_course_by_course($user_id, $course_id);
            $trans_id = $user_course['trans_id'];
        }

        //Grant Access
        $data[USER_MODULES_TBL_TRANS_ID] = $trans_id;
        $data[USER_MODULES_TBL_MODULE_ID] = $module_id;
        $data[USER_MODULES_TBL_GRANTOR] = $who_granted;
        //$data[USER_MODULES_TBL_STATUS] = 1;
        LMS_Log::print_r($data);
        LMS_DBFunctions::add_user_module_entry($data);
        return true;
    }

    /**
     * @param $user_id
     * @param $who_granted
     * @param $course_id
     */
    public static function remove_course($user_id, $who_granted, $course_id){

    }

    public static function is_authorized($user_id, $id, $type=IS_AUTH_TYPE_COURSE){

        if($type == IS_AUTH_TYPE_UNIT){
            $unit = LMS_DBFunctions::retrieve_lesson($id);
            LMS_Log::print_r($unit);
            //get module_id
            $user_course = LMS_DBFunctions::get_user_modules_by_user($user_id, $unit['module_id']);
            if(!empty($user_course))
                return true;
        }

        return false;
    }


    public static function enrolled_in_courses($student_id){
        $user_course = LMS_DBFunctions::get_user_courses($student_id);
        if(!empty($user_course)){
            return true;
        }
        return false;
    }


    public static function check_student_permissions(){
        if ( !is_user_logged_in() ) {
            $code = LMS_SCHOOL_NOT_LOGGED_IN;
        }elseif(!self::enrolled_in_courses(get_current_user_id())) {
            $code = LMS_SCHOOL_NOT_AUTHORIZED;
        }else{
            $code = LMS_SCHOOL_IS_AUTHORIZED;
        }
        return $code;
    }
}