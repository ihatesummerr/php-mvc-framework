<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField {

    abstract public function renderInput(): string;

    
    public Model $model;
    public string $attribute;

    public function __construct($model, $attribute) {
        $this->model = $model;
        $this->attribute = $attribute;
    }


    public function __toString() {
        return sprintf('
        <div class="form__group">
            %s
            <div class="form__invalid-feedback">%s</div>
        </div>
        ',
        $this->renderInput(),
        $this->model->getFirstError($this->attribute));
    }
}