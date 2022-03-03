<?php

namespace app\core\validation;

class Correspond extends Rule {

    private string $match;
    private string $matchValue;

    public function __construct($params) {
        $this->match = $params['match'];
        $this->matchValue = $params['value'];
    }

    public function validate($value): bool {

        if ($value === $this->matchValue) {
            return true;
        }
        return false;
    }

    public function message(): string {
        return "This field must be the same as $this->match";
    }

}