<?php
/*
 * Plugin Name: WP LMS School
 * Version: 1.1
 * Plugin URI:
 * Description: WP LMS is WordPress Learning Managment System (L.M.S.) plugin tailored for HouseHold Staffing using PDFs as the lessons
 * Author: Dakarai Gillard
 * Author URI: http://flyplugins.com
 */

/*

 Copyright 2012-2015 Household Staff Training Institute

 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 */
ini_set('display_errors', true);
error_reporting(E_ALL);

/** The current version of the database. */
define('WPLMS_DATABASE_VERSION', 		'3.0');

/** The current version of the database. */
define('WPLMS_DATABASE_KEY', 			'WPCW_Version');

/** The key used to store settings in the database. */
define('WPLMS_DATABASE_SETTINGS_KEY', 	'WPCW_Settings');

/** The ID used for menus */
define('WPLMS_PLUGIN_ID', 				'WPLMS_school');

/** The ID of the plugin for update purposes, must be the file path and file name. */
define('WPLMS_PLUGIN_UPDATE_ID', 		'wp-lms/wp-lms.php');

/** The ID used for menus */
define('WPLMS_MENU_POSITION', 			384289);

/** Plugin Path Directory */
define("WPLMS_PLUGIN_PATH",             ABSPATH."wp-content/plugins/wp-lms/");

/** Plugin Path Directory */
define("WPLMS_ADMIN_PAGES_DIR",         WPLMS_PLUGIN_PATH."pages/admin");

/** Remove this LATER after all the changes */
define("LMS_PLUGIN_PATH",               WPLMS_PLUGIN_PATH);


function WPLMS_plugin_setup($force){
    //initial setup

}


/**
 * Initialization functions for plugin.
 */
function WPLMS_plugin_init()
{
    // Load translation support
    $domain = 'wp_lms'; // This is the translation locale.

    // Check the WordPress language directory for /wp-content/languages/wp_lms/wp_lms-en_US.mo first
    $locale = apply_filters('plugin_locale', get_locale(), $domain);
    load_textdomain($domain, WP_LANG_DIR . '/wp_lms/' . $domain . '-' . $locale . '.mo');

    // Then load the plugin version
    load_plugin_textdomain($domain, FALSE, dirname(plugin_basename(__FILE__)) . '/language/');

    // Run setup
    WPLMS_plugin_setup(false);

    // ### Admin
    if (is_admin()) {
        // Menus
        add_action('admin_menu', 'WPLMS_menu_MainMenu');
        add_action('admin_menu', 'WPLMS_excludeFromMenu');
    }else{

    }

    //Admin Scripts
    add_action('admin_enqueue_scripts', 'WPLMS_adminScripts');

    //AJAX calls
    add_action('wp_ajax_add_new_user_course', 'WPLMS_add_new_user_course');

    //ShortCodes
    add_shortcode('lms_course_info',    'WPLMS_courseInfo');
    add_shortcode('lms_choose_product', 'WPLMS_chooseProduct');
    add_shortcode('lms_shopping_cart',  'WPLMS_shoppingCart');
    add_shortcode('lms_checkout',       'WPLMS_checkout');
    add_shortcode('lms_lessons',        'WPLMS_lessons');
    add_shortcode('lms_mycourses',      'WPLMS_mycourses');
	add_shortcode('lms_quiz',           'WPLMS_quiz');


	//add_shortcode('process_product_page', 'process_product_page_shortcode');
}

/** Initialize Plugin */
add_action('init', 'WPLMS_plugin_init');


function WPLMS_excludeFromMenu(){
    add_submenu_page(null,'Add Quiz', 'Add Quiz', 'administrator', 'WPLMS_modifyQuiz', 'WPLMS_modifyQuiz');
}


/**
 * Main Menu setup for plugin for admin panel
 */
function WPLMS_menu_MainMenu(){

    add_menu_page('WP LMS School', 'WP LMS School', 'administrator',WPLMS_PLUGIN_ID,'WPLMS_dashboard');
    add_submenu_page(WPLMS_PLUGIN_ID,'Students', 'Students', 'administrator','students','WPLMS_students');
    add_submenu_page(WPLMS_PLUGIN_ID,'Add Course', 'Add Course', 'administrator','course','WPLMS_addcourse');
    add_submenu_page(WPLMS_PLUGIN_ID,'Add Modules', 'Add Modules', 'administrator','modules','WPLMS_addmodule');

    add_submenu_page(WPLMS_PLUGIN_ID, false, '<span class="wpcw_menu_section" style="display: block; margin: 1px 0 1px -5px; padding: 0; height: 1px; line-height: 1px; background: #CCC;"></span>', 'manage_options', '#', false);

    add_submenu_page(WPLMS_PLUGIN_ID,'Quiz Summary', 'Quiz Summary', 'administrator','WPLMS_quizSummary','WPLMS_quizSummary');
    add_submenu_page(WPLMS_PLUGIN_ID,'Question Pool', 'Question Pool', 'administrator','WPLMS_questionPool','WPLMS_questionPool');

    //No Menu
    //add_submenu_page(WPLMS_PLUGIN_ID,'Add Quiz', 'Add Quiz', 'administrator', 'add_quiz', 'WPLMS_addQuiz');

    add_submenu_page(null,'Stud','Student Courses', 'administrator','studentCourses','WPLMS_studentcourses');
    add_submenu_page(null,'Add Question', 'Add Question', 'administrator', 'add_question', 'WPLMS_addQuestion');
    //add_submenu_page(null,'Add Quiz', 'Add Quiz', 'administrator', 'WPLMS_addQuiz', 'WPLMS_addQuiz');


    //add_submenu_page('onlineschool','Packages', 'Packages', 'administrator','addpackage','addpackage_code');
    //add_submenu_page('onlineschool','Sets', 'Sets', 'administrator','sets','sets_code');
    //add_submenu_page('options.php','Students', 'Student Courses', 'administrator','studentCourses','studentCourses_code');
}




function WPLMS_buttons() {
    add_filter( "mce_external_plugins", "wptuts_add_buttons" );
    add_filter( 'mce_buttons',          'wptuts_register_buttons' );
}

function WPLMS_add_buttons( $plugin_array ) {
    $plugin_array['wptuts'] = plugins_url('/wp-lms/js/wptuts-plugin.js',dirname(__FILE__));
    return $plugin_array;
}

function WPLMS_register_buttons( $buttons ) {
    array_push( $buttons,'showmodule','module_position' ); // dropcap', 'recentposts
    return $buttons;
}


/************** Main Menu Callback Functions  *******************/
function WPLMS_dashboard(){
    require_once WPLMS_PLUGIN_PATH . "/pages/admin/dashboard_page.php";
}

function WPLMS_students(){
    require_once WPLMS_ADMIN_PAGES_DIR . "/students_admin_page.php";
}

function WPLMS_addcourse(){
    WPLMS_buttons();
    require_once WPLMS_ADMIN_PAGES_DIR . "/course_modify_page.php";
}

function WPLMS_addmodule(){
    require_once WPLMS_ADMIN_PAGES_DIR . "/modules_modify_page.php";
}


function WPLMS_modifyQuiz(){
    require_once WPLMS_PLUGIN_PATH . "/pages/admin/quiz_modify.php";
}




function WPLMS_studentcourses(){
    require_once WPLMS_PLUGIN_PATH . "/pages/student_courses_admin_page.php";
}

function WPLMS_addQuestion(){
    require_once WPLMS_PLUGIN_PATH . "/pages/admin/add_question.php";
}

function WPLMS_quizSummary(){
    require_once WPLMS_PLUGIN_PATH . "/pages/admin/quiz_summary.php";
}

function WPLMS_questionPool(){
    require_once WPLMS_PLUGIN_PATH . "/pages/admin/question_pool.php";
}


/********************* Admin Styles/Scripts *****************/
function WPLMS_adminScripts(){
    wp_register_style( 'custom_wp_admin_css_default', plugin_dir_url( __FILE__ ).'css/style.css' );
    wp_enqueue_style( 'custom_wp_admin_css_default' );
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script( 'custom_wp_admin_script_default', plugin_dir_url( __FILE__ ).'js/schools_scripts.js',array('media-upload','thickbox'));
    wp_enqueue_script( 'custom_wp_admin_script_default' );
    wp_enqueue_style('thickbox');

    wp_register_script( 'custom_wp_admin_script_default1', plugin_dir_url( __FILE__ ).'js/courses.js');
    wp_enqueue_script( 'custom_wp_admin_script_default1' );
    wp_register_script( 'custom_wp_admin_script_default2', plugin_dir_url( __FILE__ ).'js/script.js');
    wp_enqueue_script( 'custom_wp_admin_script_default2' );

    wp_register_script( 'custom_wp_admin_script_default3', plugin_dir_url( __FILE__ ).'js/simpletabs_1.3.js');
    wp_enqueue_script( 'custom_wp_admin_script_default3' );
}

/********************* AJAX Calls  *****************/
function WPLMS_add_new_user_course(){

}


/********************* SHORTCODE Callback Functions ********************/

/**
 *
 */
function WPLMS_courseInfo(){


}

/**
 *
 */
function WPLMS_chooseProduct(){


}

/**
 *
 */
function WPLMS_shoppingCart(){
    require_once(WPLMS_PLUGIN_PATH. "shortcodes/checkout.php");
}

/**
 *
 */
function WPLMS_checkout(){
    require_once(WPLMS_PLUGIN_PATH. "shortcodes/checkout.php");
}

/**
 *
 */
function WPLMS_lessons(){
    require_once(WPLMS_PLUGIN_PATH. "shortcodes/lessons.php");
}

function WPLMS_mycourses(){
	require_once(WPLMS_PLUGIN_PATH. "shortcodes/mycourse.php");

}

function WPLMS_quiz(){
	require_once(WPLMS_PLUGIN_PATH. "shortcodes/take_quiz.php");
}