<?php

class IndexModel extends Model {

    public function my_info($datas) {
        $M = M("Admin");
        if (md5(C("AUTH_CODE") . md5($datas['pwd0'])) != $_SESSION['my_info']['pwd']) {
            return array('status' => 0, 'info' => "旧密码错误");
        }
        if (trim($datas['pwd']) == '') {
            return array('status' => 0, 'info' => "密码不能为空");
        }
        if (trim($datas['pwd']) != trim($datas['pwd1'])) {
            return array('status' => 0, 'info' => "两次密码不一致");
        }
        $data['aid'] = $_SESSION['my_info']['aid'];
        $data['pwd'] = md5(C("AUTH_CODE") . md5($datas['pwd']));
        if ($M->save($data)) {
            setcookie("$this->loginMarked", NULL, -3600, "/");
            unset($_SESSION["$this->loginMarked"], $_COOKIE["$this->loginMarked"]);
            return array('status' => 1, 'info' => "你的密码已经成功修改，请重新登录",'url'=>U('Access/index'));
        } else {
            return array('status' => 0, 'info' => "密码修改失败");
        }
    }

}

?>
