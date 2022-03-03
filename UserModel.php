<?php

namespace ihate\mvc;
use ihate\mvc\db\DbModel;

abstract class UserModel extends DbModel {
    abstract public function getDisplayName(): string;
}

?>