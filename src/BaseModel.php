<?php
namespace Elf;

use Elf\Database\Connector\ConnectManager;
use Elf\Database\QueryBuilder\BuilderFactory;
abstract class BaseModel {
    abstract protected function _table();
    abstract protected function _db();

    protected function _getBuilder($sType) {
        return BuilderFactory::getInstance($this->_db(), $sType, $this->_table());
    }

    protected function _getSelect() {
        return $this->_getBuilder('select');
    }

    protected function _getUpdate() {
        return $this->_getBuilder('update');
    }

    protected function _getDelete() {
        return $this->_getBuilder('delete');
    }

    protected function _getInsert() {
        return $this->_getBuilder('insert');
    }
}
