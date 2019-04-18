<?php
namespace Admin\Controller;

use Think\Controller;
// use Think\Page;
use Think\Image;

class UserController extends CommonController
{	
	private $filename;

	// 显示表单
	public function create()
	{
		$this->display();
    }

	// 接收表单数据，保存到数据库
    public function save()
    {
        $data = $_POST;
        $data['created_at'] = time(); // 添加时间

        // 密码不能为空
        if (empty($data['upwd']) || empty($data['reupwd'])){
        	$this->error('密码不能为空');
        }

        // 两次密码不一致
        if ($data['upwd'] !== $data['reupwd']) {
        	$this->error('两次密码不一致!');
        }

       // 加密密码
        $data['upwd'] = password_hash($data['upwd'], PASSWORD_DEFAULT);

       // 文件上传处理
		$data['uface'] = $this->doUp();
       // $upload = new \Think\Upload($config); // 实例化上传

       // $info = $upload->upload();

       // if(!$info){
       // 		上传错误提示错误信息
       // 		
       // 		如果 error==4 就跳过上传处理
       // 		$this->error($upload->getError());
       // } else {
       	// echo '<pre>';
       	// print_r($info);
       	// die;
       // 		$this->success('上传成功!');
       //} 

       // 拼接上传文件的完整名称
       //$filename = $info['uface']['savepath'].$info['uface']['savename'];

       // 生成缩略图

		$this->doSm();
	   // 拼接一个缩略图名称
       //$thumb_name = $info['uface']['savepath'].'sm_'.$info['uface']['savename'];

       // 打开 $filename 文件, 后续进行处理

        // 添加到数据库,返回一个受影响函数行数
        $row = M('bbs_user')->add( $data );

        if ($row) {
        	$this->success('添加用户成功!');
        } else {
        	$this->error('添加用户失败!');
        }
	}

	// 查看用户
	public function index()
	{	
		// 定义一个空的条件数组
		$condition = [];

		// 判断有没有性别条件	 select * from bbs_user where sex='w'; eq 为表达式的 = 
		if (!empty($_GET['sex'])) {
			$condition['sex'] = ['eq', "{$_GET['sex']}"];
		}

		// 判断有没有姓名条件  select * from bbs_user where uname like "%a%";
		if (!empty($_GET['uname'])) {
			$condition['uname'] = ['like', "%{$_GET['uname']}%"];
		}

		// 实例化一个表对象
		$User = M('bbs_user');

		// 得到满足条件的总记录数
		$cnt = $User -> where($condition) -> count(); 

		// 实例化分页类 传入总记录数和每页显示的记录数(3)
		$Page = new \Think\Page($cnt, 3);

		// 得到分页显示html代码
		$html_page = $Page -> show();

		// 获取数据
		$users = $User ->where($condition)
					   ->limit($Page->firstRow,$Page->listRows)
					   ->select();

		foreach($users as $k=>$v){
			$arr = explode('/', $v['uface']);
			$arr[3] = 'sm_'.$arr[3];
			$users[$k]['uface'] = implode('/', $arr);
		}

		// 遍历显示
		$this->assign('users',$users);
		$this->assign('html_page',$html_page);
		$this->display();  // 在View/User/index.html
	}


	// 删除指定用户
	function del()
	{
		$uid = $_GET['uid']; // 指定要删除的用户
		$row1 = M('bbs_post')->where("uid=$uid")->delete();

		// 进行删除操作
		$row = M('bbs_user')->delete($uid);

		if ($row && $row1){
			$this->success('删除用户成功!');
		} else {
			$this->error('删除用户失败!');
		}
	}

	// 在表单显示原有数据
	public function edit()
	{
		$uid = $_GET['uid'];

		$user = M('bbs_user')->find($uid);

		// echo '<pre>';
		// print_r($user);
		// die;

		$arr = explode('/', $user['uface']);
		$arr[3] = 'sm_'.$arr[3];
		$user['uface'] = implode('/', $arr);

		//echo '<pre>';
		//print_r($user);

		$this->assign('user', $user);
		$this->display();
	}

	public function update()
	{
		// echo '<pre>';
		// print_r($_GET);
		// print_r($_POST);
		$uid = $_GET['uid'];  //获取用户ID
		$data = $_POST;

        if ($_FILES['uface']['error'] !== 4) {
            $data['uface'] = $this->doUp();
               $this->doSm();

         }      

		$row = M('bbs_user')->where("uid=$uid")->save($data);


		if ($row) {
			$this->success('用户信息修改成功!', './index.php?m=admin&c=user&a=index');
		} else {
			$this->error('用户信息修改失败!');
		}
	}

	// 密码修改
	public function pwdedit()
	{	
		$uid = $_GET['uid'];
		$user = M('bbs_user')->find($uid);
		$this->assign('user', $user);
		$this->display();
	}

	public function update2()
	{	
		$uid = $_GET['uid'];
		$data = $_POST;
        $users = M('bbs_user')->find($uid);

        if (empty($data['upwd'])||empty($data['reupwd'])||empty($data['nupwd'])){
        	$this->error('密码不能为空');
        }

		if (!password_verify($data['upwd'], $users['upwd'])) {
        	$this->error('密码错误!');
        }

        if ($data['upwd'] !== $data['reupwd']) {
        	$this->error('两次密码不一致!');
        }

        $data['upwd'] = password_hash($data['nupwd'], PASSWORD_DEFAULT);

        $row = M('bbs_user')->where("uid=$uid")->save( $data );

        if ($row) {
        	$this->success('修改密码成功!');
        } else {
        	$this->error('修改密码失败!');
        }
	}

	// 护理上传文件
	private function doUp()
	{
		$config = array(
       			'maxSize' => 3145728,
       			'rootPath' => './',
       			'savePath' => 'Public/Uploads/',
       			'saveName' => array('uniqid',''),
       			'exts' => array('jpg','gif','png','jpeg'),
       			'autoSub' => true,
       			'subName' => array('date', 'Ymd'),
       );

       $up = new \Think\Upload($config);

       $info = $up->upload();

       if(!$info){
       		echo $up->getError();
       		die;
       }

       return $this->filename = $info['uface']['savepath'].$info['uface']['savename'];
	}
	// 生成缩略图
	private function doSm()
	{
		$image = new Image(Image::IMAGE_GD, $this->filename);
    	$image->thumb(150,150)->save('./'.getSm($this->filename) );
	}
}