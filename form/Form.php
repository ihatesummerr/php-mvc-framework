<?php

namespace ihate\mvc\form;

use ihate\mvc\Model;

class Form {

    public static function begin($action, $method, $opt = '') {
        echo sprintf('<form class="form" action="%s" method="%s" %s>', $action, $method, $opt);
        return new Form();
    }

    public static function end() {
        echo '</form>';
    }

    public function field(Model $model, $attribute) {
        return new InputField($model, $attribute);
    }

}