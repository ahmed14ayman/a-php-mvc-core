<?php
namespace ahmed14ayman\phpmvc;

use ahmed14ayman\phpmvc\db\DbModel;

abstract class UserModel extends DbModel {

    abstract public function getDisplayName():string;
}