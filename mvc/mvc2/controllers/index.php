<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author Martin
 */
class controllers_index extends Controller{

    function indexAction(){
        $this->loadView("index/index");
    }
}
?>
