<?php
namespace Eaf\Util;

class Valid {
    static public function isKeyArrayValid($aSet, $sKey) {
        return isset($aSet[$sKey])
            && is_array($aSet[$sKey])
            && !empty($aSet[$sKey]);
    }

    static public function isKeyValid($aSet, $sKey) {
        return isset($aSet[$sKey])
            && $aSet[$sKey] !== '';
    }
}
