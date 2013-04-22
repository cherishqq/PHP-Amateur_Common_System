<?php

/**
  +----------------------------------------------------------
 * 类功能：将指定URL利用google api生成二维码保存到本地并返回本地访问url
 * author：281978297@qq.com
 * 使用方法见：http://blog.51edm.org/post/113
  +----------------------------------------------------------
 */
class QRCode {

    private $path;
    private $size;

    public function __construct($path, $size) {
        $this->path = empty($path) ? C('webPath') . "/Uploads/QRCode/" : $path;
        $this->size = empty($size) ? 80 : $size;
    }

    /**
      +----------------------------------------------------------
     * 检测存储目录是否存在，不存在则创建该目录
      +----------------------------------------------------------
     */
    private function makeDir($path) {
        return is_dir($path) or ($this->makeDir(dirname($path)) and @mkdir($path, 0777));
    }

    /**
      +----------------------------------------------------------
     * 取得二维码地址
      +----------------------------------------------------------
     */
    public function getUrl($url = "http://blog.51edm.org") {
        $inPath = 'http://chart.apis.google.com/chart?chs=' . $this->size . 'x' . $this->size . '&cht=qr&chld=L|0&chl=' . $url;
        $savePath = $_SERVER['DOCUMENT_ROOT'] . $this->path;
        $this->makeDir($savePath);
        $fileName = substr(md5("$url"), 8, 16) . "_" . $this->size . ".png";

        $savePath.=$fileName;
        $outUrl = "http://" . $_SERVER['HTTP_HOST'] . $this->path . $fileName;
        if (file_exists($savePath) && filesize($savePath) > 0) {
            return $outUrl;
        }
        $in = fopen($inPath, "rb");
        $out = fopen($savePath, "wb");
        while ($chunk = fread($in, 8192))
            fwrite($out, $chunk, 8192);
        fclose($in);
        fclose($out);
        if (filesize($savePath) == 0) {
            $this->getUrl($url);
        } else {
            return $outUrl;
        }
    }

}

?>