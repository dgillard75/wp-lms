<?php

require_once(WPLMS_PLUGIN_PATH.   "class/LMS_DBFunctions.class.php");
include_once(WPLMS_PLUGIN_PATH.   'class/LMS_School.class.php');
include_once(WPLMS_PLUGIN_PATH.   'class/LMS_FrontEndLessonPage.class.php');


function valid_parameters(){
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        return true;
    }
    return false;
}

function check_prereqs()
{
    $prereqs = array();
    if ( !is_user_logged_in() ) {
        //Check if user is logged in
        $prereqs['error_message'] = "You cannot view this unit as you are not logged in.";
        $prereqs['errors'] = true;
    }elseif( !valid_parameters() ){
        //Check Get Parameters
        $prereqs['error_message'] = "Sorry but this unit is not accessible at this time";
        $prereqs['errors'] = true;
    }elseif(!(LMS_School::is_authorized(get_current_user_id(),$_GET['id'],IS_AUTH_TYPE_UNIT))){
        // Is User Authorized to view Lesson
        $prereqs['error_message'] = "Sorry, but you're not allowed to access this course.";
        $prereqs['errors'] = true;
    }else{
        $prereqs['errors'] = false;
    }

    return $prereqs;
}


$lessons_page_url = "https://".$_SERVER["HTTP_HOST"]."/school/lessons";


$page_pre_reqs = check_prereqs();
$shortcode_attr = array();
if(!$page_pre_reqs['errors']){
    $lessons_page = new LMS_FrontEndLessonPage($_GET['id']);
    $url = "http://householdstafftraining.com/pdf-courses/";
    $shortcode_attr['embed'] = "[embeddoc url=\"".$url.$lessons_page->get_lesson()[LESSONS_TBL_FILENAME]."\" viewer=\"google\"]";
    echo "<pre>".$shortcode_attr['embed']."</pre>";
}
?>


<style>
    <?php include(WPLMS_PLUGIN_PATH."css/wplms_frontend.css"); ?>
</style>

<?php if(!$page_pre_reqs['errors']) : ?>
    <?php echo do_shortcode($shortcode_attr['embed']); ?>
    <div class="wpcw_fe_progress_box_wrap">
        <div class="wpcw_fe_navigation_box">
            <?php if($lessons_page->isPrev()) : ?>
                <a href="<?php echo $lessons_page_url."?id=".$lessons_page->get_previous_lesson()[LESSONS_TBL_ID] ?>" class="fe_btn fe_btn_navigation">« Previous Unit</a>
            <?php endif; ?>
            <?php if($lessons_page->isNext()) : ?>
                <a href="<?php echo $lessons_page_url."?id=".$lessons_page->get_next_lesson()[LESSONS_TBL_ID] ?>"class="fe_btn fe_btn_navigation ">Next Unit »</a>
            <?php endif; ?>
        </div>
    </div>
<?php else : ?>
    <div class="wpcw_fe_progress_box_wrap"><div class="wpcw_fe_progress_box wpcw_fe_progress_box_error"><?php echo $page_pre_reqs['error_message'] ?></div></div>
<?php endif; ?>