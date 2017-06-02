<?php
namespace Elf;

use Elf\Database\Connector\ConnectManager;
abstract class BaseModel {
    abstract public function table();
    abstract public function db();

    protected function getBuilder() {

    }
    protected function update($aSet) {
    }
}
