<?php
/**
 * Created by PhpStorm.
 * User: shenyang
 * Date: 2018/9/5
 * Time: 11:29
 */

namespace juckknife\PosterOss;


use Juckknife\PosterOss\Exception\InvalidArgumentException;

class Image extends Watermark
{
    /**
     * 等比缩放，限制在指定w与h的矩形内的最大图片。
     */
    const RESIZE_M_LFIIT = 'lfit';

    /**
     * 等比缩放，延伸出指定w与h的矩形框外的最小图片。
     */
    const RESIZE_M_MFIT = 'mfit';

    /**
     * 固定宽高，将延伸出指定w与h的矩形框外的最小图片进行居中裁剪。
     */
    const RESIZE_M_FILL = 'fill';

    /**
     * 固定宽高，缩略填充。
     */
    const RESIZE_M_PAD = 'pad';

    /**
     * 固定宽高，强制缩略。
     */
    const RESIZE_M_FIXED = 'fixed';


    const RESIZE_M_LIST = ['lfit', 'mfit', 'fill', 'pad', 'fixed'];


    protected $resizeData = [];


    protected $styles;


    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function render()
    {
        return $this->styles ? sprintf('%s?x-oss-process=%s', $this->object, $this->styles) : $this->object;
    }

    public function posterRender()
    {
        if ($waterStyles = $this->watermarkStyles()) {
            return sprintf('watermark,image_%s,%s', $this->url_safe_base64_encode($this->object), $waterStyles);
        } else {
            return sprintf('watermark,image_%s', $this->url_safe_base64_encode($this->object));
        }

    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    public function watermarkStyles()
    {

        if ($this->getObject()){
            var_dump($this->render());
            $waterStyle = '/watermark,image_' . $this->url_safe_base64_encode($this->render());
        } else {
            throw new InvalidArgumentException('has no object!');
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

        return $waterStyle;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function resize()
    {
        if (!$this->resizeData) {
            throw new InvalidArgumentException('请设置缩放参数!');
        }

        $resizeStyle = $this->appendStyle('resize');

        foreach ($this->resizeData as $key => $value) {
            $resizeStyle .= sprintf(',%s_%s', $key, $value);
        }

        $this->styles = $resizeStyle;
    }

    /**
     * 内切圆
     * @param $r
     * @param string $format
     */
    public function circle($r, $format = '')
    {
        $circleStyle = $this->appendStyle('circle');

        $circleStyle .= sprintf(',%s_%s', 'r', $r);

        if ($format) {
            $circleStyle .= '/format,' . $format;
        }

        $this->styles = $circleStyle;
    }

    /**
     * 圆角
     */
    public function rounded_corners($r, $format = '')
    {
        $circleStyle = $this->appendStyle('rounded-corners');

        $circleStyle .= sprintf(',%s_%s', 'r', $r);

        if ($format) {
            $circleStyle .= '/format,' . $format;
        }

        $this->styles = $circleStyle;
    }

    /**
     * 是否自适应方向
     */
    public function auto_orient(bool $value)
    {
        $authOrientStyle = $this->appendStyle('auto-orient');

        $authOrientStyle .= ',' . ($value ? 1 : 0);

        $this->styles = $authOrientStyle;
    }

    /**
     * 图片旋转
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function rotate(int $value)
    {
        if ($value < 0 || $value > 360) {
            throw new InvalidArgumentException('invalid param rotate must in [0-100]');
        }

        $style = $this->appendStyle('rotate');

        $style .= ',' . $value;

        $this->styles = $style;
    }

    /**
     * 模糊效果
     * @param $r
     * @param $s
     * @throws InvalidArgumentException
     */
    public function blur($r, $s)
    {
        if ($r < 1 || $r > 50) {
            throw new InvalidArgumentException('invalid r param must in [1-50]');
        }

        if ($s < 1 || $s > 50) {
            throw new InvalidArgumentException('invalid s param must in [1-50]');
        }

        $this->appendStyle('blur');

        $this->styles .= ',' . sprintf('r_%s,s_%s', $r, $s);
    }

    /**
     * 调整亮度
     * @param $value
     * @throws InvalidArgumentException
     */
    public function bright($value)
    {
        if ($value < -100 || $value > 100) {
            throw new InvalidArgumentException('invalid param must in [-100, 100]');
        }

        $this->appendStyle('bright');

        $this->styles .= ',' . $value;
    }

    /**
     * 调整对比度
     * @param $value
     * @throws InvalidArgumentException
     */
    public function contrast($value)
    {
        if ($value < -100 || $value > 100) {
            throw new InvalidArgumentException('invalid param must in [-100, 100]');
        }

        $this->appendStyle('contrast');

        $this->styles .= ',' . $value;
    }

    /**
     * 调整锐化
     * @param $value
     * @throws InvalidArgumentException
     */
    public function sharpen($value)
    {
        if ($value < -50 || $value > 399) {
            throw new InvalidArgumentException('invalid param must in [50, 399]');
        }

        $this->appendStyle('sharpen');

        $this->styles .= ',' . $value;
    }


    private function appendStyle($style)
    {
        if ($this->styles) {
            $this->styles .= '/' . $style;
        } else {
            $this->styles .= 'image/' . $style;
        }
        return $this->styles;
    }

    /**
     * 设置缩放模式
     * @param string $mode
     * @throws InvalidArgumentException
     */
    public function setResizeMode(string $mode)
    {
        if (!in_array($mode, self::RESIZE_M_LIST)) {
            throw new InvalidArgumentException('缩略模式参数错误');
        }
        $this->resizeData['m'] = $mode;
    }

    /**
     * 设置缩放宽度
     * @param int $width
     * @throws InvalidArgumentException
     */
    public function setResizeWidth(int $width)
    {
        if ($width < 1 || $width > 4096) {
            throw new InvalidArgumentException('参数错误');
        }
        $this->resizeData['w'] = $width;
    }

    /**
     * 设置缩放高度
     * @param int $height
     * @throws InvalidArgumentException
     */
    public function setResizeHeight(int $height)
    {
        if ($height < 1 || $height > 4096) {
            throw new InvalidArgumentException('参数错误');
        }
        $this->resizeData['h'] = $height;
    }

    /**
     * 指定目标缩略图的最长边
     * @param int $length
     * @throws InvalidArgumentException
     */
    public function setResizeMaxLength(int $length)
    {
        if ($length < 1 || $length > 4096) {
            throw new InvalidArgumentException('参数错误');
        }
        $this->resizeData['l'] = $length;
    }

    /**
     * 指定目标缩略图的最短边
     * @param int $length
     * @throws InvalidArgumentException
     */
    public function setResizeMinLength(int $length)
    {
        if ($length < 1 || $length > 4096) {
            throw new InvalidArgumentException('参数错误');
        }
        $this->resizeData['s'] = $length;
    }

    /**
     * 指定当目标缩略图大于原图时是否处理
     * @param bool $limit
     */
    public function setResizeLimit(bool $limit)
    {
        $this->resizeData['limit'] = $limit ? 1 : 0;
    }

    /**
     * 当缩放模式选择为pad（缩略填充）时，可以选择填充的颜色
     * @param string $color
     */
    public function setColor(string $color)
    {
        $this->resizeData['color'] = $color;
    }
}