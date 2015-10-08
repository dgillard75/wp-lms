<?php
/**
 * Created by PhpStorm.
 * User: celeb
 * Date: 8/12/15
 * Time: 1:29 PM
 */

include_once(LMS_PLUGIN_PATH . "class/LMS_DBFunctions.class.php");

$url="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url1=$url."&action=addNew&redirect=".urlencode($url);
$quizeurl=$url."&action=questions&redirect=".urlencode($url);

$quizzes = LMS_DBFunctions::get_all_quizzes();

//LMS_Log::print_r($quizzes);
?>

<h2>Quiz &amp; Survey Summary</h2>

<form id="wpcw_quizzes_search_box" method="get" action="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary">
    <p class="search-box">
        <label class="screen-reader-text" for="wpcw_quizzes_search_input">Search Quizzes</label>
        <input id="wpcw_quizzes_search_input" type="text" value="" name="s"/>
        <input class="button" type="submit" value="Search Quizzes"/>

        <input type="hidden" name="page" value="WPCW_showPage_QuizSummary" />
    </p>
</form>
<br/><br/>
<div class="tablenav wpcw_tbl_paging">
    <div class="wpbs_paging tablenav-pages"><span class="displaying-num">Displaying 1 &ndash; 50 of <?php echo count($quizzes) ?></span><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=1" class="page-numbers current" data-pagenum="1">1</a><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=2" class="page-numbers " data-pagenum="2">2</a><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=3" class="page-numbers " data-pagenum="3">3</a><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=2" class="next page-numbers" data-pagenum="2">&raquo;</a></div>
</div>
<table id="wpcw_tbl_quiz_summary" class="widefat wpcw_tbl" class="widefat">
    <thead>
    <tr>
        <th id="quiz_id" scope="col" class="sorted desc"><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=&order=asc&orderby=quiz_id"><span>ID</span><span class="sorting-indicator"></span></a></th>
        <th id="quiz_title" scope="col" class="sortable"><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=&order=asc&orderby=quiz_title"><span>Quiz Title</span><span class="sorting-indicator"></span></a></th>
        <th id="associated_unit" scope="col" >Associated Unit</th>
        <th id="total_questions" scope="col" >Questions</th>
        <th id="actions" scope="col" >Actions</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th id="quiz_id" scope="col" class="sorted desc"><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=&order=asc&orderby=quiz_id"><span>ID</span><span class="sorting-indicator"></span></a></th>
        <th id="quiz_title" scope="col" class="sortable"><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=&order=asc&orderby=quiz_title"><span>Quiz Title</span><span class="sorting-indicator"></span></a></th>
        <th id="associated_unit" scope="col" >Associated Unit</th>
        <th id="total_questions" scope="col" >Questions</th>
        <th id="actions" scope="col" >Actions</th>
    </tr>
    </tfoot>
    <tbody>
    <?php foreach($quizzes as $quiz) : ?>
    <tr class="alternate">
        <td class="quiz_id"><?php echo $quiz[QUIZ_TABLE_ID] ?></td>
        <td class="quiz_title"><b><a href="https://testenv.com/school/wp-admin/admin.php?page=WPLMS_modifyQuiz&quizID=115&action=edit"><?php echo $quiz[QUIZ_TABLE_TITLE] ?></a></b></td>
        <td class="associated_unit">
            <span class="associated_unit_unit"><b>Unit</b>: <a href="http://testenv.com/school/module-5/cgh-m5-quiz/" target="_blank" title="View  'Quiz: Module 5'...">Quiz: Module 5</a></span>
            <span class="associated_unit_course"><b>Course:</b> <a href="admin.php?page=WPCW_showPage_ModifyCourse&course_id=1" title="Edit  'How to Become a Celebrity Green Housekeeper'...">How to Become a Celebrity Green Housekeeper</a></span>
        </td>
        <td class="total_questions wpcw_center"><?php echo LMS_DBFunctions::get_total_number_of_questions($quiz[QUIZ_TABLE_ID]); ?></td>
        <td class="actions">
            <ul class="wpcw_action_link_list">
                <li><a href="https://testenv.com/school/wp-admin/admin.php?page=WPLMS_modifyQuiz&quizID=115&action=edit" class="button-primary">Edit</a></li>
                <li><a href="https://testenv.com/school/wp-admin/admin.php?page=WPCW_showPage_QuizSummary&pagenum=&action=delete&quiz_id=115" class="button-secondary wpcw_action_link_delete_quiz wpcw_action_link_delete" rel="Are you sure you wish to delete this quiz?">Delete</a></li>
            </ul>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
