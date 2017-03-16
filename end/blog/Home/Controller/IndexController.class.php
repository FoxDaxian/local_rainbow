<?php
namespace Home\Controller;
header("Content-Type:text/html; charset=utf-8");
//服务器端设置头，来响应浏览器能否发送cookie
header("Access-Control-Allow-Origin:  http://localhost:8080");
//不能设置*，要设置指定的
header("Access-Control-Allow-Credentials:true");//可以接受cookie
use Think\Controller;
//常量：域名
define("host",$_SERVER["HTTP_HOST"] );
class IndexController extends Controller {

	//登陆
	public function login(){
		$db = M("user_info");
		$data["acc"] = I("param.acc");
		$data["pw"] = I("param.pw");
		$data["cookie_value"] = I("param.cookie_value");
		$db_res = $db -> where("account='" . $data["acc"] . "'") -> select();
		if( $db_res[0] ){
			if( md5($data["pw"]) === $db_res[0]["password"] ){
				if( $db_res[0]["email_active"] === "1" ){
					
					
					// 选择记录登录信息数据表
					$record_login_db = M("record_login");
					//把记录登录信息cookie存入数据库
					$server_data["account"] = $data["acc"];
					$server_data["cookie"] = $data["cookie_value"];
					if( $record_login_db -> add($server_data) ){
						//把记录登录信息cookie存入服务器端
						cookie('record_login',$data["cookie_value"],'expire=604800');
						cookie('account',$data["acc"],'expire=604800');

						//成功
						$res["res"] = 1;
						$this -> ajaxReturn($res);
					}else{
						//cookie信息插入数据库失败
						$res["res"] = 0;
						$this -> ajaxReturn($res);
					}
				}else{
					// 未激活
					$res["res"] = 3;
					$this -> ajaxReturn($res);
				}
			}else{
				//密码错误
				$res["res"] = 2;
				$this -> ajaxReturn($res);
			}
		}else{
			// 账号错误
			$res["res"] = 4;
			$this -> ajaxReturn($res);
		}
		
	}
	//发送邮件验证，等等
	public function register(){

		$db = M("user_info");
		$email_code = md5(rand() * rand());
		$data["username"] = I("param.username");
		$data["account"] = I("param.account");
		$data["password"] = md5(I("param.password"));
		$data["email"] = I("param.email");
		$data["email_code"] = $email_code;

		if( $db -> where("account = '" . $data["account"] . "'" ) -> select() ){
			//账号重复
			$private_data["res"] = 3;
			$this -> ajaxReturn($private_data);
		}

		if( $db -> where("username = '" . $data["username"] . "'" ) -> select() ){
			//用户名重复
			$private_data["res"] = 4;
			$this -> ajaxReturn($private_data);
		}

		if( $db -> where("email = '" . $data["email"] . "'" ) -> select() ){
			//邮箱重复
			$private_data["res"] = 5;
			$this -> ajaxReturn($private_data);
		}
		if( $db -> add($data) ){
			$this -> sendemail($data["email"],"你好，欢迎注册",'<a style="font-size:20px;color:green;" href=http://' . host . '/blog/home/index/activation?key=' . $email_code . '&username=' . $data["username"] . '&account=' . $data["account"] . '>点击激活您的账户</a>');
		}else{
			//数据库出错
			$data["res"] = 2;
			$this -> ajaxReturn($data);
		}
	}
	//发送邮件
	protected function sendemail( $email_adress,$greeting,$email_content){
		if(!!SendMail($email_adress,$greeting,$email_content)){
			//邮件已发送
			$data["res"] = 1;
			$this -> ajaxReturn($data);
		}else  {
			//邮件发送失败
			$data["res"] = 0;
			$this -> ajaxReturn($data);
		}
	}
	//验证邮件，激活账户
	public function activation(){
		$db = M("user_info");
		$data= I("get.");
		//判断是否已激活，并进行激活
		if( $db -> where("email_code = '" . $data["key"] . "' AND  username = '" . $data["username"] . "' AND account = '" . $data["account"] . "'" ) -> select()[0]["email_active"] !== "0" ){
			echo "您的账户已激活";
		}else{
			$db_data['email_active'] = 1;
			if( $db -> where("email_code = '" . $data["key"] . "' AND  username = '" . $data["username"] . "' AND account = '" . $data["account"] . "'" ) -> save($db_data) ){
				$this -> display();
			}else{
				echo "激活失败，请重试";
			}
		}
	}

	//自动登录方法
	public function autoLogin(){
		if( empty($_COOKIE['record_login']) && empty($_COOKIE['account']) ){
			$data["res"] = 0;
			$this -> ajaxReturn($data);
		}else{
			// 选择记录登录信息数据表
			$record_login_db = M("record_login");
			if( $record_login_db -> where("account = '" . $_COOKIE['account'] . "' AND cookie = '" . $_COOKIE['record_login'] . "'" ) -> select() ){
				$db = M("user_info");
				$res = $db -> where( "account = '" . $_COOKIE['account'] . "'" ) -> select();

				$data["res"] = $res;
				$this -> ajaxReturn($data);
			}else{
				//您需要登录
				$data["res"] = 0;
				$this -> ajaxReturn($data);
			}
		}
	}

	//退出登录
	public function log_out(){
		$record_login_db = M("record_login");
		// 删除数据记录
		$result = $record_login_db ->where('1') -> delete();

		if($result !== false){
			//退出成功
			$data["res"] = 1;
			$this -> ajaxReturn($data);
		}else{
			//退出失败，未知错误
			$data["res"] = 0;
			$this -> ajaxReturn($data);
		}
	}

	//展示全站文章缩略
	public function allArtical(){
		$ajaxResult = array();
		$db = M("artical");
		$result = $db -> select();
		
		foreach($result as $item){ 
			//这个把文章作者添加到返回结果中
			$user_db = M("user_info");
			$temp = $user_db -> where( "id = '" . $item["user_id"] . "'" ) -> select();
			$item["username"] = $temp[0]["username"];


			//这个获取顶、踩、阅读量
			$about_db = M("about");
			$temp = $about_db -> where( "artical_id = '" . $item["id"] . "'" ) -> select();
			$item["up"] = $temp[0]["up"];
			$item["down"] = $temp[0]["down"];
			$item["look"] = $temp[0]["look"];

			//获取评论数
			$comment_db = M("comment");
			$condition["parent_id"] = 0;
			$condition["artical_id"] = $item["id"];
			$item["comment_count"] = $comment_db -> where($condition) -> count();


			array_push($ajaxResult,$item);
		}
		$this -> ajaxReturn($ajaxResult);
	}

	//顶
	public function toUp(){
		$db = M("about");
		$id = I("param.id");

		$operation["up"] = $db -> where( "artical_id = '" . $id . "'" ) -> select()[0]["up"] + 1;

		if( $db -> where( "artical_id = '" . $id . "'" ) -> save($operation) ){
			//成功
			$data["res"] = 1;
			$this -> ajaxReturn($data);
		}else{
			//失败
			$data["res"] = 0;
			$this -> ajaxReturn($data);
		}

	}

	//踩
	public function todown(){
		$db = M("about");
		$id = I("param.id");

		$operation["down"] = $db -> where( "artical_id = '" . $id . "'" ) -> select()[0]["down"] + 1;

		if( $db -> where( "artical_id = '" . $id . "'" ) -> save($operation) ){
			//成功
			$data["res"] = 1;
			$this -> ajaxReturn($data);
		}else{
			//失败
			$data["res"] = 0;
			$this -> ajaxReturn($data);
		}
	}



	//点击量
	public function increamentLook(){
		$db = M("about");
		$id = I("param.id");

		$operation["look"] = $db -> where( "artical_id = '" . $id . "'" ) -> select()[0]["look"] + 1;

		if( $db -> where( "artical_id = '" . $id . "'" ) -> save($operation) ){
			//成功
			$data["res"] = 1;
			$this -> ajaxReturn($data);
		}else{
			//失败
			$data["res"] = 0;
			$this -> ajaxReturn($data);
		}
	}


	//提交评论
	public function send_comment(){
		$comment_db = M("comment");
		$comment_data["artical_id"] = I("param.artical_id");
		$comment_data["user_id"] = I("param.user_id");
		$comment_data["comment_time"] = I("param.time");
		$comment_data["parent_id"] = I("param.parent_id");
		$comment_data["content"] = I("param.content");
		if( $comment_db->add($comment_data) ){
			//成功
			$data["res"] = 1;

			$condition['artical_id'] = $comment_data["artical_id"];
			$condition['user_id'] = $comment_data["user_id"];
			$condition['comment_time'] = $comment_data["comment_time"];
			$data["data"] = $comment_db -> where($condition) -> select();

			$for_user_name_db = M("user_info");
			$username = $for_user_name_db  -> where("id = " . $condition['user_id']) -> select()[0]["username"];
			$data["data"][0]["username"] = $username;

			$this -> ajaxReturn($data);
		}else{
			//失败
			$data["res"] = 2;
			$this -> ajaxReturn($data);
		}
	}

	//获取评论
	public function getComment(){
		$user_db = M("user_info");
		$comment_db = M("comment");
		$comment_data["artical_id"] = I("param.artical_id");
		$data["res"] = $comment_db -> where("artical_id = " . $comment_data["artical_id"]  ) -> select();
		foreach ($data["res"] as $key => &$value) {
			$user_info = $user_db -> where("id = " . $value["user_id"] ) -> select();
			$value["username"] = $user_info[0]["username"];
			//是不是赞了
			$value["can_star"] = false;
		}
		$this -> ajaxReturn($data);
	}

	//评论 -> 赞操作
	public function comment_up(){
		$comment_db = M("comment");
		$ajax["comment_id"] = I("param.comment_id");
		$star_count = $comment_db -> where("id = " . $ajax["comment_id"]) -> select()[0]["stars"] + 0;
		$data["stars"] = $star_count + 1;
		if( $comment_db -> where( "id = " . $ajax["comment_id"] ) -> save($data) ){
			$res["res"] = 1;
			$res["count"] = $star_count + 1;
			$this -> ajaxReturn($res);
		}else{
			$res["res"] = 0;
			$this -> ajaxReturn($res);
		}
	}

	//评论 -> 取消赞操作
	public function comment_down(){
		$comment_db = M("comment");
		$ajax["comment_id"] = I("param.comment_id");
		$star_count = $comment_db -> where("id = " . $ajax["comment_id"]) -> select()[0]["stars"] + 0;
		$data["stars"] = $star_count - 1;
		if( $comment_db -> where( "id = " . $ajax["comment_id"] ) -> save($data) ){
			$res["res"] = 1;
			$res["count"] = $star_count - 1;
			$this -> ajaxReturn($res);
		}else{
			$res["res"] = 0;
			$this -> ajaxReturn($res);
		}
	}

	//设置用户信息
	public function set_user_info(){
		$db = M("user_info");
		$get_data = I("param.");
		$id = $get_data["id"];
		array_shift($get_data);
		if( $db -> where("id = " . ($id + 0)) -> save($get_data) === 1 ){
			$res["res"] = 1;
			$this -> ajaxReturn($res);
		}else if( $db -> where("id = " . ($id + 0)) -> save($get_data) === 0 ){
			$res["res"] = 2;
			$this -> ajaxReturn($res);
		}else{
			$res["res"] = 0;
			$this -> ajaxReturn($res);
		}
	}

	//###
	//###
	//###
	//我的文章接口，获取当前用户的全部文章
	//该方法已被vue代替，暂留
	//###
	//###
	//###
	public function get_user_all_artical(){
		$db = M("artical");
		$key = I("param.")["id"];
		if( $res["res"] = $db -> where("user_id = " . $key) -> select() ){
			$this -> ajaxReturn($res);
		}else{
			$res["res"] = 0;
			$this -> ajaxReturn($res);
		}
	}


	//保存草稿
	public function save_draft(){
		$db = M("draft");
		$temp_data = I("param.");
		$data["user_id"] = $temp_data["id"];
		$data["title"] = $temp_data["title"];
		$data["content"] = $temp_data["content"];
		//如果找到有该用户的草稿
		if( $db -> where('user_id = ' . $data["user_id"]) -> select()  ){
			//并且保存不报错
			if( $db -> where('user_id = ' . $data["user_id"]) -> save($data) !== false ){
				$res["res"] = 1;
				$this -> ajaxReturn($res);
			}else{
				$res["res"] = 0;
				$this -> ajaxReturn($res);
			}
		}else{
			//否则就增加一条该用户的草稿到数据库
			if( $db -> add($data) ){
				$res["res"] = 1;
				$this -> ajaxReturn($res);
			}else{
				$res["res"] = 0;
				$this -> ajaxReturn($res);
			}
		}
	}

	//发表文章
	public function send_artical(){
		$db = M("artical");
		$temp_data = I("param.");
		$data["user_id"] = $temp_data["id"];
		$data["title"] = $temp_data["title"];
		$data["content"] = $temp_data["content"];
		$data["release_time"] = $temp_data["time"];
		if( $artical_id = $db -> add($data) ){
			$about_db = M("about");
			$about_data['artical_id'] = $artical_id;
			if( $about_db->add($about_data) ){
				$res["res"] = 1;
				$res["artical_id"] = $artical_id;
				$this -> ajaxReturn($res);
			}else{
				$res["res"] = 0;
				$this -> ajaxReturn($res);
			}
		}else{
			$res["res"] = 0;
			$this -> ajaxReturn($res);
		}
	}

	//获取草稿
	public function get_draft(){
		$db = M("draft");
		$temp_data = I("param.");
		$data["user_id"] = $temp_data["id"];
		//如果找到了就返回结果
		if( ($result = $db -> where('user_id = ' . $data["user_id"]) -> find()) !== false ){
			$res["res"] = 1;
			$res["res_data"] = $result;
			$this -> ajaxReturn($res);
		}else{
			//不然就返回0
			$res["res"] = 0;
			$this -> ajaxReturn($res);
		}
		
	}


	//保存修改
	public function save_modify(){
		$db = M("artical");

		$modify_data['title'] = I("param.")["title"];
		$modify_data['content'] = I("param.")["content"];

		$temp_res = $db -> where('id = ' . I("param.")["artical_id"]) -> save($modify_data);

		if( $temp_res === 1 ){//修改成功
			$res["res"] = 1;
			$this -> ajaxReturn($res);
		}

		if( $temp_res === 0 ){//无修改
			$res["res"] = 2;
			$this -> ajaxReturn($res);
		}

		if( $temp_res === 0 ){//修改失败
			$res["res"] = 0;
			$this -> ajaxReturn($res);
		}
	}


	//删除文章
	public function delete_artical(){
		$db = M("artical");
		$comment_db = M("comment");
		$temp_res = $db -> delete(I("param.")["artical_id"]);
		if( $temp_res === 1 ){//删除成功
			if( $comment_db -> where('artical_id = ' . I("param.")["artical_id"] ) -> delete() !== false ){
				$res["res"] = 1;
				$this -> ajaxReturn($res);
			}else{
				$res["res"] = 3;//删除被删除文章的评论失败
				$this -> ajaxReturn($res);
			}
		}
		

		if( $temp_res === 0 ){//无删除
			$res["res"] = 2;
			$this -> ajaxReturn($res);
		}

		if( $temp_res === 0 ){//删除失败
			$res["res"] = 0;
			$this -> ajaxReturn($res);
		}
	}


	//测试
	public function test(){
		var_dump("来自tp");
	}
}
