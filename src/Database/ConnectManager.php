<?php
/**
 * 链接管理类，可区分长链接与短链接
 * @author yangxian16@gmail.com
 * @date 2017.05.31 17:34:24
 */

namespace Elm;

use Elm\Connctor\ConnectFactory;

class ConnectManager {
    /*
     * 取得链接instance
     * @param $sName
     * @return obj
     */
    public function getInstance($sName) {
        $aConfig = Config::get($sName);
    }

    private function createInstance($sName) {
        $aConfig = Config::get($sName);
        if (empty($aConfig)) {
            return false;
        }
    }
}
