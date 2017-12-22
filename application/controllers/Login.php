<?php
/**
 * Created by PhpStorm.
 * User: hanhui
 * Date: 17-12-22
 * Time: 上午11:18
 */

class LoginController extends \Yaf\Controller_Abstract {

    public function apiAction($name = "Stranger") {

        $get = $this->getRequest()->getQuery("get", "default value");

        $this->getView()->assign("content", 'hanhyu');
        $this->getView()->assign("name", $name);

        return true;

    }

    public function ceshiAction(){
        echo 'index login ceshi';
        return false;
    }



}