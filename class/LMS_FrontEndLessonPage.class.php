<?php
/**
 * Created by PhpStorm.
 * User: celeb
 * Date: 7/17/15
 * Time: 9:52 AM
 */

class LMS_FrontEndLessonPage {

    //lessonObj;

    protected $lesson_data;
    protected $prev_lesson;
    protected $next_lesson;

    public function LMS_FrontEndLessonPage($lesson_id){
        $this->init($lesson_id);
    }

    protected function init($lesson_id){
        $this->lesson_data = LMS_DBFunctions::retrieve_lesson($lesson_id);
        if(!empty($this->lesson_data)){
            $all_lessons = LMS_DBFunctions::retrieve_lesson_by_module($this->lesson_data[LESSONS_TBL_MODULE_ID]);
            for($i=0; $i < count($all_lessons); $i++){
                if($all_lessons[$i]['id'] != $lesson_id)
                    continue;

                //At this point we have reached the current lesson, now lets set Prev and Next
                //Previous can only be set if not at beginning.
                if($i!=0){
                    $this->prev_lesson = $all_lessons[$i-1];
                }

                //Next can only be set if we not at the end.
                if(($i+1) != count($all_lessons)){
                    $this->next_lesson = $all_lessons[$i+1];
                }
            }
        }
    }

    public function isPrev(){
        if(!empty($this->prev_lesson))
            return true;
        return false;
    }

    public function isNext(){
        if(!empty($this->next_lesson))
            return true;
        return false;
    }

    public function get_previous_lesson(){
        return $this->prev_lesson;
    }

    public function get_next_lesson(){
        return $this->next_lesson;
    }

    public function get_lesson(){
        return $this->lesson_data;
    }

    public static function showError($error){


    }

    public function print_r(){
        LMS_Log::print_r($this->prev_lesson,__FUNCTION__,  "Previous Lesson");
        LMS_Log::print_r($this->lesson_data,__FUNCTION__,"Current Lesson");
        LMS_Log::print_r($this->next_lesson,__FUNCTION__,"Next Lesson");
    }
}