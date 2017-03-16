<style lang="scss" scoped>
	@import "../../static/seven_color.scss";
	.head_wrap{
		height: 50px;
		position: relative;
		&:after{
			content:"";
			display: block;
			clear: both;
		}
		.centerBox{
			width: 1024px;
			height: 100%;
			margin:0 auto;
			.filter_bg{
				height: 150%;
				background: -webkit-linear-gradient(#222222 60%, #ffffff); 
				background: -o-linear-gradient(#222222 60%, #ffffff);
				background: -moz-linear-gradient(#222222 60%, #ffffff);
				background: linear-gradient(#222222 60%, #ffffff);
				position: absolute;
				width: 100%;
				left: 0px;
				top: 0px;
				z-index:-1;
				filter:blur(8px);
				-webkit-filter:blur(8px);
			}
			@keyframes loop_bg{
				from {
					background-position: 0 0;
				}
				to {
					background-position: 50px 0;
				}
			}
			@-webkit-keyframes loop_bg{
				from {
					background-position: 0 0;
				}
				to {
					background-position: 50px 0;
				}
			}
			.loop_bg{
				filter:blur(1px);
				-webkit-filter:blur(1px);
				height: 100%;
				width: 10px;
				background: -webkit-linear-gradient(left,#FF0000 , #FF7F00,#FFFF00 ,#00FF00 ,#00FFFF ,#0000FF,#8B00FF,#FF0000 ); 
				background: -o-linear-gradient(right,#FF0000 , #FF7F00,#FFFF00 ,#00FF00 ,#00FFFF ,#0000FF,#8B00FF,#FF0000 );
				background: -moz-linear-gradient(right,#FF0000 , #FF7F00,#FFFF00 ,#00FF00 ,#00FFFF ,#0000FF,#8B00FF,#FF0000 );
				background: linear-gradient(to right,#FF0000 , #FF7F00,#FFFF00 ,#00FF00 ,#00FFFF ,#0000FF,#8B00FF,#FF0000 );
				animation:loop_bg 1.5s linear infinite;
				-webkit-animation:loop_bg 1.5s linear infinite;
				border-radius: 2px;
			}
			.logo{
				float: left;
				height: 100%;
				margin-left: 20px;
				font-size: 0;
				user-select:none;
				-moz-user-select: none;
				-webkit-user-select: none;
				-ms-user-select: none;
				span{
					font-family: "enStyle";
					font-size: 50px;
					color:#000;
					transition:0.2s;
					-webkit-transition:0.2s;
					-moz-transition:0.2s;
					-o-transition:0.2s;
					&:hover{
						color:#fff;
						cursor: default;
					}
				}
			}
			.loop_bg_l{
				float: left;
			}
			.loop_bg_r{
				float: right;
			}
			.userInfo{
				float: right;
				height: 100%;
				padding:0 20px;
				line-height: 400%;
				.noLog_state{
					font-size: 24px;
					cursor: pointer;
					.toLogin{
						color:#FFF;
						font-family: "chStyle";
					}
				}
				.logged_state{
					margin-right: 50px;					
					width: 120px;
					position: relative;
					.head_img{
						box-sizing: border-box;
						-moz-box-sizing: border-box;
						position: relative;
						height: 52px;
						text-align: center;
						img{
							position: relative;
							width: 50px;
							border-radius: 50%;
						}
					}
					.options{
						transform:translateY(100px);
						overflow: hidden;
						transition:0.3s;
						-webkit-transition:0.3s;
						position: absolute;
						z-index: 1111111111;
						top: 50%;
						left: 50%;
						box-shadow: 0 0 5px #c1c1c1;
						width: 0;
						height: 0;
						>div{
							width: 200px;
							height: 50px;
							position: relative;
							z-index: 100;
						}
						.blur_bg{
							position: absolute;
							width: 100%;
							height: 100%;
							z-index: 10;
							background-color: rgba(255,255,255,0.7);
							-webkit-filter: blur(30px);
							-moz-filter: blur(30px);
							-ms-filter: blur(30px);    
							filter: blur(30px);
						}
						.user_wrap{
							border-bottom: 1px solid rgb(34,34,34);
							margin-top: 10px;
							&:after{
								content:"";
								display: block;
								clear: both;
							}
							.user_name{
								margin-left: 10px;
								font-size: 26px;
								float: left;
							}
							.log_out{
								margin-right: 10px;
								font-size: 14px;
								float: right;
								cursor: pointer;
								&:hover{
									color:rgb(32, 160, 255);
								}
							}
						}
						.home{
							text-align: center;
							font-size: 30px;
							margin-top: 8px;
							cursor: pointer;
							position: relative;
							z-index: 1000;
							display: inline-block;
							width: 100%;
							&:hover{
								color:rgb(32, 160, 255);
							}
						}
					}
					.options_show{
						width:  200px;
						margin-left: -100px;
						height: 120px;
						margin-top: -60px;
					}
				}
			}
		}
	}
</style>

<template>
	<div class="head_wrap">
		<div class="centerBox">
			<div class="filter_bg"></div>
			<div class="loop_bg loop_bg_l"></div>
			<div class="logo">
				<span class="rd1">R</span>
				<span class="rd2">a</span>
				<span class="rd3">i</span>
				<span class="rd4">n</span>
				<span class="rd5">b</span>
				<span class="rd6">o</span>
				<span class="rd7">w</span>
			</div>
			<div class="loop_bg loop_bg_r"></div>
			<div class="userInfo">
				<div class="logged_state" v-if="userData">
					<div class="head_img myBtn" @click="show_options">
						<img src="../../static/default_head.png" alt="">
					</div>
					<div class="options" :class="{'options_show':options_onoff}">
						<div class="blur_bg"></div>
						<div class="user_wrap">
							<div class="user_name">
								{{userData.username.length > 4 ? userData.username.substr(0,3) + "..." : userData.username}}
							</div>
							<div class="log_out" @click="log_out">退出登录</div>
						</div>
						<div class="home" @click="to_home">我的主页</div>
					</div>
				</div>
				<div class="noLog_state" v-else>
					<router-link to="login" class="toLogin" :class="loginCN">请登录</router-link>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'login_head',
		data () {
			return {
				options_onoff:false,
				loginCN_index:Math.ceil(Math.random() * 7),
			};
		},
		computed:{
			loginCN(){
				return {
					rd1:this.loginCN_index === 1,
					rd2:this.loginCN_index === 2,
					rd3:this.loginCN_index === 3,
					rd4:this.loginCN_index === 4,
					rd5:this.loginCN_index === 5,
					rd6:this.loginCN_index === 6,
					rd7:this.loginCN_index === 7,
				}
			},
			userData(){
				return this.$store.state.userInfo;
			}
		},
		watch:{

		},
		methods:{
			log_out(){
				if( !confirm("确认退么？") ){
					return false;
				}
				this.$store.commit("log_out");
				this.$http({
					url:"http://www.tp.com/blog/home/index/log_out",
					method:"get"
				}).then( ( data ) => {
					if( data.data.res === 1 ){
						alert('已退出');
					}
					if( data.data.res === 2 ){
						console.error("来自服务器的错误,login_head.vue");
					}
				}, ( data ) => {
					console.error("ajax请求错误，来自login_head.vue");
				});
			},
			show_options(e){
				var ev = e || window.event;
				this.options_onoff = !this.options_onoff;
				if( ev.stopPropagation ){
					ev.stopPropagation();
				}else{
					window.event.cancelBubble = true;
				}
			},
			to_home(){
				this.$router.push('home');
				this.show_options();
			}
		},
		mounted(){
			if( document.querySelector('.toLogin') ){
				document.querySelector('.toLogin').onmouseout = () => {
					this.loginCN_index = Math.ceil(Math.random() * 7);
				}
			}
			window.addEventListener('click', (e) => {
				(e.target.id=== "app") && this.options_onoff && this.show_options();
			});
		},
	};
</script>