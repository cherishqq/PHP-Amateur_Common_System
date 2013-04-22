<?php

class AccessAction extends CommonAction {

    /**
      +----------------------------------------------------------
     * 管理员列表
      +----------------------------------------------------------
     */
    public function index() {
        $this->assign("list", D("Access")->adminList());
        $this->display();
    }

    public function nodeList() {
        $this->assign("list", D("Access")->nodeList());
        $this->display();
    }

    public function roleList() {
        $this->assign("list", D("Access")->roleList());
        $this->display();
    }

    public function addRole() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->addRole());
        } else {
            $this->assign("info", $this->getRole());
            $this->display("editRole");
        }
    }

    public function editRole() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->editRole());
        } else {
            $M = M("Role");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该角色", U('Access/roleList'));
            }
            $this->assign("info", $this->getRole($info));
            $this->display();
        }
    }

    public function opNodeStatus() {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Access")->opStatus("Node"));
    }

    public function opRoleStatus() {
        header('Content-Type:application/json; charset=utf-8');
        echo json_encode(D("Access")->opStatus("Role"));
    }

    public function opSort() {
        $M = M("Node");
        $datas['id'] = (int) $this->_post("id");
        $datas['sort'] = (int) $this->_post("sort");
        header('Content-Type:application/json; charset=utf-8');
        if ($M->save($datas)) {
            echo json_encode(array('status' => 1, 'info' => "处理成功"));
        } else {
            echo json_encode(array('status' => 0, 'info' => "处理失败"));
        }
    }

    public function editNode() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->editNode());
        } else {
            $M = M("Node");
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该节点", U('Access/nodeList'));
            }
            $this->assign("info", $this->getPid($info));
            $this->display();
        }
    }

    public function addNode() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->addNode());
        } else {
            $this->assign("info", $this->getPid(array('level' => 1)));
            $this->display("editNode");
        }
    }

    /**
      +----------------------------------------------------------
     * 添加管理员
      +----------------------------------------------------------
     */
    public function addAdmin() {
        if (IS_POST) {
            $this->checkToken();
            header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->addAdmin());
        } else {
            $this->assign("info", $this->getRoleListOption(array('role_id' => 0)));
            $this->display();
        }
    }

    public function changeRole() {
        header('Content-Type:application/json; charset=utf-8');
        if (IS_POST) {
            $this->checkToken();
            echo json_encode(D("Access")->changeRole());
        } else {
            $M = M("Node");
            $info = M("Role")->where("id=" . (int) $_GET['id'])->find();
            if (empty($info['id'])) {
                $this->error("不存在该用户组", U('Access/roleList'));
            }
            $access = M("Access")->field("CONCAT(`node_id`,':',`level`,':',`pid`) as val")->where("`role_id`=" . $info['id'])->select();
            $info['access'] = count($access) > 0 ? json_encode($access) : json_encode(array());
            $this->assign("info", $info);
            $datas = $M->where("level=1")->select();
            foreach ($datas as $k => $v) {
                $map['level'] = 2;
                $map['pid'] = $v['id'];
                $datas[$k]['data'] = $M->where($map)->select();
                foreach ($datas[$k]['data'] as $k1 => $v1) {
                    $map['level'] = 3;
                    $map['pid'] = $v1['id'];
                    $datas[$k]['data'][$k1]['data'] = $M->where($map)->select();
                }
            }
            $this->assign("nodeList", $datas);
            $this->display();
        }
    }

    /**
      +----------------------------------------------------------
     * 添加管理员
      +----------------------------------------------------------
     */
    public function editAdmin() {
        if (IS_POST) {
            $this->checkToken();
        header('Content-Type:application/json; charset=utf-8');
            echo json_encode(D("Access")->editAdmin());
        } else {
            $M = M("Admin");
            $aid = (int) $_GET['aid'];
            $pre = C("DB_PREFIX");
            $info = $M->where("`aid`=" . $aid)->join($pre . "role_user ON " . $pre . "admin.aid = " . $pre . "role_user.user_id")->find();
            if (empty($info['aid'])) {
                $this->error("不存在该管理员ID", U('Access/index'));
            }
            if ($info['email'] == C('ADMIN_AUTH_KEY')) {
                $this->error("超级管理员信息不允许操作", U("Access/index"));
                exit;
            }
            $this->assign("info", $this->getRoleListOption($info));
            $this->display("addAdmin");
        }
    }

    private function getRole($info = array()) {
        import("Category");
        $cat = new Category('Role', array('id', 'pid', 'name', 'fullname'));
        $list = $cat->getList();               //获取分类结构
        foreach ($list as $k => $v) {
            $disabled = $v['id'] == $info['id'] ? ' disabled="disabled"' : "";
            $selected = $v['id'] == $info['pid'] ? ' selected="selected"' : "";
            $info['pidOption'].='<option value="' . $v['id'] . '"' . $selected . $disabled . '>' . $v['fullname'] . '</option>';
        }
        return $info;
    }

    private function getRoleListOption($info = array()) {
        import("Category");
        $cat = new Category('Role', array('id', 'pid', 'name', 'fullname'));
        $list = $cat->getList();               //获取分类结构
        $info['roleOption'] = "";
        foreach ($list as $v) {
            $disabled = $v['id'] == 1 ? ' disabled="disabled"' : "";
            $selected = $v['id'] == $info['role_id'] ? ' selected="selected"' : "";
            $info['roleOption'].='<option value="' . $v['id'] . '"' . $selected . $disabled . '>' . $v['fullname'] . '</option>';
        }
        return $info;
    }

    private function getPid($info) {
        $arr = array("请选择", "项目", "模块", "操作");
        for ($i = 1; $i < 4; $i++) {
            $selected = $info['level'] == $i ? " selected='selected'" : "";
            $info['levelOption'].='<option value="' . $i . '" ' . $selected . '>' . $arr[$i] . '</option>';
        }
        $level = $info['level'] - 1;
        import("Category");
        $cat = new Category('Node', array('id', 'pid', 'title', 'fullname'));
        $list = $cat->getList();               //获取分类结构
        $option = $level == 0 ? '<option value="0" level="-1">根节点</option>' : '<option value="0" disabled="disabled">根节点</option>';
        foreach ($list as $k => $v) {
            $disabled = $v['level'] == $level ? "" : ' disabled="disabled"';
            $selected = $v['id'] != $info['pid'] ? "" : ' selected="selected"';
            $option.='<option value="' . $v['id'] . '"' . $disabled . $selected . '  level="' . $v['level'] . '">' . $v['fullname'] . '</option>';
        }
        $info['pidOption'] = $option;
        return $info;
    }

}