<?php

namespace juckknife\PosterOss;

class Poster
{

    protected $elements = [];


    protected $background;

    public static function getPoster()
    {
        return new Poster();
    }


    /**
     * 生成海报
     * @return string
     * @throws \Juckknife\PosterOSs\Exception\InvalidArgumentException
     */
    public function generate()
    {
        $waterStyle = '';
        foreach ($this->elements as $element) {
            if ($element instanceof Image) {
                //处理图片
                $waterStyle .= $element->watermarkStyles();
            } else {
                //处理文字
                $waterStyle .= $element->watermarkStyles();
            }
        }

        $this->background->resize();

        return sprintf('%s%s', $this->background->render(), $waterStyle);
    }

    /**
     * @param Watermark $watermark
     * @return $this
     */
    public function addEleemnt(Watermark $watermark)
    {
        array_push($this->elements, $watermark);

        return $this;
    }


    public function setBackground(Image $background)
    {
        $this->background = $background;
        return $this;
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string $method
     * @param  array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }
}