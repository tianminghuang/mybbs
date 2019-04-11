<?php
namespace Admin\Controller;

use Think\Controller;

class CateController extends CommonController
{
	// 添加版块
	public function create()
	{
		// 获取所有分区
		$parts = M('bbs_part')->select();

		// 获取用户信息
		$users = M('bbs_user') -> where("auth<3") -> select();

		$this->assign('users', $users);

		$this->assign('parts',$parts);
		$this->display();
	}

	public function save()
	{	try{
			$row = M('bbs_cate')->add( $_POST );
		} catch (\Exception $e) {
			$this->error( $e->getMessage() );
		}
		
		if ($row) {
			$this->success('添加板块成功!');
		} else {
			$this->error('添加板块失败!');
		}
	}


	// 查看版块
	public function index()
	{
		// 获取数据
		$cates = M('bbs_cate')->select();

		// 获取分区信息
		$parts = M('bbs_part')->select();

		// ['pid' => '分区名称', pid=>'分区名称'];
		$parts = array_column($parts, 'pname', 'pid');
		// echo '<pre>';
		// print_r($arr);
		// die;

		$users = M('bbs_user')->select();
		$users = array_column($users, 'uname', 'uid');
		//$users = M('bbs_user')->getField('uid,uname');

		// 遍历显示数据
		$this->assign('cates', $cates);
		$this->assign('parts', $parts);
		$this->assign('users', $users);
		$this->display();
	}


	// 删除版块
	public function del()
	{
		$cid = $_GET['cid'];
		$row = M('bbs_cate')->delete($cid); 

		if ($row) {
			$this->success('删除成功!');
		} else {
			$this->error('删除失败!');
		}

	}



	//修改板块
	public function edit()
	{
		$cid = $_GET['cid'];
		$cate = M('bbs_cate')->find($cid);

		$parts = M('bbs_part')->select();

		$users = M('bbs_user')->where("auth<3")->select();

		$this->assign('users', $users);
		$this->assign('parts', $parts);
		$this->assign('cate', $cate);
		
		$this->display();   
	}

	public function update()
	{
		$cid = $_GET['cid'];

		$row = M('bbs_cate')->where("cid=$cid")->save($_POST);

		if ($row) {
			$this->success('修改成功!');
		} else {
			$this->error('修改失败!');
		}
 	}
}