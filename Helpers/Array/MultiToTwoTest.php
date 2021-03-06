<?php

namespace Helpers\Arrays;

use PHPUnit\Framework\TestCase;

// 多维转二维
/**
 * @coversNothing
 */
class MultiToTwoTest extends TestCase
{
    /**
     * 多维转二维.
     *
     * [PHP多维数组转换成二维数组 - SegmentFault](https://segmentfault.com/q/1010000004083783)
     * [PHP二维数组排序的3种方法和自定义函数分享_php实例_脚本之家](http://www.jb51.net/article/48841.htm)
     */
    public function reformat($arrTmp, $parent_id = 0, &$ret = null)
    {
        foreach ($arrTmp as $k => $v) {
            $ret[$v['id']] = ['id' => $v['id'], 'level' => $v['level'], 'parent_id' => $parent_id];
            if ($v['child']) {
                $this->reformat($v['child'], $v['id'], $ret);
            }
        }

        return $ret;
    }
}
