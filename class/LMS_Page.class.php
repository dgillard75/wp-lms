<?php
/**
 * Created by PhpStorm.
 * User: celeb
 * Date: 5/7/15
 * Time: 1:51 PM
 */

abstract class LMS_Page {

    //protected $lmsdb;
    protected $resultArr;

    function __construct(){
      //  $this->init();
        $this->resultArr = array();
    }

    //protected function init() {
      //  $this->lmsdb = new \LMS_SchoolDB();
    //}

    abstract protected function processForm();

    abstract protected function processGetRequest();

    abstract protected function getPostData();

    protected function setResult($type,$result){
        $this->resultArr['etype'] = $type;

        if($type == 'db') {
            if ($result > 0) {
                $this->resultArr['status'] = true;
                $this->resultArr['errors'] = 0;
            } else {
                $this->resultArr['errors'] = 1;
                $this->resultArr['status'] = false;
            }
        }

        if($type == 'form'){
            if ($result == 0) {
                $this->resultArr['status'] = true;
                $this->resultArr['errors'] = 0;
            }else{
                $this->resultArr['status'] = false;
                $this->resultArr['errors'] = $result;

            }
        }

        if($type == 'get'){
            $this->resultArr['status'] = true;
        }
    }

}
?>