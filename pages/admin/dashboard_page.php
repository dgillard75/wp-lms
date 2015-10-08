<?php
//include_once(LMS_PLUGIN_PATH . "class/LMS_PageFunctions.class.php");
include_once(WPLMS_PLUGIN_PATH . "class/OnlineSchoolLibrary.class.php");

#require_once(LMS_PLUGIN_PATH."shortcodes-templates/tabprofile.php");

require_once(WPLMS_PLUGIN_PATH . "testpage.php");

$slibrary = new OnlineSchoolLibrary();
$listofcourses = $slibrary->get_courses();

$addNewCourseUrl = LMS_PageFunctions::getAdminUrlPage(ADMIN_COURSES_ADD_PAGE,is_SSL());
$editCourseUrl = LMS_PageFunctions::getAdminUrlPage(ADMIN_COURSES_EDIT_PAGE, is_SSL());
$deleteCourseUrl = LMS_PageFunctions::getAdminUrlPage(ADMIN_COURSES_DELETE_PAGE,is_SSL());
$modulesUrl = LMS_PageFunctions::getAdminUrlPage(ADMIN_MODULES_PAGE,is_SSL());
$setsUrl = LMS_PageFunctions::getAdminUrlPage(ADMIN_SETS_PAGE,is_SSL());

?>

<div class="wrap">
    <div id="icon-edit-pages" class="icon32"></div>
    <h2>HST Courses<a class="add-new-h2" href="https://www.hsti.dev/school-old/wp-admin/admin.php?page=courses&action=add">Add New</a>	</h2>
</div>
<table id="wpcw_tbl_course_summary" class="widefat wpcw_tbl" class="widefat">
    <thead>
    <tr>
        <th id="course_id" scope="col" class="sortable">
            <a href="https://householdstafftraining.com/school/wp-admin/admin.php?page=WPCW_wp_courseware&order=asc&orderby=course_id"><span>ID</span><span class="sorting-indicator"></span></a>
        </th>
        <th id="course_title" scope="col" class="sorted asc">
            <a href="https://householdstafftraining.com/school/wp-admin/admin.php?page=WPCW_wp_courseware&order=desc&orderby=course_title"><span>Course Title</span><span class="sorting-indicator"></span></a>
        </th>
        <th id="course_desc" scope="col" >Description</th>
        <th id="course_settings" scope="col" >Status</th>
        <th id="total_units" scope="col" >Total Units</th>
        <th id="course_modules" scope="col" >Modules</th>
        <th id="actions" scope="col" >Actions</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th id="course_id" scope="col" class="sortable"><a href="/wp-admin/admin.php?page=WPCW_wp_courseware&order=asc&orderby=course_id"><span>ID</span><span class="sorting-indicator"></span></a></th>
        <th id="course_title" scope="col" class="sorted asc"><a href="/wp-admin/admin.php?page=WPCW_wp_courseware&order=desc&orderby=course_title"><span>Course Title</span><span class="sorting-indicator"></span></a></th>
        <th id="course_desc" scope="col" >Description</th>
        <th id="course_settings" scope="col" >Status</th>
        <th id="total_units" scope="col" >Total Units</th>
        <th id="course_modules" scope="col" >Modules</th>
        <th id="actions" scope="col" >Actions</th>
    </tr>
    </tfoot>
    <tbody>
    <?php for($i=0; $i < count($listofcourses); $i++) : $course = $listofcourses[$i]; ?>
        <tr class="alternate">
            <td class="course_id"><?php echo $course[COURSES_TBL_COURSE_ID]; ?></td>
            <td class="course_title">
                <a href="<?php echo $editCourseUrl."&courseID=".$course[COURSES_TBL_COURSE_ID]; ?>"> <?php echo $course[COURSES_TBL_CNAME];?> </a></td>
            <td class="course_desc"><?php echo $course[COURSES_TBL_DESC];?></td>
            <td class="course_id"><?php if ($course[COURSES_TBL_STATUS]=="1")  { $statusStr = "Active"; } else { $statusStr = "Inactive"; } echo $statusStr; ?></td>
            <td class="total_units"><?php echo $course['total_units'] ?></td>
            <td class="course_modules">
                <?php
                $listofmodules = $course['modules'];
                foreach  ($listofmodules as $module) :
                    ?>
                    <li><a href="<?php echo $modulesUrl."&module_id=".$module['module_id'] ?>" title="<?php echo "Edit Module "."'".$module['module_id']."'"?>"><?php echo $module['module_name'] ?></a></li>
                <?php endforeach; ?>
            </td>
            <td class="actions">
                <ul>
                    <li><a href="<?php echo $modulesUrl."&action=new" ?>" class="button-primary">Add Module</a></li>
                    <li><a href="<?php echo $editCourseUrl."&courseID=".$course[COURSES_TBL_COURSE_ID]; ?>" class="button-secondary">Edit Course</a></li>
                    <li><a href="https://householdstafftraining.com/school/wp-admin/admin.php?page=WPCW_showPage_CourseOrdering&course_id=11" class="button-secondary">Modules, Units &amp; Quiz Ordering</a></li>
                    <li><a href="https://householdstafftraining.com/school/wp-admin/admin.php?page=WPCW_showPage_GradeBook&course_id=11" class="button-secondary">Access Grade Book</a></li>
                </ul>
            </td>
        </tr>
    <?php endfor; ?>
    </tbody>
</table>
