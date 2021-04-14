<?php
/**
 * Created by PhpStorm.
 * User: JeffcottLu
 * Date: 2019-02-22
 * Time: 09:41.
 */
class Rect extends Shape
{
    private $width = 0;
    private $height = 0;

    public function __construct()
    {
        $this->shapeName = '矩形';
        if ($this->validate($_POST['width'], '矩形的宽度') & $this->validate($_POST['height'], '矩形的高度')) {
            $this->width = $_POST['width'];
            $this->height = $_POST['height'];
        } else {
            exit;
        }
    }

    public function area()
    {
        return $this->width * $this->height;
    }

    public function perimeter()
    {
        return 2 * ($this->width + $this->height);
    }
}
