<style lang="scss" scoped>
	@import "../../../static/seven_color.scss";
	.login_wrap{
		position: relative;
		z-index: 1000;
		height: 100vh;
		background-color: rgba(34,34,34,1);
		*{
			font-family: "chStyle";
		}
		.loginBox{
			width:500px;
			height:500px;
			position: absolute;
			box-shadow:0px 0px 1px $c1,
			0px 0px 2px $c2,
			0px 0px 4px $c3,
			0px 0px 8px $c4,
			0px 0px 16px $c5,
			0px 0px 32px $c6,
			0px 0px 64px $c7;
			border-radius: 10px;
			left: 0;
			right: 0;
			top: 0;
			bottom: 0;
			margin:auto;
			.bg{
				position: absolute;
				left: 0;
				right: 0;
				top: 0;
				bottom: 0;
				margin:auto;
				width: 98%;
				height: 98%;
				background-color: rgba(254, 225, 191,0.7);
				filter:blur(8px);
				-webkit-filter:blur(8px);
				z-index:0;
			}
			.back_home{
				user-select:none;
				-webkit-user-select:none;
				position: absolute;
				font-size: 24px;
				top: 55px;
				left: 40px;
				z-index: 20;
				cursor: default;
				border-radius: 4px;
				padding: 5px;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				-webkit-transition:  0.1s;
				-moz-transition:  0.1s;
				transition:  0.1s;
				box-shadow: 
				1px 1px 5px #222,
				3px 3px 5px #222,
				5px 5px 5px #222,
				6px 6px 10px #000;			
				&:active{
					color:#222;
					text-shadow: 0 0 10px #fff,
					0 0 20px  #fff,
					0 0 30px  #fff;
					box-shadow: 
					1px 1px 5px #222,
					2px 2px 10px #000;	
				}			
			}
			.login_box,.register_box{
				position: relative;
				z-index:1;
				height: 100%;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				p{
					font-size: 36px;
					color:#000;
					text-align: center;
				}
				>div{
					font-size: 24px;
					span{
						float: right;
					}
					.focus1{
						&:focus{
							border-color:$c1;
						}
					}
					.focus2{
						&:focus{
							border-color:$c2;
						}
					}
					.focus3{
						&:focus{
							border-color:$c3;
						}
					}
					.focus4{
						&:focus{
							border-color:$c4;
						}
					}
					.focus5{
						&:focus{
							border-color:$c5;
						}
					}
					.focus6{
						&:focus{
							border-color:$c6;
						}
					}
					.focus7{
						&:focus{
							border-color:$c7;
						}
					}
					.success{
						background-color: #13CE66;
					}
					.danger{
						background-color: #FF4949;
					}
					input{
						font-size: 20px;
						height: 24px;
						line-height: 24px;
						padding: 0 4px;
						float: right;
						margin-right: 100px;
						border:1px solid #222;
						outline: none;
						border-radius: 4px;
						background-color: rgba(200, 168, 255,0.3);
						transition:0.3s;
						-webkit-transition:0.3s;
						&::-webkit-input-placeholder{
							color:#888;
						}
						&::-moz-input-placeholder{
							color:#888;
						}
						&::-ms-input-placeholder{
							color:#888;
						}
					}
					&:after{
						content:"";
						display: block;
						clear: both;
					}
				}
			}
			.login_box{
				padding-top: 100px;
				.account{
					margin-top: 60px;
				}
				.password{
					margin-top: 20px;
				}
				.submit{
					background-color: #324057;
					cursor: default;
					width: 100px;
					text-align: center;
					height: 36px;
					line-height: 36px;
					border-radius: 4px;
					margin:40px auto 0px;
					color:#fff;
					&:hover{
						background-color:#1F2D3D;
					}
				}
				.notAccount{
					font-size: 16px;
					cursor: default;
					width: 200px;
					text-align: center;
					margin:20px auto 0;
					cursor: pointer;
				}
			}
			.register_box{
				padding-top: 50px;
				.userName{
					margin-top: 50px;
				}
				.account{
					margin-top: 16px;
				}
				.password{
					margin-top: 16px;
				}
				.repassword{
					margin-top: 16px;
				}
				.email{
					margin-top: 16px;
				}
				.submit{
					background-color: #324057;
					cursor: default;
					width: 100px;
					text-align: center;
					height: 36px;
					line-height: 36px;
					border-radius: 4px;
					margin:30px auto 0px;
					color:#fff;
					&:hover{
						background-color:#1F2D3D;
					}
				}
				.notAccount{
					font-size: 16px;
					cursor: default;
					width: 200px;
					text-align: center;
					margin:20px auto 0;
					cursor: pointer;
				}
			}
		}
	}
</style>

<template>
	<div class="login_wrap">
		<div class="loginBox">
			<div class="back_home" @click="backHome">返回</div>
			<div class="bg"></div>
			<div class="login_box" v-show="onoff">
				<p>登录</p>
				<div class="account">
					<input type="text" ref="ref1" v-model="login_acc">
					<span>账号：</span>
				</div>
				<div class="password">
					<input type="password" ref="ref2" v-model="login_pw">
					<span>密码：</span>
				</div>
				<div class="submit" @click="loginFn">登录</div>
				<div class="notAccount" @click="change_onoff">没有账号？点击申请</div>
			</div>
			<div class="register_box" v-show="!onoff">
				<p>注册</p>
				<div class="userName">
					<input type="text" ref="ref3" v-model="regis_un" :class="[regis_un_class]" placeholder="2-10位">
					<span>用户名：</span>
				</div>
				<div class="account">
					<input type="text" ref="ref4" v-model="regis_acc" :class="[regis_acc_class]" placeholder="8-16位，非中文">
					<span>账号：</span>
				</div>
				<div class="password">
					<input type="password" ref="ref5" v-model="regis_pw" :class="[regis_pw_class]" placeholder="8-16位">
					<span>密码：</span>
				</div>
				<div class="repassword">
					<input type="password" ref="ref6" v-model="regis_repw" :class="[regis_repw_class]">
					<span>重复密码：</span>
				</div>
				<div class="email">
					<input type="text" ref="ref7" v-model="regis_email" :class="[regis_email_class]">
					<span>邮箱：</span>
				</div>
				<div class="submit" @click="registerFn">注册</div>
				<div class="notAccount" @click="change_onoff">已有账号？点击登录</div>
			</div>
		</div>
	</div>
</template>

<script>
	// 引入JS的md5加密
	import {md5} from "../../util/md5.js";
	export default {
		name: 'loginPage',
		data () {
			return {
				onoff:true,
				changebg_arr:["ref3","ref4","ref5","ref6","ref7"],
				ref3_onoff:false,
				ref4_onoff:false,
				ref5_onoff:false,
				ref6_onoff:false,
				ref7_onoff:false,
				regis_un:"",
				regis_acc:"",
				regis_pw:"",
				regis_repw:"",
				regis_email:"",
			};
		},
		methods:{
			change_onoff(){
				this.onoff = !this.onoff;
			},
			loginFn(){
				this.$http({
					url:"http://www.tp.com/blog/home/index/login",
					method:"post",
					body:{
						acc:this.login_acc,
						pw:this.login_pw,
						cookie_value:md5(Math.ceil(Math.random() * 100 * Math.random()) + "")
					},
					emulateJSON: true
				}).then( (data) => {
					if( data.data.res === 1 ){
						// this.$router.push("/");
						location.href = "http://localhost:8080";
					}
					if( data.data.res === 4 ){
						alert('账号错误');
					}
					if( data.data.res === 2 ){
						alert('密码错误');
					}
					if( data.data.res === 3 ){
						alert('该账号未激活');
					}
				},(data) => {
					alert('登录失败');
				});
			},
			registerFn(){
				var post = () => {
					this.$http({
						url:"http://www.tp.com/blog/home/index/register",
						method:"post",
						body:{
							username:this.regis_un,
							account:this.regis_acc,
							password:this.regis_pw,
							email:this.regis_email,
						},
						emulateJSON: true
					}).then( (data) => {
						if(  data.data.res === 1  ){
							alert('邮件发送成功，请验证您的账户');
						}
						if( data.data.res === 3 ){
							alert('账号已存在');
						}
						if( data.data.res === 4 ){
							alert('用户名已存在');
						}
						if( data.data.res === 5 ){
							alert('您填写的邮箱已经注册过了');
						}
					},(data) => {
						alert('注册失败');
					});
				}

				//这里是前台验证
				let showerror = () => {
					alert('信息填写有误，请确认');
				}
				(this.regis_un_class === "success") &&
				(this.regis_acc_class === "success") &&
				(this.regis_pw_class === "success") &&
				(this.regis_repw_class === "success") &&
				(this.regis_email_class === "success") &&
				post();
				(this.regis_un_class === "success") &&
				(this.regis_acc_class === "success") &&
				(this.regis_pw_class === "success") &&
				(this.regis_repw_class === "success") &&
				(this.regis_email_class === "success") ||
				showerror();
			},
			backHome(){
				//vue-reouter的编程式路由，还是蛮好用的，七十就是利用的JS的history，稳稳当当弄完了自己的东西，开始干
				this.$router.push("/");
			}
		},
		watch:{
			regis_acc(val,oldVal){
				this.regis_acc = val.replace(/[\u4e00-\u9fa5]/g,"");
			}
		},
		computed:{
			regis_un_class(){
				if( this.ref3_onoff ){
					if( this.regis_un.replace(/(^\s*)|(\s*$)/g, "").length >= 2 && this.regis_un.replace(/(^\s*)|(\s*$)/g, "").length <= 10 ){
						return "success";
					}else{
						return "danger";
					}
				}
			},
			regis_acc_class(){
				if( this.ref4_onoff ){
					if( this.regis_acc.length >= 8 && this.regis_acc.length <= 16 && !/\s+/g.test( this.regis_acc) ){
						return "success";
					}else{
						return "danger";
					}
				}
			},
			regis_pw_class(){
				if( this.ref5_onoff ){
					if( this.regis_pw.length >= 8 && this.regis_pw.length <= 16){
						return "success";
					}else{
						return "danger";
					}
				}
			},
			regis_repw_class(){
				if( this.ref6_onoff ){
					if( this.regis_pw === this.regis_repw && this.regis_pw !== "" ){
						return "success";
					}else{
						return "danger";
					}
				}
			},
			regis_email_class(){
				if( this.ref7_onoff ){
					if( /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(this.regis_email)){
						return "success";
					}else{
						return "danger";
					}
				}
			}
		},
		mounted(){
			this.$refs.ref1.focus();
			for( let item in this.$refs ){
				this.changebg_arr.forEach((el,i) => {
					if( item === el ){
						let target = this.$refs[item];
						target.onfocus = () => {
							this[el + "_onoff"] = true;
						}
					}
				});
				if( /ref/.test(item) ){
					let target = this.$refs[item];
					target.classList.add("focus" + Math.ceil(Math.random() * 7));
					target.onblur = function() {
						this.classList.forEach((el,i) => {
							if( /focus/.test(el) ){
								this.classList.remove(el);
							}
						});
						this.classList.add("focus" + Math.ceil(Math.random() * 7));
					}
				}
			}
			
		},
	};
</script>