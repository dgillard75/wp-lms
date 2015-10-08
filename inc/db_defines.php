<?php
/**
 * Created by PhpStorm.
 * User: celeb
 * Date: 5/29/15
 * Time: 12:05 PM
 */

// Courses
define("COURSES_TABLE","wp_lms_course");
define("COURSES_TBL_COURSE_ID","course_id");
define("COURSES_TBL_CNAME","course_title");
define("COURSES_TBL_CIMG","course_img");
define("COURSES_TBL_DESC","course_desc");
define("COURSES_TBL_STATUS","status");
define("COURSES_TBL_ORD","tbl_order");




//Lessons Table
define("LESSONS_TABLE","wp_lms_lessons");
define("LESSONS_TBL_ID","id");
define("LESSONS_TBL_NAME","name");
define("LESSONS_TBL_COURSE_ID","course_id");
define("LESSONS_TBL_FILENAME","fname");
define("LESSONS_TBL_MODULE_ID","module_id");
define("LESSONS_TBL_UNIT_NUMBER","unit_number");


//Define Types for various random DB queries.
define("BY_TRANS_ID",  "tid");
define("BY_USER_ID",  "uid");
define("BY_MODULE_ID","mid");
define("BY_COURSE_ID","cid");


class ReturnCodes{
    const ALREADY_EXIST = -2;
    const FAIL = 0;
    const SUCCESS = 1;
}

?>