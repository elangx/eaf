<?php
namespace Elf\Database\Connector;
class MysqlConnector {
    private $_pdo = null;

    public function __construct($aConfig) {
        extract($aConfig);
        $this->_pdo = new PDO($this->_getDsn($aConfig), $user, $password, $option);
    }

    public function __call($sName, $aArg) {
        return call_user_func_array(array(&$this->_pdo, $sName), $aArg);
    }

    private function _getDsn($aConfig) {
        extract($aConfig);
        $sDsn = 'mysql:dbname=' . $name . ';host=' . $host . ';';
        if (isset($port)) {
            $sDsn += 'port=' . $port . ';';
        }
        return $sDsn;
    }
}
