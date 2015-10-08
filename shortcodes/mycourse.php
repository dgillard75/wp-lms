<?php

include_once(WPLMS_PLUGIN_PATH .    'class/LMS_StudentCourseList.class.php');
include_once(WPLMS_PLUGIN_PATH.     'class/LMS_StudentCourses.class.php');
include_once(WPLMS_PLUGIN_PATH.     'class/LMS_School.class.php');

$permissions = LMS_School::check_student_permissions();
?>

    <br>
    <style>
        <?php include(WPLMS_PLUGIN_PATH."css/wplms_frontend.css"); ?>
    </style>

    <script>
        <?php include(WPLMS_PLUGIN_PATH."js/wpcw_front.js"); ?>
    </script>

<?php if($permissions == LMS_SCHOOL_IS_AUTHORIZED) :
    $student_courses = new LMS_StudentCourses(get_current_user_id());
    $list_of_courses = $student_courses->getCourses();
	//LMS_Log::print_r($list_of_courses);

	?>
    <table id="wpcw_fe_course_progress" class="wpcw_fe_table wpcw_fe_summary_course_progress table">
        <thead>
        <tr><th class="wpcw_fe_course_progress_course">Course</th></tr>
        </thead>
        <tbody>

        <!-- Course Row -->
        <?php for($i=0; $i < count($list_of_courses); $i++) : $course = $list_of_courses[$i]->getCourse(); ?>
            <tr class="wpcw_fe_course_progress_row">
                <td class="wpcw_fe_course_progress_course">
                    <a href="#" data-toggle="<?php echo "wpcw_fe_course_progress_detail_".$course['course_id'] ?>"><?php echo $course['course_title'] ?></a>
                </td>
            </tr>
            <!-- Start of List of Modules -->
            <?php
            $modules = $list_of_courses[$i]->getListOfModules();
            for($j=0; $j < count($modules); $j++) :
                $moduleNumber = $j + 1;
                $idName = "wpcw_fe_module_group_" . $moduleNumber;

                ?>
                <tr>
                <td class="wpcw_fe_course_progress_detail" id="<?php echo "wpcw_fe_course_progress_detail_".$course['course_id'] ?>" colspan="1">
                    <table id="wpcw_fe_course" class="wpcw_fe_table" cellspacing="0" cellborder="0">
                        <tr class="wpcw_fe_module " id="<?php echo $idName ?>">
                            <td>Module <?php echo $j+1 ?></td>
                            <td colspan="2"><?php echo $modules[$j]['module_name'] ?></td>
	                        <td>Status:</td>
                        </tr>
                        <!-- Start of List Of Units -->
                        <?php
                        $lessons = $modules[$j]['lessons'];
                        LMS_Log::print_r($modules[$j]);
                        for($k=0; $k < count($lessons); $k++) :
                            $trClassName = "wpcw_fe_unit wpcw_fe_unit_pending wpcw_fe_module_group_".$moduleNumber;
                            ?>
                            <tr class="<?php echo $trClassName ?>">
                                <td>Unit <?php echo $k+1 ?></td>
                                <?php if ($modules[$j][USER_MODULES_TBL_STATUS]=="Active") : ?>
                                <td class="wpcw_fe_unit"><a href="<?php echo LMS_School::get_lesson_url()."?id=".$lessons[$k][LESSONS_TBL_ID]; ?>"><?php echo $lessons[$k]['title'] ?></a></td>
                                <?php else : ?>
                                    <td class="wpcw_fe_unit"><?php echo $lessons[$k]['title'] ?></td>
                                <?php endif; ?>
                                <td class="wpcw_fe_unit_progress wpcw_fe_unit_progress_incomplete"><span>&nbsp;</span></td>
                            </tr>
                        <?php endfor;
                        $quiz = $modules[$j][STUDENT_COURSE_LIST_QUIZ];
                        ?>
	                    <tr class="wpcw_fe_unit wpcw_fe_unit_pending wpcw_fe_module_group_quiz">
		                    <td>Quiz</td>
		                    <td class="wpcw_fe_unit"><a href="<?php echo LMS_School::get_quiz_url()."?quizID=".$quiz[QUIZ_TABLE_ID]; ?>"><?php echo $quiz[QUIZ_TABLE_TITLE]; ?></a></td>
	                    </tr>
                        <!-- End of List Of Units-->
                    </table>
                </td>
            <?php endfor; ?>
            </tr>
            <!-- End List of Course -->
        <?php endfor; ?>
        </tbody>
    </table>

<?php else : ?>
    <div class="wpcw_fe_progress_box_wrap"><div class="wpcw_fe_progress_box wpcw_fe_progress_box_error"><?php echo LMS_School::$message[$permissions]?></div></div>
<?php endif; ?>
