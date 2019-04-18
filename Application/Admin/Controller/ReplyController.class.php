<?php
namespace Admin\Controller;

use Think\Controller;

class ReplyController extends CommonController
{
	public function index()
	{	
		$pid = $_GET['pid'];
		$condition = [];

		if (!empty($_GET['rcontent'])) {
			$condition['rcontent'] = ['like', "%{$_GET['rcontent']}%"];
		}

		$Reply = M('bbs_reply');

		$cnt = $Reply->where($condition)->count();
		$Page = new \Think\Page($cnt, 5);
		$html_page = $Page->show();

		$replys = $Reply ->where($condition)
						 ->limit($Page->firstRow,$Page->listRows)
						 ->select();

		$users = M('bbs_user')->select();
		$users = array_column($users, 'uname', 'uid');

		$this->assign('replys', $replys);
		$this->assign('users', $users);
		$this->assign('html_page', $html_page);
		$this->display();
	}

	public function del()
	{
		$rid = $_GET['rid'];

		$replys = M('bbs_reply')->where("rid=$rid")->select();

		// $posts = M('bbs_reply')->where("rid=$rid")->select();
		// echo '<pre>';
		// print_r($replys);
		// die;

		// // // if (empty($cate)){
		// // // 	$auto = 
		// // // }

		$row = M('bbs_reply')->delete($rid);

		if ($row) {
			$this->success('删除成功!');
		} else {
			$this->error('删除失败!');
		}
	}

	public function edit()
	{
		$rid = $_GET['rid'];
		$replys  = M('bbs_reply')->find($rid);

		$this->assign('replys', $replys);
		$this->display();
	}

	public function update()
	{
		$rid = $_GET['rid'];

		$row = M('bbs_reply')->where("rid=$rid")->save($_POST);

		if ($row) {
			$this->success('修改成功!', '/index.php?m=admin&c=reply&a=index');
		} else {
			$this->error('修改失败!');
		}
	}
}