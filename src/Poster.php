<?php

namespace juckknife\PosterOss;

class Poster
{
    protected $elements = [];


    protected $background;


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

        var_dump($waterStyle);

        return sprintf('%s%s', $this->background->render(), $waterStyle);
    }

    public function addEleemnt(Watermark $watermark)
    {
        array_push($this->elements, $watermark);
    }


    public function setBackGround(Image $background)
    {
        $this->background = $background;
    }
}