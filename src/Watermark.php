<?php

namespace juckknife\PosterOss;



use Juckknife\PosterOss\Exceptions\InvalidArgumentException;

class Watermark
{
    const G_VALUE_LIST = ['nw', 'north', 'ne', 'west', 'center', 'east', 'sw', 'south', 'se'];

    const G_NW = 'nw';

    const G_NORTH = 'north';

    const G_NE = 'ne';

    const G_WEST = 'west';

    const G_CENTER = 'center';

    const G_EAST = 'east';

    const G_SW = 'sw';

    const G_SOUTH = 'south';

    const G_SE = 'se';

    const ORDER_IMAGE = 0;

    const ORDER_TEXT = 1;

    const ALIGN_TOP = 0;

    const ALIGN_MIDDLE = 1;

    const ALIGN_BUTTOM = 2;

    /**
     * 参数意义：透明度, 如果是图片水印，就是让图片变得透明，如果是文字水印，就是让水印变透明。默认值：100， 表示 100%（不透明） 取值范围: [0-100]
     * @var
     */
    protected $t;

    /**
     * 参数意义：位置，水印打在图的位置，详情参考下方区域数值对应图。取值范围：[nw,north,ne,west,center,east,sw,south,se]
     * @var
     */
    protected $g;

    /**
     * 参数意义：水平边距, 就是距离图片边缘的水平距离， 这个参数只有当水印位置是左上，左中，左下， 右上，右中，右下才有意义。
     * 默认值：10
     * 取值范围：[0 – 4096] 单位：像素（px）
     * @var
     */
    protected $x;

    /**
     * 参数意义：垂直边距, 就是距离图片边缘的垂直距离， 这个参数只有当水印位置是左上，中上， 右上，左下，中下，右下才有意义 默认值：10 取值范围：[0 – 4096] 单位：像素(px)
     * @var
     */
    protected $y;

    /**
     * 参数意义： 中线垂直偏移，当水印位置在左中，中部，右中时，可以指定水印位置根据中线往上或者往下偏移 默认值：0 取值范围：[-1000, 1000] 单位：像素(px)
     * @var
     */
    protected $voffset;

    /**
     * 主体(可以是文字也可以是图片)
     * @var
     */
    protected $object;

    /**
     * 参数意义： 文字，图片水印前后顺序取值范围：[0, 1] order = 0 图片在前(默认值)； order = 1 文字在前
     * @var
     */
    protected $order;

    /**
     * 参数意义：文字、图片对齐方式取值范围：[0, 1, 2] align = 0 上对齐(默认值) align = 1 中对齐 align = 2 下对齐
     * @var
     */
    protected $align;

    /**
     * 参数意义：文字和图片间的间距取值范围: [0, 1000]
     * @var
     */
    protected $interval;


    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * 设置透明度
     * @param $t
     * @throws InvalidArgumentException
     */
    public function setT($t)
    {
        if ($t < 0 || $t > 100) {
            throw new InvalidArgumentException('透明度参数错误 取值范围: [0-100]');
        }
        $this->t = $t;
    }

    /**
     * 获取透明度
     * @return mixed
     */
    public function getT()
    {
        return $this->t;
    }

    /**
     * 设置位置
     * @param $g
     * @throws InvalidArgumentException
     */
    public function setG($g)
    {
        if (!in_array($g, self::G_VALUE_LIST)) {
            throw new InvalidArgumentException('位置参数错误! 取值范围：[nw,north,ne,west,center,east,sw,south,se]');
        }
        $this->g = $g;
    }

    /**
     * 获取位置
     * @return mixed
     */
    public function getG()
    {
        return $this->g;
    }

    /**
     * 设置水平边距
     * @param $g
     * @throws InvalidArgumentException
     */
    public function setX($x)
    {
        if ($x < 0 || $x > 4096) {
            throw new InvalidArgumentException('水平边距设置错误 [0 – 4096] 单位：像素（px）');
        }
        $this->x = $x;
    }

    /**
     * 获取水平边距
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * 设置垂直边距
     * @param $y
     * @throws InvalidArgumentException
     */
    public function setY($y)
    {
        if ($y < 0 || $y > 4096) {
            throw new InvalidArgumentException('垂直边距设置错误 [0 – 4096] 单位：像素（px）');
        }
        $this->y = $y;
    }

    /**
     * 获取垂直边距
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * 设置中垂线偏移量
     * @param $voffset
     * @throws InvalidArgumentException
     */
    public function setVoffset($voffset)
    {
        if ($voffset < -1000 || $voffset > 1000) {
            throw new InvalidArgumentException('中垂线偏移设置错误 取值范围[-1000, 1000]');
        }
        $this->voffset = $voffset;
    }

    /**
     * 获取中线垂直偏移
     * @return mixed
     */
    public function getVoffset(){
        return $this->voffset;
    }

    /**
     * 设置图片文字展示顺序
     * @param $order
     * @throws InvalidArgumentException
     */
    public function setOrder($order)
    {
        if (!in_array($order, [self::ORDER_IMAGE, self::ORDER_TEXT])) {
            throw new InvalidArgumentException('文字、图片顺序错误 取值范围：[0, 1]');
        }
        $this->order = $order;
    }

    /**
     * 获取图片文字展示顺序
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * 设置文字、图片对齐方式
     * @param $align
     * @throws InvalidArgumentException
     */
    public function setAlign($align)
    {
        if (!in_array($align, [self::ALIGN_TOP, self::ALIGN_MIDDLE, self::ALIGN_BUTTOM])) {
            throw new InvalidArgumentException('文字、图片对齐方式 参数错误！');
        }
        $this->align = $align;
    }

    /**
     * 获取文字、图片对齐方式
     * @return mixed
     */
    public function getAlign()
    {
        return $this->align;
    }

    /**
     * 设置文字图片间距
     * @param $interval
     * @throws InvalidArgumentException
     */
    public function setInterval($interval)
    {
        if ($interval < 0 || $interval > 1000) {
            throw new InvalidArgumentException('间距参数错误！');
        }
        $this->interval = $interval;
    }

    /**
     * 获取文字图片间距
     * @return mixed
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * 获取主体
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * URL安全base64编码
     * @param $string
     * @return mixed|string
     */
    public function url_safe_base64_encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

}