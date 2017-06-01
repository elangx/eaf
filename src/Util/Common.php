<?php
namespace Eaf\Util;

class Common {
    /*
     * 根据array里的value值当作概率返回key值
     * @param $aKeys
     * @return key
     */
    public static function getRandomKeyFromArray(array $aKeys) {
        $iSum = 0;
        foreach ($aKeys as &$iVal) {
            $iVal += $iSum;
            $iSum = $iVal;
        }
        $iRad = random_int(1, $iSum);
        foreach ($aKeys as $sKey => $iVal) {
            if ($iVal >= $iRad) {
                return $sKey;
            }
        }
    }

    public static function getRandomKeyFromArrayWithKey(array $aKeys, $sName) {
        $aRet = array();
        foreach ($aKeys as $sKey => $aVal) {
            if (!isset($aVal[$sName])) {
                return $sKey;
            }
            $aRet[$sKey] = $aVal[$sName];
        }
        return self::getRandomKeyFromArray($aRet);
    }
}
