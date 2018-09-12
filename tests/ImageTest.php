<?php

namespace Juckknife\PosterOss\Tests;

use juckknife\PosterOss\Image;
use juckknife\PosterOss\Poster;
use juckknife\PosterOss\Text;
use PHPUnit\Framework\TestCase;

class ImageTest extends TestCase
{

    /**
     * @throws \Juckknife\PosterOSs\Exception\InvalidArgumentException
     */
    public function testImage()
    {
        $image = new Image('http://image-demo.oss-cn-hangzhou.aliyuncs.com/example.jpg');

        $image->setResizeMode(Image::RESIZE_M_LFIIT);
        $image->setResizeWidth(200);
        $image->resize();

        //内切圆
//        $image->circle('150', 'png');
        //圆角
        $image->rounded_corners('30', 'png');

        $image->blur(20, 20);


        $url = $image->render();

        var_dump($url);
    }

    /**
     * @throws \Juckknife\PosterOSs\Exception\InvalidArgumentException
     */
    public function testPoster()
    {
        $background = new Image('http://byn-shop.oss-cn-hangzhou.aliyuncs.com/easyshop/resource/haibao01.jpg');
        $background->setResizeWidth(750);

        //头像
        $head = new Image('production/easyshop/doctor/1007/5b6d31425c411.jpg');
        $head->setResizeWidth(120);
        $head->resize();
        $head->rounded_corners(10);
        $head->setG(Image::G_NORTH);
        $head->setY(50);

        //文字
        $text = new Text('哈哈哈');
        $text->setLength(2);
        $text->setRow(2);
        $text->setG(Image::G_NORTH);
        $text->setY(250);
        $text->setColor('FFC0CB');
        $text->setType(Text::TEXT_TYPE_FANGZHENGKAITI);

        $url = Poster::getPoster()
            ->setBackground($background)
            ->addEleemnt($head)
            ->addEleemnt($text)
            ->generate();

        var_dump($url);

    }
}