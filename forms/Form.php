<?php


namespace app\forms;


class Form
{

    public static function begin($action, $method, $classes = "")
    {
        echo sprintf("<form action='%s' method='%s' class='%s'>", $action, $method, $classes);
        return new Form();
    }


    public static function end(){
        echo '</form>';
    }

    public function field($model, $attribute, $options = "")
    {
        return new Field($model, $attribute, $options);
    }

    public function submitButton($text, $divClasses, $buttonClasses){
        return new Button($text, $divClasses, $buttonClasses);
    }

}