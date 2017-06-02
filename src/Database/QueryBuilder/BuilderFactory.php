<?php
namespace Eaf\Database\QueryBuilder;

class BuilderFactory {
    static public function getInstance($sName, $sType, $sTable) {
        $aConfig = self::_getConfig($sName);
        switch ($Config['driver']) {
        case Constants::DATABASE_DRIVER_MYSQL:
            return new MysqlQueryBuilder($sType, $sTable);
        }
    }

    static private function _getConfig($sName) {
        $aConfig = Config::get(Constants::DATABASE_CONFIG_KEY, $sName);
    }
}
