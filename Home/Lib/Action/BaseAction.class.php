<?php

// 本类由系统自动生成，仅供测试用途
class BaseAction extends Action {

    public function demoRegion() {
        $province = M('Region')->where(array('pid' => 1))->select();
        $this->assign('province', $province);
        $this->display();
    }

    public function getRegion() {
        $Region = M("Region");
        $map['pid'] = $_REQUEST["pid"];
        $map['type'] = $_REQUEST["type"];
        $list = $Region->where($map)->select();
        echo json_encode($list);
    }

    public function verify_code() {
        $w = isset($_GET['w']) ? (int) $_GET['w'] : 50;
        $h = isset($_GET['h']) ? (int) $_GET['h'] : 30;
        import("ORG.Util.Image");
        Image::buildImageVerify(4, 1, 'png', $w, $h);
    }

}