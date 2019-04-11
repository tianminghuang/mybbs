<?php
namespace Admin\Controller;

use Think\Controller;

class PartController extends CommonController
{
	// 添加分区-表单
	public function create()
	{	
		$this->display();
	}

	// 添加分区-保存数据
	public function save()
	{
		$row = M('bbs_part')->add( $_POST );

		if($row) {
			$this->success('chenggong');
		} else {
			$this->error('shibai');
		}
	}

	// 查看所有分区
	public function index()
	{	
		// 获取数据
		$parts = M('bbs_part')->select();

		// 遍历显示
		$this->assign('parts', $parts);
		$this->display(); 

	}
 	// 删除分区
	public function del()
	{
		$pid = $_GEI['pid'];

		$row = M('bbs_part ')->delelt ($pid);

		if ($row) {
			$this->success('删除分区成功!');
		} else {
			$this->errors('删除分区失败');
		}
	}

	// 修改分区--显示原有数据
	public function edit()
	{
		$pid = $_GET['pid'];

		$part = M('bbs_part')-> find( $pid );

		$this -> assign('part', $part);
		$this -> display();
	}

	// 修改分区--接受修改后的数据,更新
	public function update()
	{
		$pid = $_GET['pid'];

		$row = M('bbs_part') ->where("pid=$pid")->save( $_POST );

		if($row) {
			$this->success('修改分区成功!');
		} else {
			$this->error('修改分区失败!');
		}
	}

}