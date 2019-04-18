<?php
namespace Admin\Controller;

use Think\Controller;

class TieziController extends CommonController
{
    public function index()
    {

    	$condition = [];
    	$where     = [];
    	if (!empty($_GET['cid'])) {
			$condition['cid']= ['eq', "{$_GET['cid']}"];
		}

		if (!empty($_GET['title'])) {
			$condition['title'] = ['like', "%{$_GET['title']}%"];
		}

		if (!empty($_GET['uname'])) {
			$where['uname'] = ['like', "%{$_GET['uname']}%"];
		}

		$cates = M('bbs_cate')->select();	

		$users = M('bbs_user')->where($where)->getField('uid, uname');

		$uid   = implode(',', array_unique(array_keys($users)));
		$condition['uid'] = ['in', $uid];
		$Post  = M('bbs_post');

		$cnt   = $Post -> where($condition) -> count(); 

		$Page  = new \Think\Page($cnt, 5);

		$html_page = $Page -> show();
	
		$posts = $Post ->where($condition)
					   ->order("is_top desc,is_jing desc")
					   ->limit($Page->firstRow,$Page->listRows)
					   ->select();



		$this->assign('posts', $posts);
		$this->assign('users', $users);
		$this->assign('cates', $cates);
		$this->assign('html_page', $html_page);
        $this->display();
        
    }

    // 显示
    public function setDisplay()
    {
    	$pid = $_GET['pid'];
    	M('bbs_post')->where("pid=$pid")->save(['is_display'=>1]);
    	redirect('/index.php?m=admin&c=tiezi&a=index');
    }

    public function setHidden()
    {
    	$pid = $_GET['pid'];
    	M('bbs_post')->where("pid=$pid")->save(['is_display'=>0]);
    	redirect('/index.php?m=admin&c=tiezi&a=index');
    }

    public function setTop()
    {
    	$pid = $_GET['pid'];
    	M('bbs_post')->where("pid=$pid")->save(['is_top'=>1]);
    	redirect('/index.php?m=admin&c=tiezi&a=index');
    }

    public function setNotop()
    {
    	$pid = $_GET['pid'];
    	M('bbs_post')->where("pid=$pid")->save(['is_top'=>0]);
    	redirect('/index.php?m=admin&c=tiezi&a=index');
    }

    public function setJing()
    {
    	$pid = $_GET['pid'];
    	M('bbs_post')->where("pid=$pid")->save(['is_jing'=>1]);
    	redirect('/index.php?m=admin&c=tiezi&a=index');
    }

    public function setNojing()
    {
    	$pid = $_GET['pid'];
    	M('bbs_post')->where("pid=$pid")->save(['is_jing'=>0]);
    	redirect('/index.php?m=admin&c=tiezi&a=index');
    }

    public function del()
	{
		$pid = $_GET['pid'];
		
		$posts = M('bbs_post')->where("pid=$pid")->select();

		$row = M('bbs_post')->delete($pid);

		// if(empty($posts)) {

		// 	$replys = M('bbs_reply')->delete($pid);
		// }

		

		if ($row){
			M('bbs_reply')->where("pid=$pid")->delete();
			$this->success('删除用户成功!');
		} else {
			$this->error('删除用户失败!');
		}
	}

	public function edit()
	{	
		$pid = $_GET['pid'];

		$posts = M('bbs_post')->find($pid);

		$this->assign('posts', $posts);

		$this->display();
	}

	public function update()
	{	
		$pid = $_GET['pid'];

		$row = M('bbs_post')->where("pid=$pid")->save($_POST);


		if ($row) {
			$this->success('修改成功!', './index.php?m=admin&c=tiezi&a=index');
		} else {
			$this->error('修改失败!');
		}

	}



}

?>