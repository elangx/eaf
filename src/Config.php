<?php
/**
 * 配置管理类，用于保存所有链接配置，并提供方法，闭包与model有关的配置并提供方法
 * @author yangxian16@gmail.com
 * @date 2017.05.31 17:41:58
 */

namespace Elm;
class Config {
    static private $_aConfig = array();

    /**
     * 一般由大框架set配置
     * @param $sName 配置key
     * @param $aValue value
     */
    public function set($sName, $aValue) {
        self::$_aConfig[$sName] = $aValue;
    }

    /**
     * unset掉某荐配置
     * @param $sName
     */
    public function del($sName) {
        unset(self::$_aConfig[$sName]);
    }

    /**
     * 清空配置
     */
    public function clear() {
        self::$_aConfig = array();
    }

    public function get($sName) {
        return self::$_aConfig[$sName] ?? array();
    }
}

/**
 * 单荐配置
 */
class ConfigObj {

    public function __call($sName, $aArg) {
        $sPrefix = substr($sName, 0, 3);
        if ($sPrefix == 'get' && count($aArg) == 1) {
            $sKey = '_' . strtolower($aArg[0]);
            return $this->$sKey ?? false;
        } else if ($sPrefix == 'set' && count($aArg) == 2) {
            $sKey = '_' . strtolower($aArg[0]);
            $this->$sKey = $aArg[1];
            return true;
        }
        return false;
    }
}
