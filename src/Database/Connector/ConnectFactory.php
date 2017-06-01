<?php
/**
 * connect工厂类
 * @author yangxian16@gmail.com
 * @date 2017.05.31 18:32:57
 */
namespace Eaf\Connector;

use Eaf\Config;
use Eaf\Constants;
use Eaf\Database\Connector\MysqlConnector;

class ConnectFactory {
    public function make($sName, $sType) {
        $aConfig = $this->_getConnectConfig($sName, $sType);
        if (empty($aConfig)) {
            return false;
        }
        switch($aConfig['driver']) {
            case Constants::DATABASE_DRIVER_MYSQL:
                return new MysqlConnector($aConfig);
        }
        return false;
    }

    private function _getReadConfig($aConfig) {
        $aReadList = array();
        foreach ($aConfig as $aLine) {
            if ($aLine[Constants::DATABASE_CONFIG_TYPE_READ]) {
                $aReadList[] = $aLine;
            }
        }
        if (empty($aReadList)) {
            return array();
        }
        $sKey = Common::getRandomKeyFromArrayWithKey($aReadList, Constants::DATABASE_CONFIG_READ_PERCENT);
        return $aReadList[$sKey];
    }

    private function _getWriteConfig($aConfig) {
        $aWriteList = array();
        foreach ($aConfig as $aLine) {
            if ($aLine[Constants::DATABASE_CONFIG_TYPE_WRITE]) {
                $aWriteList[] = $aLine;
            }
        }
        if (empty($aWriteList)) {
            return $aWriteList;
        }
        $sKey = Common::getRandomKeyFromArrayWithKey($aReadList, Constants::DATABASE_CONFIG_WRITE_PERCENT);
        return $aWriteList[$sKey];
    }

    private function _getConnectConfig($sName, $sType) {
        $aConfig = Config::get(Constants::DATABASE_CONFIG_KEY, $sName);
        switch ($sType) {
            case Constants::DATABASE_CONFIG_TYPE_READ:
                return $this->_getReadConfig($aConfig);
            case Constants::DATABASE_CONFIG_TYPE_WRITE:
                return $this->_getWriteConfig($aConfig);
        }
    }
}
