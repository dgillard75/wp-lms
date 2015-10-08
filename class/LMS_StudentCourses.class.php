<?php
/**
 * Created by PhpStorm.
 * User: celeb
 * Date: 7/16/15
 * Time: 12:47 PM
 */

include_once(LMS_PLUGIN_PATH.'class/LMS_DBFunctions.class.php');
include_once(LMS_PLUGIN_PATH . 'class/LMS_StudentCourseList.class.php');

class LMS_StudentCourses {

    protected $student_course_list;

    public function LMS_StudentCourses($uid){
        $this->load($uid);
    }

    public function load($sid){
        $usercourses = LMS_DBFunctions::get_user_courses($sid);

        for($i=0; $i < count($usercourses); $i++){
            $usercourseArr = get_object_vars($usercourses[$i]);
            $sc = new StudentCourseList();
            $sc->addCourse($usercourseArr);
            $this->student_course_list[] = $sc;
        }
        //LMS_Log::print_r($this->student_course_list);
    }

    public function getCourses(){ return $this->student_course_list;}


    public function getCount(){
        return count($this->student_course_list);
    }

}