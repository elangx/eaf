<?php
namespace Elf\Database\QueryBuilder;

use Eaf\Util\Valid;
use Eal\Database\ConnectManager;

class MysqlQueryBuilder {
    private $_sType;
    private $_aQuery;

    public function __construct($sTable, $sType) {
        $this->_aQuery  = array();
        $this->_aQuery['table'] = $sTable;
        $this->_sType   = $sType;
    }

    //public function table($sTableName) {
    //    $this->_aQuery['table'] = $sTableName;
    //}

    public function field(array $aField) {
        $this->_aQuery['field'] = $this->aField;
        return $this;
    }

    public function where(array $aCond) {
        $this->_aQuery['cond'] = $aCond;
        return $this;
    }

    public function limit($iLimit, $iCount = null) {
        $this->_aQuery['limit'] = $iLimit;
        $this->_aQuery['count'] = $iCount;
        return $this;
    }

    public function order($sOrder, $bAsc = true) {
        $this->_aQuery['order'] = $sOrder;
        $this->_aQuery['asc']   = $bAsc;
        return $this;
    }

    public function set(array $aSet) {
        $this->_aQuery['set'] = $aSet;
        return $this;
    }

    public function inset(array $aSet) {
        $this->_aQuery['inset'] = $aSet;
        return $this;
    }

    public function getValue() {
        return $this->_aValue;
    }

    public function getSql() {
        return $this->_buildQuery();
    }

    private function _buildQuery() {
        $sFuncName = '_build' . ucfirst($this->_sType);
        if (method_exists($this, $sFuncName)) {
            return $this->$sFuncName();
        }
    }

    private function _buildSelect() {
        $sSql = '';
        $sSql .= $this->_buildField();
        $sSql .= $this->_buildFromTable();
        $sSql .= $this->_buildWhere();
        $sSql .= $this->_buildOrder();
        $sSql .= $this->_buildLimit();
        return $sSql;
    }

    private function _buildUpdate() {
        $sSql = '';
        $sSql .= $this->_buildUpdateTable();
        $sSql .= $this->_buildSet();
        $sSql .= $this->_buildWhere();
        return $sSql;
    }

    private function _buildDelete() {
        $sSql = '';
        $sSql .= $this->_buildDeleteTable();
        $sSql .= $this->_buildWhere();
        return $sSql;
    }

    private function _buildInsert() {
        $sSql = '';
        $sSql .= $this->_buildInsertTable();
        $sSql .= $this->_buildInset();
        return $sSql;
    }

    private function _buildField() {
        if (!Valid::isKeyArrayValid($this->_aQuery, 'field')) {
            return '';
        }
        return ' ' . implode(',', $this->_aQuery['field']) . ' ';
    }

    private function _buildFromTable() {
        if (!Valid::isKeyValid($this->_aQuery, 'table')) {
            return '';
        }
        return ' from ' . $this->_aQuery['table'] . ' ';
    }
    
    private function _buildWhere() {
        if (!Valid::isKeyArrayValid($this->_aQuery, 'where')) {
            return '';
        }
        $aSql = array();
        foreach ($this->_aQuery['where'] as $sKey => $mVal) {
            $aSql[] = $sKey . '?';
            $this->_aValue[] = $mVal;
        }
        return ' where ' . implode(' and ', $aSql) . ' ';
    }

    private function _buildLimit() {
        if (!Valid::isKeyValid($this->_aQuery, 'limit')) {
            return '';
        }
        $sSql = ' limit ' . $this->_aQuery['limit'] . ' ';
        if (Valid::isKeyValid($this->_aQuery, 'count')) {
            $sSql .= ', ' . $this->_aQuery['count'] . ' ';
        }
        return $sSql;
    }

    private function _buildOrder() {
        if (!Valid::isKeyArrayValid($this->_aQuery, 'order')) {
            return '';
        }
        $sSql = ' order by ';
        $aOrder = array();
        foreach ($this->_aQuery['order'] as $sKey => $sBy) {
            $aOrder[] = ' ' . $sKey . ' ' . $sBy . ' ';
        }
        return $sSql . implode(',', $aOrder);
    }

    private function _buildUpdateTable() {
        if (!Valid::isKeyValid($this->_aQuery, 'table')) {
            return '';
        }
        return ' update ' . $this->_aQuery['table'];
    }

    private function _buildSet() {
        if (!Valid::isKeyArrayValid($this->_aQuery, 'set')) {
            return '';
        }
        $sSql = ' set ';
        $aSql = array();
        foreach ($this->_aQuery['set'] as $sKey => $mVal) {
            $aSql[] = $sKey . '=?';
            $this->_aValue[] = $mVal;
        }
        return $sSql . implode(',', $aSql) . ' ';
    }

    private function _buildDeleteTable() {
        if (!Valid::isKeyValid($this->_aQuery, 'table')) {
            return '';
        }
        return ' delete from ' . $this->_aQuery['table'] . ' ';
    }

    private function _buildInsertTable() {
        if (!Valid::isKeyValid($this->_aQuery, 'table')) {
            return '';
        }
        return 'insert into ' . $this->_aQuery['table'] . ' ';
    }

    private function _buildInset() {
        if (!Valid::isKeyArrayValid($this->_aQuery, 'inset')) {
            return '';
        }
        $sSql = '';
        $aKeys = array();
        $aMark = array();
        foreach ($this->_aQuery['inset'] as $sKey => $mVal) {
            $aKeys[] = $sKey;
            $aMark[] = '?';
            $this->_aVal[] = $mVal;
        }
        return ' (' . implode(',', $aKeys) . ') values (' . implode(',', $aMark) . ')';
    }
}
