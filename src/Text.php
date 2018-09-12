<?php

namespace juckknife\PosterOss;


use Juckknife\PosterOss\Exception\InvalidArgumentException;

class Text extends Watermark
{
    const TEXT_TYPE_WQY_ZENHEI = 'd3F5LXplbmhlaQ';  //文泉驿正黑

    const TEXT_TYPE_WQY_MICROHEI = 'd3F5LW1pY3JvaGVp'; //文泉微米黑

    const TEXT_TYPE_FANGZHENGSHUSONG = 'ZmFuZ3poZW5nc2h1c29uZw'; //方正书宋

    const TEXT_TYPE_FANGZHENGKAITI = 'ZmFuZ3poZW5na2FpdGk'; //方正楷体

    const TEXT_TYPE_FANGZHENGHEITI = 'ZmFuZ3poZW5naGVpdGk'; //方正黑体

    const TEXT_TYPE_FANGZHENGFANGSONG = 'ZmFuZ3poZW5nZmFuZ3Nvbmc'; //方正仿宋

    const TEXT_TYPE_DROIDSANSFALLBACK = 'ZHJvaWRzYW5zZmFsbGJhY2s'; //DroidSansFallback

    /**
     * 字体
     * @var
     */
    protected $type;

    /**
     * 颜色
     * @var
     */
    protected $color;

    /**
     * 字体大小
     * @var
     */
    protected $size = 36;

    /**
     * 文字水印的阴影透明度
     * @var
     */
    protected $shadow;

    /**
     * 文字顺时针旋转角度
     * @var
     */
    protected $rotate;

    /**
     * 进行水印铺满的效果
     * @var
     */
    protected $fill;

    /**
     * 文字行数
     * @var
     */
    protected $row = 1;

    /**
     * 文字行高
     * @var
     */
    protected $row_height = 1;

    /**
     * 每行字数
     * @var
     */
    protected $length = 16;


    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function watermarkStyles()
    {

        if (!$text = $this->getObject()) {
            throw new InvalidArgumentException('has no object!');
        }

        $waterStyle = '';

        $object = $this->getObject();

        preg_match_all("/./u", $object, $words);

        $words = $words[0];

        $maxRow = $this->getRow();

        $length = $this->getLength();

        $currentRow = 1;

        while ($currentRow <= $maxRow) {
            $start = ($currentRow - 1) * $length;
            $texts = array_slice($words, $start, $length);
            $line = '';
            foreach ($texts as $text) {
                $line .= $text;
            }
            if (!$line) {
                break;
            }

            $waterStyle .= sprintf('/watermark,text_%s', $this->url_safe_base64_encode($line));

            if ($type = $this->getType()) {
                $waterStyle .= sprintf(',type_%s', $type);
            }

            if ($color = $this->getColor()) {
                $waterStyle .= sprintf(',color_%s', $color);
            }

            if ($size = $this->getSize()) {
                $waterStyle .= sprintf(',size_%s', $size);
            }

            if ($shadow = $this->getShadow()) {
                $waterStyle .= sprintf(',shadow_%s', $shadow);
            }

            if ($rotate = $this->getRotate()) {
                $waterStyle .= sprintf(',rotate_%s', $rotate);
            }

            if ($fill = $this->getFill()) {
                $waterStyle .= sprintf(',rotate_%s', $rotate);
            }

            if ($t = $this->getT()) {
                $waterStyle .= sprintf(',t_%s', $t);
            }

            if ($g = $this->getG()) {
                $waterStyle .= sprintf(',g_%s', $g);
            }

            if ($x = $this->getX()) {
                if (in_array($g, [Watermark::G_NE, Watermark::G_SE, Watermark::G_NW, Watermark::G_SW, Watermark::G_WEST, Watermark::G_EAST])) {
                    $waterStyle .= sprintf(',x_%s', $x);
                }
            }

            if ($y = $this->getY()) {
                $y -= ($this->getSize() + $this->getRowHeight()) * ($currentRow - 1);
                if (in_array($g, [Watermark::G_NE, Watermark::G_SE, Watermark::G_NW, Watermark::G_SW, Watermark::G_NORTH, Watermark::G_SOUTH])) {
                    $waterStyle .= sprintf(',y_%s', $y);
                }
            }

            if ($voffset = $this->getVoffset()) {
                $waterStyle .= sprintf(',voffset_%s', $voffset);
            }

            if ($order = $this->getOrder()) {
                $waterStyle .= sprintf(',order_%s', $order);
            }

            if ($align = $this->getAlign()) {
                $waterStyle .= sprintf(',align_%s', $align);
            }

            if ($interval = $this->getInterval()) {
                $waterStyle .= sprintf(',interval_%s', $interval);
            }

            $currentRow++;
        }

        return $waterStyle;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setColor($color)
    {
        return $this->color = $color;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setShadow($shadow)
    {
        $this->shadow = $shadow;
    }

    public function getShadow()
    {
        return $this->shadow;
    }

    public function setRotate($r)
    {
        $this->rotate = $r;
    }

    public function getRotate()
    {
        return $this->rotate;
    }

    public function setFill($fill)
    {
        $this->fill = $fill;
    }

    public function getFill()
    {
        return $this->fill;
    }

    public function setRow($row)
    {
        $this->row = $row;
    }

    public function setRowHeight($height)
    {
        $this->row_height = $height;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }

    public function getRow()
    {
        return $this->row;
    }

    public function getRowHeight()
    {
        return $this->row_height;
    }

    public function getLength()
    {
        return $this->length;
    }
}