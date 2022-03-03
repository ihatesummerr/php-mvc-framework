<?php

namespace ihate\mvc\form;

use ihate\mvc\Model;

class Form {

    public static function begin($action, $method) {
        echo sprintf('<form class="form" action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end() {
        echo '</form>';
    }

    public function field(Model $model, $attribute) {
        return new InputField($model, $attribute);
    }

}