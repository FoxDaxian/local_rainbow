<style lang="scss" scoped>
	.artical_detail_wrap{
		float: right;
		width: 710px;
		margin-top: 50px;
		box-shadow: 0 0 2px #c1c1c1;
		background-color: #fff;
		border-radius: 8px;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		padding:40px 30px;
		position: relative;
		.back_home{
			position: absolute;
			top: 55px;
			left: 40px;
			z-index: 20;		
		}
		.artical_title{
			margin-bottom: 20px;
			font-size: 40px;
			text-align: center;
		}
		.time,.author{
			font-size: 20px;
			text-align: center;
			margin-bottom: 20px;
		}
		.about{
			user-select:none;
			-webkit-user-select:none;
			text-align: center;
			.up,.down{
				cursor: pointer;
			}
			.up{
				&:hover{
					color:#13CE66;
				}
			}
			.down{
				&:hover{
					color:#FF4949;
				}
			}
			span{
				font-size: 16px;
				margin-left: 10px;
			}
		}
		.artical_content{
			font-size: 30px;
			padding:40px 0 0;
			margin-bottom: 50px;
		}
		.artical_comment{
			border-top: 1px solid #c1c1c1;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding-top: 40px;
			&:after{
				content:"";
				clear: both;
				display: block;
			}
			p{
				margin-bottom: 16px;
				font-size: 30px;
			}
			#markdown{
				height: 200px;
			}
			.send_comment{
				float: right;
				padding:4px 10px;
				margin-top: 20px;
				margin-right: 10px;
			}
		}
		.comment_wrap{
			border-top: 1px solid #c1c1c1;
			font-size: 30px;
			margin-top: 40px;
			padding-top: 20px;
			.no_comment{
				margin:20px 0;
			}
		}
	}
</style>

<template>
	<div class="artical_detail_wrap">
		<div class="back_home myBtn" @click="back_home">飒</div>
		<template v-if="detail_data !== null">
			<div class="artical_title" v-text="detail_data.title"></div>
			<div class="author">作者：{{detail_data.username}}</div>
			<div class="time" >
				发布时间：{{format_time(detail_data.release_time)}}
			</div>
			<div class="about">
				<span class="up" @click="upFn(index,detail_data.id)">顶一下({{detail_data.up}})</span>
				<span class="down" @click="downFn(index,detail_data.id)">踩一下({{detail_data.down}})</span>
			</div>
			<!-- 文章主题内容格式该如何搞 -->
			<div class="artical_content" v-html="(detail_data.content)"></div>
		</template>
		<div v-else>文章加载失败</div>
		
		<!-- 下面是评论部分 -->
		<div class="artical_comment">
			<p>想说点什么？</p>
			<div id="markdown"></div>
			<div class="send_comment myBtn" @click="sendComment(detail_data.id)" title="发表">飒</div>
		</div>
		<div class="comment_wrap">
			<div class="no_comment" v-if="comment_data !== null && comment_data.length === 0 ">暂无评论</div>
			<comment-recursion :treeData="comment_data"></comment-recursion>
		</div>
	</div>
</template>

<script>
	//引入递归评论组件
	import commentRecursion from './comment_recursion.vue'
	export default {

		name: 'articalRouter',
		components:{
			commentRecursion
		},
		data () {
			return {
				detail_data:false,//当前页面数据
				artical_md:null,//富文本编辑器实例对象
			};
		},
		methods:{
			//时间格式化
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
			//递归树
			recursion( data,p_id = 0 ){
				var result = [],temp;

				[].slice.call(data).forEach((el,i) => {
					if( +el.parent_id === p_id ){
						result.push(el);
						temp = this.recursion(data,+el.id);
						temp.length !== 0 && (el.children = temp);
					}
				});
				return result;
			},
			upFn(index,id,e){
				let ev = e || window.event;
				ev.stopPropagation();
				this.$http({
					url:"http://www.tp.com/blog/home/index/toUp",
					method:"post",
					body:{
						id:id
					},
					emulateJSON: true,
				}).then( (data) => {
					if( data.data.res === 1 ){
						this.all_artical.forEach(function(el,i) {
							(el.id === id) && el.up++;
						});
					}else{
						alert('操作失败');
					}
				},(data) => {
					console.error("请求失败，来自main_side.vue");
				});


			},
			downFn(index,id,e){
				let ev = e || window.event;
				ev.stopPropagation();

				this.$http({
					url:"http://www.tp.com/blog/home/index/toDown",
					method:"post",
					body:{
						id:id
					},
					emulateJSON: true,
				}).then( (data) => {
					if( data.data.res === 1 ){
						this.all_artical.forEach(function(el,i) {
							(el.id === id) && el.down++;
						});
					}else{
						alert('操作失败');
					}
				},(data) => {
					console.error("请求失败，来自main_side.vue");
				});
			},
			back_home(){
				this.$router.push("/");
			},
			//发送评论，默认为顶层评论
			sendComment(id,parent_id = 0){
				let html = this.artical_md.$txt.html();
				//判断评论框内容是否为空
				let formatText = this.artical_md.$txt.formatText();
				if( this.$store.state.userInfo === null ){
					alert('请登录');
				}
				else{
					if( formatText.trim().length === 0 && !/img/.test(html) ){
						alert('不能发送空');
					}else{
						//带有html的文本 -->存储到数据库的
						this.$http({
							url:"http://www.tp.com/blog/home/index/send_comment",
							method:"post",
							body:{
								//发送到数据库的评论
								parent_id:parent_id,
								content:html,
								time:new Date().getTime(),
								artical_id:this.detail_data.id,
								user_id:this.$store.state.userInfo.id
							},
							emulateJSON: true,
						}).then( (data) => {
							if( data.data.res === 1 ){
								//通过文章ID来找被评论的文章，进而增加该文章的评论数
								this.all_artical.forEach(function(el,i) {
									(el.id === id) && el.comment_count++;
								});
								alert('评论成功');
								this.comment_data.unshift(data.data.data[0])
								this.artical_md.$txt.html("<p><br></p>");
							}
							if( data.data.res === 2 ){
								console.error("插入数据库出错，来自articalDetail.vue");
							}
						},(data) => {
							console.error("http连接出错，来自articalDetail.vue");
						});
						
					}
				}

			},
		},
		computed:{
			comment_data(){
				return this.$store.state.comment_data;
			},
			all_artical(){
				return this.$store.state.articalData;
			}
		},
		mounted(){
			//请求评论方法
			let getComment_fn = () => {
				this.$http({
					url:"http://www.tp.com/blog/home/index/getComment",
					method:"post",
					body:{
						artical_id:this.detail_data.id
					},
					emulateJSON: true,
				}).then( (data) => {
					this.$store.commit("set_comment_data",this.recursion(data.data.res).reverse());
				},(data) => {
					console.error("http连接出错，来自articalDetail.vue");
				});
			}
			


			//初始化富文本编辑器
			this.artical_md = new wangEditor('markdown');
			//让表情显示为图片，而不是文字
			this.artical_md.config.emotionsShow = 'icon'
			//配置markdown上的选项
			this.artical_md.config.menus = [
			"emotion"
			];
			//关闭菜单栏的fixed布局
			this.artical_md.config.menuFixed = false;
			//不过滤用户输入的代码
			this.artical_md.config.jsFilter = false;
			//粘贴的时候对于样式的处理
			this.artical_md.config.pasteFilter = true;
			this.artical_md.create();



			if(  this.$store.state.articalData.length !== 0 ){
				document.title = this.$store.state.articalData[this.$route.query.detail].title;
				this.detail_data = this.$store.state.articalData[this.$route.query.detail];
				this.detail_data.content = this.escape2Html(this.detail_data.content);
				getComment_fn();
			}else{
				// 获取详细数据的
				this.$http({
					url:"http://www.tp.com/blog/home/index/allArtical",
					method:"get",
				}).then( (data) => {
					data.data.reverse();
					// this.$route.query.detail是当前文章的id
					document.title = data.data[this.$route.query.detail].title;
					this.detail_data = data.data[this.$route.query.detail];
					this.detail_data.content = this.escape2Html(this.detail_data.content);
					getComment_fn();
				},(data) => {
					this.detail_data = false;
					console.error("获取文章内容失败，来自main_side.vue");
				});
			}
		},
	};
</script>