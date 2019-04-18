<?php
namespace Home\Controller;

use Think\Controller;

class PostController extends Controller
{
	// 发帖
	public function create()
	{	

		// 可能接收到一个板块ID
		$cid = empty($_GET['cid'])? 0 : $_GET['cid'];

		// 如果没有登录,就跳到登录去
		if (empty($_SESSION['flag'])){
			$this->error('请先登录...', '/');
		}

		// 获取板块信息
		$cates = M('bbs_cate')->getField('cid,cname');

		$this->assign('cid', $cid);
		$this->assign('cates', $cates);
		$this->display(); // View/Post/create.html
	}

	public function save()
	{
		$data = $_POST;

		// 发帖人
		$data['uid'] =$_SESSION['userInfo']['uid'];

		// 创建时间,更新时间
		$data['updated_at'] = $data['created_at'] = time();

		$row = M('bbs_post')->add( $data );

		if ($row) {
			$this->success('帖子发布成功!', '/index.php?m=home&c=post&a=index&cid='.$data['cid']);
		} else {
			$this->error('帖子发布失败!');
		}
	}

	public function index($cid=3)
	{	
		$cid = empty($_GET['cid']) ? 1: $_GET['cid'];

		$condition = [];

		$Post = M('bbs_post');

		
		
		

		$cnt = $Post -> where($condition)->where("cid=$cid") -> count(); 

		$Page = new \Think\Page($cnt, 2);

		$html_page = $Page -> show();

	
		$posts = $Post
					   ->order("is_top desc,is_jing desc")
					   ->limit($Page->firstRow,$Page->listRows)
					   ->order( "updated_at desc")
					   ->select();

		if (!empty($_GET['title'])) {
			$condition['title'] = ['like', "%{$_GET['title']}%"];
			$posts = $Post->where($condition)
						  ->order("is_top desc,is_jing desc")
					      ->limit($Page->firstRow,$Page->listRows)
					      ->order( "updated_at desc")
					      ->select();
		} else {
			$posts = $Post->where("cid=$cid AND is_display=1")
						  ->order("is_top desc,is_jing desc")
					   	  ->limit($Page->firstRow,$Page->listRows)
					   	  ->order( "updated_at desc")
					      ->select();
		}
		
		
		// 获取数据
		// $posts = M('bbs_post')->where("cid=$cid AND is_display=1")->order( "updated_at desc")->select();

		// 获取所有用户信息
		$users = M('bbs_user')->getField('uid, uname');

		// 遍历显示
		$this->assign('posts', $posts);
		$this->assign('users', $users);
		$this->assign('html_page', $html_page);
		$this->display();
	}
}