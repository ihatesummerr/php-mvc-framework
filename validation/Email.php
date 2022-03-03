<?php

namespace app\core\validation;

class Email extends Rule {

    public function validate($value): bool {
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    public function message(): string {
        return 'This field must be valid email address';
    }

}