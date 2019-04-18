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
		$condition = [];

		if (!empty($_GET['pname'])) {
			$condition['pname'] = ['like', "%{$_GET['pname']}%"];
		}

		$Part = M('bbs_part');

		$cnt = $Part -> where($condition) -> count(); 

		$Page = new \Think\Page($cnt, 4);

		// 得到分页显示html代码
		$html_page = $Page -> show();

		// 获取数据
		$parts = $Part ->where($condition)
					   ->limit($Page->firstRow,$Page->listRows)
					   ->select();
		// 遍历显示
		$this->assign('parts', $parts);
		$this->assign('html_page', $html_page);
		$this->display(); 

	}
 	// 删除分区
	public function del()
	{
		$pid = $_GET['pid'];
		
		$cate = M('bbs_cate')->where("pid=$pid")->select();

		if (!empty($cate)){
			$this->error('请先删除所有版块');
		}

		$row = M('bbs_part ')->delete ($pid);

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