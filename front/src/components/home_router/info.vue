<style lang="scss" scoped>
	.info_wrap{
		float: right;
		width: 710px;
		background-color: #fff;
		box-shadow: 0 0 2px #c1c1c1;
		border-radius: 8px;
		height: 100vh;
		position: relative;
		.head{
			width: 710px;
			font-size: 30px;
			margin-bottom: 20px;
			padding:10px 0;
			padding-left: 8px;
			background-color: rgb(32, 160, 255);
			vertical-align: middle;
			color:#fff;
			position: relative;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			top: 0;
			z-index: 999;
		}
		>div{
			font-size: 30px;
		}
		@keyframes blink{
			0% {
				opacity:1;
			}
			25% {
				opacity:0;
			}
			50% {
				opacity:1;
			}
			75% {
				opacity:0;
			}
			100% {
				opacity:1;
			}
		}
		@-webkit-keyframes blink{
			0% {
				opacity:1;
			}
			25% {
				opacity:0;
			}
			50% {
				opacity:1;
			}
			75% {
				opacity:0;
			}
			100% {
				opacity:1;
			}
		}
		>div:not(.head){
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			width: 500px;
			margin:50px auto 0;
			.right_wrong{
				margin-left: 16px;
				i{
					position: absolute;
					vertical-align:middle;
				}
			}
			.blink-enter-active {
				animation:blink 1s;
				-webkit-animation:blink 1s
			}
			.btn{
				position: relative;
				top: -3px;
				margin-left: 20px;
			}
		}
		.user_name_wrap{
			.user_name{
				border:none;
				outline: none;
				border:1px solid #000;
				height: 30px;
				line-height: 30px;
				font-size: 20px;
				vertical-align:middle;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				padding:5px 10px;
				width: 260px;
			}
		}
		.email_wrap{
			padding-left: 30px;
			.email{
				border:none;
				outline: none;
				border:1px solid #000;
				height: 30px;
				line-height: 30px;
				font-size: 20px;
				vertical-align:middle;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				padding:5px 10px;
				width: 260px;
			}
		}
	}
</style>

<template>
	<div class="info_wrap">
		<div class="head" v-text="doc_title"></div>
		<div class="user_name_wrap">
			<span>用户名：</span>
			<input type="text" v-model="user_data.username" class="user_name" placeholder="2-10位">
			<span @click="set_un" class="btn myBtn">修改</span>
			<span class="right_wrong">
				<transition name="blink" mode="out-in">
					<i class="green" v-if="un_check === '成功'">图标</i>
				</transition>
				<transition name="blink" mode="out-in">
					<i class="red" v-if="un_check === '失败'">图标</i>
				</transition>
			</span>
		</div>
		<div class="email_wrap">
			<span>邮箱：</span>
			<input type="text" v-model="user_data.email" class="email" placeholder="请务必填写正确email">
			<span @click="set_email" class="btn myBtn">修改</span>
			<span class="right_wrong">
				<transition name="blink" mode="out-in">
					<i class="green" v-if="email === '成功'">图标</i>
				</transition>
				<transition name="blink" mode="out-in">
					<i class="red" v-if="email === '失败'">图标</i>
				</transition>
			</span>
		</div>
		
	</div>
</template>

<script>
	export default {

		name: 'info',

		data () {
			return {
				un_check:false,
				email:false,
				temp_un:this.$store.state.userInfo.username,//由于双向绑定的原因，所以加上临时变量，存储之前的名字，失败的时候复原
				temp_email:this.$store.state.userInfo.email,//同上，email
			};
		},
		computed:{
			user_data(){
				return this.$store.state.userInfo;
			},
			doc_title(){
				return document.title;
			}
		},
		methods:{
			set_un(){
				if( this.user_data.username.replace(/(^\s*)|(\s*$)/g, "").length >= 2 && this.user_data.username.replace(/(^\s*)|(\s*$)/g, "").length <= 10 ){
					this.ajax("username",this.user_data.username,"un_check");
				}else{
					this.user_data.username = this.temp_un;
					this.un_check = "失败";
				}
			},
			set_email(){
				if( /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(this.user_data.email)){
					this.ajax("email",this.user_data.email,"email");
				}else{
					this.user_data.email = this.temp_email;
					this.email = "失败";
				}
			},
			ajax(key,value,to_change){
				this.$http({
					url:"http://www.tp.com/blog/home/index/set_user_info",
					method:"post",
					body:{
						id:this.user_data.id,
						[key]:value
					},
					emulateJSON: true,
				}).then( (data) => {
					if( data.data.res === 1 ){
						this[to_change] = "成功";
						this.$store.commit("set_articalData_username",{
							id:this.$store.state.userInfo.id,
							name:value
						});
					}else if( data.data.res === 2 ){
						alert('系统未检测到修改');
						this[to_change] || (this[to_change] = false);
					}else{
						this[to_change] = "失败";
					}
				},(data) => {
					console.error("请求失败，来自info.vue");
				});
			}
		},
		mounted(){
			
		}
	};
</script>