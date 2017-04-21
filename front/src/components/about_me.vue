<style lang="scss" scoped>
	.wrap{
		width: 1024px;
		margin:0 auto;
		.img_info{
			margin-top: 50px;
			overflow: hidden;
			position: relative;
			>div{
				float: left;
			}
			.head{
				position: absolute;
				height: 100%;
				img{
					height: 100%;
				}
			}
			.person_information{
				float: right;
				font-size: 26px;
				overflow: hidden;
				>div{
					float: left;
					>div{
						margin-bottom: 26px;
						span{
							display: inline-block;
						}
						span:nth-of-type(1){
							width: 50px;
							margin-right: 30px;
							i{
								font-size: 50px;
							}
						}
						span:nth-of-type(2){
							position: relative;
							bottom: 10px;
						}
					}
					.github,.email{
						margin-bottom: 0;
					}
				}
				.left{
					margin-right: 150px;
					.name{

					}
					.adress{

					}
					.github{
						&:hover{
							color:rgb(52, 133, 251);
							.to_github{
								color:rgb(52, 133, 251);
							}
						}
					}
				}
				.right{
					float: right;
					.age{

					}
					.phone{

					}
					.email{

					}
				}
			}
		}
		.hobby{
			margin-top: 50px;
			p{
				margin-top: 10px;
				font-size: 20px;
			}
			p:nth-of-type(1){
				font-size: 30px;
			}
		}
	}
</style>

<template>
	<div class="wrap">
		<div class="img_info">
			<div class="head">
				<img src="../../static/me.jpg"  alt="">
			</div>
			<div class="person_information">
				<div class="left">
					<div class="name">
						<span><i class="icon iconfont icon-User_name"></i></span><span>狐狸</span>
					</div>
					<div class="adress">
						<span><i class="icon iconfont icon-adress-second"></i></span><span>天津</span>
					</div>
					<div class="github">
						<span> <i class="icon iconfont icon-github"></i></span><span><a target="_blank" class="to_github" href="https://github.com/a13821190779">点击跳转</a></span>
					</div>
				</div>
				<div class="right">
					<div class="age">
						<span><i class="icon iconfont icon-nianling"></i></span><span>24</span>
					</div>
					<div class="phone">
						<span><i class="icon iconfont icon-dianhua"></i></span><span>15122160991</span>
					</div>
					<div class="email">
						<span><i class="icon iconfont icon-Email"></i></span><span>945039036@qq.com</span>
					</div>
				</div>
			</div>
		</div>
		<div class="hobby">
			<p>个人爱好：</p>
			<p>打篮球啊，玩游戏啊，健身啊，游泳啊，敲代码啊，听歌啊，看电影啊....</p>
			<p>喜欢自己喜欢的东西，人，一切！</p>
			<p>暂时就这些了...</p>
		</div>
		<div class="person_skill">
			个人技能专栏，用那个传奇（中文意思像）的属性写
		</div>
	</div>
</template>

<script>
	import "../../static/alibb_icon/demo.css";
	import "../../static/alibb_icon/iconfont.css";
	export default {

		name: 'about_me',

		data () {
			return {
				
			};
		},
		mounted(){
			
		}
	};
</script>