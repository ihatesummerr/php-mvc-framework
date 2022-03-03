<?php

namespace app\core\form;

use app\core\Model;

class TextAreaField extends BaseField {

    public string $type;
    public Model $model;
    public string $attribute;

    public function __construct($model, $attribute) {
        parent::__construct($model, $attribute);
    }

    public function renderInput(): string
    {
        return sprintf('<textarea
            name="%s"
            class="form__input form__text-area %s"
            placeholder="%s"
        >%s</textarea>',
        $this->attribute, 
        $this->model->hasError($this->attribute) ? 'form__input--is-invalid' : '', 
        $this->model->labels()[$this->attribute] ?? $this->attribute,
        $this->model->{$this->attribute});
    }

}