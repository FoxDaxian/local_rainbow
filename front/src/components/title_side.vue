<style lang="scss" scoped>
	.title_wrap{
		box-shadow: 0 0 2px #c1c1c1;
		float: left;
		width: 260px;
		margin-top: 50px;
		background-color: #fff;
		border-radius: 8px;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		padding: 50px 0  30px;
		.about_me{
			text-align: center;
			*{
				text-align: left;
			}
			img{
				border-radius: 50%;
			}
			p{
				text-align: center;
				font-size: 20px;
				margin-top: 20px;
			}
			.toKnow{
				text-align: center;
				font-size: 16px;
				margin-top: 8px;
				border-bottom: 1px solid #c1c1c1;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				padding-bottom: 20px;
				a{
					color:rgba(67, 149, 255,1)
				}
			}
		}
		.tools{
			margin-top: 40px;
			border-bottom: 1px solid #c1c1c1;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding-bottom: 20px;
			ul{
				li{
					text-align: center;
					margin-bottom: 16px;
					.likeA{
						transition:0.5s;
						-moz-transition:0.5s;
						-ms-transition:0.5s;
						-webkit-transition:0.5s;
						position: relative;
						left: 0px;
						font-size: 20px;
						&:hover{
							left: 10px;
							color:rgba(67, 149, 255,1)
						}
						&:after{
							content:"";
							width: 20px;
							height: 33px;
							background-image: url("../../static/water.png");
							background-size: cover;
							position: absolute;
							top: -8px;
							left: -30px;
						}
					}
				}
			}
		}
		.my_goal{
			margin-top: 20px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding-bottom: 20px;
			border-bottom: 1px solid #c1c1c1;
			text-align: center;
			.likeA{
				transition:0.3s;
				-webkit-transition:0.3s;
				-moz-transition:0.3s;
				-ms-transition:0.3s;
				font-size: 20px;
				font-weight: bold;
				color:#fff;
				text-shadow:0 0 1px #000;
				&:hover{
					color:rgb(255, 73, 73);
					text-shadow: 0 0 2px #fff,
					0 0 5px  #fff,
					0 0 8px  #fff,
					0 0 15px  #FF1177,
					0 0 30px  #FF1177,
					0 0 40px  #FF1177,
					0 0 50px #FF1177,
					0 0 60px #FF1177;
				}
			}
		}
		.time{
			margin-top: 10px;
			height: 78px;
			overflow: hidden;
			embed{
				position: relative;
				top: -28px;
				width: 100%;
			}
		}
		.my_label{
			cursor: default;
			margin-top: 20px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding:0 6px 20px;
			border-bottom: 1px solid #c1c1c1;
			p{
				font-size: 18px;
			}
			ul{
				margin-top: 10px;
				display: flex;
				flex-wrap:wrap;
				justify-content:space-around;
				&:after{
					content:"";
					display: block;
					clear: both;
				}
				li{
					margin:0 3px 4px 0;
					font-size: 16px;
					float: left;
					padding: 4px 8px;
					background-color: #e3f0f4;
					color:#4078c0;
				}
			}
		}
		.my_config{
			margin-top: 30px;
			ul{
				text-align: center;
				li{
					display: inline-block;
					margin: 0 5px;
					position: relative;
					&:hover{
						img{
							width: 300px;
							height: 300px;
						}
					}
					a{
						font-size: 20px;
					}
					img{
						transition:0.5s;
						-webkit-transition:0.5s;
						position: absolute;
						bottom: 40px;
						left: 80px;
						width: 0px;
						height: 0px;
						border:1px solid #c1c1c1;
						border-radius: 14px;
						z-index: 10000;
					}
				}
			}
		}
	}
</style>

<template>
	<div class="title_wrap">
		<div class="about_me">
			<img src="../../static/me.jpg" alt="大西瓜">
			<p>我有代码还有你！</p>
			<div class="toKnow">想了解我？<router-link to="about_me">点我</router-link></div>
		</div>
		<div class="tools">
			<ul>
				<li v-for="(item,index) in tools">
					<!-- 暂时用av170001代替了 -->
					<a :href="item.url" class="likeA" v-text="item.name" target="_blank"></a>
					<!-- <router-link :to="item.url" class="likeA" v-text="item.name"></router-link> -->
				</li>
			</ul>
		</div>
		<div class="my_goal">
			<router-link to="#" class="likeA">我的{{year}}年目标</router-link>
		</div>
		<div class="time">
			<embed src="http://chabudai.sakura.ne.jp/blogparts/honehoneclock/honehone_clock_wh.swf" type="">
			</div>
			<div class="my_label">
				<p>我的标签：</p>
				<ul>
					<li v-for="(item,index) in label" v-text="item"></li>
				</ul>
			</div>
			<div class="my_config">
				<ul>
					<li v-for="(item,index) in Websites">
						<a :href="item.url" title="换成图标" v-text="item.name" target="_blank"></a>
						<img :src="item.src" alt="" v-if="item.src">
					</li>
				</ul>
			</div>
		</div>
	</template>

	<script>
		export default {
			name: 'title_side',
			data () {
				return {
					year:new Date().getFullYear(),
					tools:[{
						name:"实用工具",
						url:"http://www.bilibili.com/video/av170001/index_2.html"
					},{
						name:"技术前沿",
						url:"http://www.bilibili.com/video/av170001/index_2.html"
					},{
						name:"推荐书籍",
						url:"http://www.bilibili.com/video/av170001/index_2.html"
					},{
						name:"素材在这",
						url:"http://www.bilibili.com/video/av170001/index_2.html"
					},{
						name:"心灵鸡汤",
						url:"http://www.bilibili.com/video/av170001/index_2.html"
					}],
					label:["前端","php","tp","mysql","运动健身","养生","酷！","毅力"],
					Websites:[{
						name:"github",
						url:"https://github.com/a13821190779"
					},{
						name:"简书",
						url:"http://www.jianshu.com/u/a06400d06b38"
					},{
						name:"微信",
						src:"../../static/qr_code.jpg"
					}]
				};
			}
		};
	</script>