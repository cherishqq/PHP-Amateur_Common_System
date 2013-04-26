<?php

class PublicModel extends Model {

    public function auth($datas) {
        $datas = $_POST;
        if ($_SESSION['verify'] != md5($_POST['verify_code'])) {
            die(json_encode(array('status' => 0, 'info' => "验证码错误啦，再输入吧")));
        }
        $M = M("Admin");
        if ($M->where("`email`='" . $datas['email'] . "'")->count() >= 1) {
            $info = $M->where("`email`='" . $datas["email"] . "'")->find();
            if ($info['status'] == 0) {
                return array('status' => 0, 'info' => "你的账号被禁用，有疑问联系管理员吧");
            }
            if ($datas['op_type'] == 2) {
                $rc = randCode(5);
                $code = $info['aid'] . md5($rc);
                $url = str_replace(C("webPath"),"",C("WEB_ROOT")) . U("Public/findPwd", array("code" => $code));
                $body = "请在浏览器上打开地址：<a href='$url'>$url</a> 进行密码重置操作                            ";
                $return = send_mail($datas["email"], "", "找回密码", $body);
                if ($return == 1) {
                    $info['find_code'] = $rc;
                    $M->save($info);
                    return array('status' => 1, 'info' => "重置密码邮件已经发往你的邮箱" . $_POST['email'] . "中，请注意查收");
                } else {
                    return array('status' => 0, 'info' => "$return");
                }
                exit;
            }
            if ($info['pwd'] == encrypt($datas['pwd'])) {
                $loginMarked = C("TOKEN");
                $loginMarked = md5($loginMarked['admin_marked']);
                $shell = $info['aid'] . md5($info['pwd'] . C('AUTH_CODE'));
                $_SESSION[$loginMarked] = "$shell";
                $shell.= "_" . time();
                setcookie($loginMarked, "$shell", 0, "/");
                $_SESSION['my_info'] = $info;
                return array('status' => 1, 'info' => "登录成功", 'url' => U("Index/index"));
            } else {
                return array('status' => 0, 'info' => "账号或密码错误");
            }
        } else {
            return array('status' => 0, 'info' => "不存在邮箱为：" . $datas["email"] . '的管理员账号！');
        }
    }

    public function findPwd() {
        $datas = $_POST;
        $M = M("Admin");
                if ($_SESSION['verify'] != md5($_POST['verify_code'])) {
            die(json_encode(array('status' => 0, 'info' => "验证码错误啦，再输入吧")));
        }
//        $this->check_verify_code();
        if (trim($datas['pwd']) == '') {
            return array('status' => 0, 'info' => "密码不能为空");
        }
        if (trim($datas['pwd']) != trim($datas['pwd1'])) {
            return array('status' => 0, 'info' => "两次密码不一致");
        }
        $data['aid'] = $_SESSION['aid'];
        $data['pwd'] = md5(C("AUTH_CODE") . md5($datas['pwd']));
        $data['find_code'] = NULL;
        if ($M->save($data)) {
            return array('status' => 1, 'info' => "你的密码已经成功重置", 'url' => U('Access/index'));
        } else {
            return array('status' => 0, 'info' => "密码重置失败");
        }
    }

}

?>
