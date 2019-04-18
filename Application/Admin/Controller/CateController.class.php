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


	public function index()
	{

		$condition = [];
		if (!empty($_GET['pid'])) {
			$condition['pid'] = ['eq', "{$_GET['pid']}"];
		}

		if (!empty($_GET['cname'])) {
			$condition['cname'] = ['like', "%{$_GET['cname']}%"];
		}
		$parts = M('bbs_part')->select();
		// echo '<pre>';
		// print_r($parts);
		// die;
		
		$parts = array_column($parts, 'pname', 'pid');
		

		$Cate = M('bbs_cate');

		$cnt = $Cate -> where($condition) -> count(); 

		$Page = new \Think\Page($cnt, 5);


		$html_page = $Page -> show();

		$cates = $Cate ->where($condition)
					   ->limit($Page->firstRow,$Page->listRows)
					   ->select();

	
		$users = M('bbs_user')->select();
		$users = array_column($users, 'uname', 'uid');
		//$users = M('bbs_user')->getField('uid,uname');

		// 遍历显示数据
		$this->assign('cates', $cates);
		$this->assign('parts', $parts);
		$this->assign('users', $users);
		$this->assign('html_page', $html_page);
		$this->display();
	}


	// 删除版块
	public function del()
	{
		$cid = $_GET['cid'];

		$posts = M('bbs_post')->where("cid=$cid")->select();

		if (!empty($posts)){
			$this->error('请先清空帖子');
		}

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
			$this->success('修改成功!','/index.php?m=admin&c=cate&a=index');
		} else {
			$this->error('修改失败!');
		}
 	}
}