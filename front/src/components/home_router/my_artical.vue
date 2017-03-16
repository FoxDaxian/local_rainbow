<style lang="scss" scoped>
	.my_artical_wrap{
		float: right;
		background-color: #fff;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		.head{
			font-size: 30px;
			margin-bottom: 20px;
			padding:10px 0;
			padding-left: 8px;
			background-color: rgb(32, 160, 255);
			vertical-align: middle;
			color:#fff;
			position: fixed;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			top: 0;
			z-index: 999;
		}
		.artical_box{
			overflow-y:auto; 
			height: 100vh;
			position: relative;
			padding-top:70px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			.my_artical_list{
				font-size: 20px;
				margin:0 20px;
				margin-bottom: 26px;
				padding-bottom: 20px;
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				border-bottom: 1px solid #c1c1c1;
				&:hover{
					.other{
						.edit,.delete_this{
							display: block;
						}
					}
				}
				.title{
					margin-bottom: 12px;
				}
				.content{
					margin-bottom: 16px;
					padding: 0 5px;
					background-color: #f9f9f9;
					padding: 10px;
					line-height: 30px;
				}
				.other{
					&:after{
						content:"";
						display: block;
						clear: both;
					}
					.time{
						float: left;
					}
					.edit{
						color:rgb(19, 206, 102);
						cursor: pointer;
						display: none;
						float: right;
					}
					.delete_this{
						color:#FF4949;
						cursor: pointer;
						display: none;
						float: right;
						margin-right: 20px;
					}
				}
			}
			.noThing{
				width: 100%;
				height: 100%;
				position: absolute;
				top: 0;
				.content_box{
					font-size: 12px;
					position: absolute;
					left: 0;
					top: 0;
					right: 0;
					bottom: 0;
					margin:auto;
					width: 40em;
					height: 40em;
					.face{
						width: 24em;
						height: 24em;
						margin:0 auto;
						position: relative;
						.outline{
							position: absolute;
							width: 100%;
							height: 100%;
							box-shadow: 0 0 5px #c1c1c1;
							border-radius: 70% 50% 70% 80%;	
							transform:rotate(135deg);
							-ms-transform:rotate(135deg);
							-webkit-transform:rotate(135deg);
							top: -2em;
						}
						>div:not(.outline){
							position: absolute;
							border-radius: 100%;
							div{
								border-radius: 100%;
							}
							&:not(.mouth):after{
								content:"";
								display: block;
								position: absolute;
								height: 1.5em;
								width: 1.5em;
								background: -webkit-radial-gradient(#fff, #ccc, #ccc); 
								background: -o-radial-gradient(#fff, #ccc, #ccc); 
								background: -moz-radial-gradient(#fff, #ccc, #ccc);
								background: radial-gradient(#fff, #ccc, #ccc); 
								border-radius: 100%
							}
						}
						.l_eye{
							width: 5em;
							height: 5em;
							background-color: #222;
							left: 3em;
							top: 5em;
							&:after{
								left: 2em;
								top: 1em;
							}
							&:before{
								content:"";
								display: block;
								position: absolute;
								height: 2.7em;
								width: 2.7em;
								background-color: rgb(68, 106, 229);
								border-radius: 100%;
								border-radius: 80% 0 55% 50% / 55% 0 80% 50%;
								transform:rotate(-45deg);
								-ms-transform:rotate(-45deg);
								-webkit-transform:rotate(-45deg);
								top:8em;
								left: -1em;
								box-shadow: 0 0 20px #fff inset;
							}
						}
						.r_eye{
							width: 5em;
							height: 5em;
							background-color: #222;
							right: 3em;
							top: 5em;
							&:after{
								right: 2em;
								top: 1em;
							}
						}
						.mouth{
							bottom: 4.5em;
							left: 50%;
							margin-left: -8em;
							width: 16em;
							height: 2em;
							overflow: hidden;
							>div{
								position: absolute;
								width: 100%;
							}
							.inner1{
								height: 16em;
								border:2px solid #222;
							}
							.inner2{
								top: 10px;
								height: 8em;
								border:2px solid #222;
							}
						}
					}
					.tips{
						font-size: 30px;
						text-align: center;
						div{
							margin-top: 20px;
							margin-bottom: 20px;
						}
					}
				}
			}
		}
	}
</style>

<template>
	<div class="my_artical_wrap" :style="{width:autoWidth + 'px'}">
		<div class="head" :style="{width:autoWidth + 'px'}" v-text="doc_title"></div>
		<div class="artical_box">
			<div class="my_artical_list" v-for="(item,index) in artical_arr">
				<div class="title" v-text="item.title"></div>
				<div class="content">
					{{escape2Html(item.content).replace(/(\<.+?\>)/g,"").length > 100 ? escape2Html(item.content).replace(/(\<.+?\>)/g,"").substr(0,100) + "..." : escape2Html(item.content).replace(/(\<.+?\>)/g,"") }}
				</div>
				<div class="other">				
					<div class="time" v-text="format_time(item.release_time)"></div>
					<router-link :to="{path:'edit',query:{key:item.id}}" class="edit">编辑</router-link>
					<div class="delete_this" @click="delete_this(item.id)">取消发布并删除</div>
				</div>
			</div>
			<div class="noThing" v-if="artical_arr !== null && artical_arr.length === 0">
				<div class="content_box">
					<div class="face">
						<div class="outline"></div>
						<div class="l_eye"></div>
						<div class="r_eye"></div>
						<div class="mouth">
							<div class="inner1"></div>
							<div class="inner2"></div>
						</div>
					</div>
					<div class="tips">
						<div>您还没有任何发表博文！</div>
						<router-link to="/home/write" class="myBtn">发一篇？</router-link>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</template>

<script>
	export default {

		name: 'my_artical',

		data () {
			return {
				
			};
		},
		computed:{
			user_data(){
				return this.$store.state.userInfo;
			},
			autoWidth(){
				return 710;
			},
			doc_title(){
				return document.title;
			},
			all_artical(){
				return this.$store.state.articalData;
			},
			artical_arr(){//当前作者的文章
				let user_artical_arr = [];
				for( let item in this.all_artical){
					(this.all_artical[item].user_id = this.user_data.id) && user_artical_arr.push(this.all_artical[item]);
				}
				return user_artical_arr;
			}
		},
		methods:{
			format_time(time_stamp){
				let time = new Date(+time_stamp),
				year = "".substr.call(time.getFullYear(),2,4),
				month = time.getMonth() + 1,
				day = time.getDate(),
				hour = time.getHours() > 9 ? time.getHours() : "0" + time.getHours(),
				minute = time.getMinutes() > 9 ? time.getMinutes() : "0" + time.getMinutes(),
				second = time.getSeconds() > 9 ? time.getSeconds() : "0" + time.getSeconds();
				return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
			},
			delete_this(id){
				this.$http({
					url:"http://www.tp.com/blog/home/index/delete_artical",
					method:"post",
					body:{
						artical_id:id,
					},
					emulateJSON: true,
				}).then( (data) => {
					this.$store.commit("delete_artical",id);
					if( data.data.res === 1 ){
						console.log("删除成功");
					}
					if( data.data.res === 2 ){
						console.log("检测不到删除");
					}
					if( data.data.res === 0 ){
						console.log("服务器错误");
					}
				},(data) => {
					console.error("请求失败，来自my_artical.vue");
				});				
			}
		},
		mounted(){
			
			//取消了http请求，转为从vuex存储的全部文章数据中获取数据
			// this.$http({
			// 	url:"http://www.tp.com/blog/home/index/get_user_all_artical",
			// 	method:"post",
			// 	body:{
			// 		id:this.user_data.id,
			// 	},
			// 	emulateJSON: true,
			// }).then( (data) => {
			// 	if( data.data.res === 0 ){
			// 		this.artical_arr = null;
			// 	}else{
			// 		console.log(data.data.res);
			// 		this.artical_arr  = data.data.res;
			// 	}
			// },(data) => {
			// 	console.error("请求失败，来自my_artical.vue");
			// });
		}
	};
</script>