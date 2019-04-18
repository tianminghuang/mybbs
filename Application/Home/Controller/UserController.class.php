<?php
namespace Home\Controller;

use Think\Controller;
use Think\Image;

class UserController extends Controller
{
	public function edit1()
	{
		$uid = $_GET['uid'];

		$user = M('bbs_user')->find($uid);
		
		$arr = explode('/', $user['uface']);
		$arr[3] = 'sm_'.$arr[3];
		$user['uface'] = implode('/', $arr);

		$this->assign('user', $user);
		$this->display();
	}

	public function edit2()
	{
		$uid = $_GET['uid'];

		$user = M('bbs_user')->find($uid);
		
		$arr = explode('/', $user['uface']);
		$arr[3] = 'sm_'.$arr[3];
		$user['uface'] = implode('/', $arr);

		$this->assign('user', $user);
		$this->display();
	}

	public function pwdedit()
	{
		$uid = $_GET['uid'];
		$user = M('bbs_user')->find($uid);
		$this->assign('user', $user);
		$this->display();
	}

	public function update()
	{

		$uid = $_GET['uid'];

		$data = $_POST;

		if ($_FILES['uface']['error'] !== 4) {
            $data['uface'] = $this->doUp();
               $this->doSm();

         } 

		$row = M('bbs_user')->where("uid=$uid")->save($data);

		if ($row) {
			$user = M('bbs_user')->find($uid);
			$_SESSION['userInfo'] = $user;
			$this->success('用户信息修改成功!', './index.php?m=home&c=index&a=index');
		} else {
			$this->error('用户信息修改失败!');
		}
	}

	public function pwdupdate()
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