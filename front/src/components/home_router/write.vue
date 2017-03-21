<style lang="scss" scoped>
	.write_wrap{
		float: right;
		width: 710px;
		background-color: #fff;
		.head{
			width: 710px;
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
			height: 50px;
		}
		.main_box{
			height: 100vh;
			padding-top: 8.6vh;
			margin: 0 20px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			.title{
				height: 7vh;
				font-size: 40px;
				border:none;
				outline: none;
				border-bottom: 1px solid #c1c1c1;
				margin-bottom: 2vh;
				width: 650px;
				padding: 6px 10px;
			}
			#write_markdown{
				height: 64vh;
				min-height: 200px;
				padding: 10px;
				font-size: 30px;
			}
			.other{
				div{
					float: right;
				}
				.tips{
					padding:  2vh 10px;
					float: left;
					font-size: 18px;
					color:rgb(249, 38, 114);
				}
				.save{
					float: right;
					margin-top: 1vh;
					margin-right: 20px;
				}
				.send{
					float: right;
					margin-top: 1vh;
					margin-right: 10px;
				}
				.reset{
					float: right;
					margin-top: 1vh;
					margin-right: 10px;
				}
			}
		}
	}
</style>

<template>
	<div class="write_wrap">
		<div class="head" v-text="doc_title"></div>
		<div class="main_box">
			<input type="text"  class="title" ref="input"  v-model="artical_title">
			<div id="write_markdown"></div>
			<div class="other">
				<div class="tips">
					提示：养成按时保存的习惯哦，不然就白写了呢！
				</div>
				<div @click="send" class="send myBtn">发表</div>
				<div @click="save" class="save myBtn">保存</div>
				<div @click="reset" class="reset myBtn">重置</div>

			</div>
		</div>
	</div>
</template>

<script>
	export default {

		name: 'write',

		data () {
			return {
				artical_title:"无标题文章",
				markdown:null,//富文本编辑器实例对象
			};
		},
		computed:{
			user_data(){
				if( this.$store.state.userInfo ){
					return this.$store.state.userInfo;
				}else{
					return "请登录";
				}
			},
			doc_title(){
				return document.title;
			}
		},
		methods:{
			reset(){
				let markdown_obj = this.markdown;
				markdown_obj.$txt.html('<p><br></p>');
				this.artical_title = "无标题文章";
			},
			save(e,title,content){
				let markdown_obj = this.markdown,
				html = markdown_obj.$txt.html(),
				formatText = markdown_obj.$txt.formatText();
				if( (formatText.trim().length === 0) && !/img/.test(html) ){
					this.$msg({
						showClose: true,
						message: '写东西啊，烦不烦啊',
						type: 'error'
					});
				}else{
					if( this.artical_title.trim().length !== 0 ){
						this.$http({
							url:this.url_root + "blog/home/index/save_draft",
							method:"post",
							body:{
								id:  this.user_data.id,
								title: title || this.artical_title.trim(),
								content:content || html
							},
							emulateJSON: true,
						}).then( (data) => {
							if( data.data.res === 1   ){
								title === undefined && this.$msg({
									showClose: true,
									message: '帮你存了，老铁',
									type: 'error'
								});
							}else{
								this.$msg({
									showClose: true,
									message: '数据库爆炸',
									type: 'error'
								});
							}
						},(data) => {
							this.$msg({
								showClose: true,
								message: '数据库爆炸',
								type: 'error'
							});
						});
						
					}else{
						this.$msg({
							showClose: true,
							message: '标题！标题！标题！',
							type: 'error'
						});
					}
				}
			},
			send(){
				let markdown_obj = this.markdown,
				html = markdown_obj.$txt.html(),
				formatText = markdown_obj.$txt.formatText();
				if( (formatText.trim().length === 0) && !/img/.test(html) ){
					this.$msg({
						showClose: true,
						message: '写东西啊，烦不烦啊',
						type: 'error'
					});
				}else{
					if( this.artical_title.trim().length !== 0 ){


						this.$confirm('咱发么?', '致老铁：', {
							confirmButtonText: '发',
							cancelButtonText: '不发',
							type: 'warning'
						}).then(() => {
							let temp_time = new Date().getTime();
							this.$http({
								url:this.url_root + "blog/home/index/send_artical",
								method:"post",
								body:{
									id:this.user_data.id,
									time:temp_time,
									title:this.artical_title.trim(),
									content:html
								},
								emulateJSON: true,
							}).then( (data) => {
								if( data.data.res === 1 ){
									let temp_obj = {};
									//添加到vuex的最新发表文章的数据
									this.$set(temp_obj,'id',data.data.artical_id)
									this.$set(temp_obj,'user_id',this.user_data.id)
									this.$set(temp_obj,'title',this.artical_title.trim())
									this.$set(temp_obj,'content',html)
									this.$set(temp_obj,'release_time',temp_time)
									this.$set(temp_obj,'username',this.user_data.username)
									this.$set(temp_obj,'up',0)
									this.$set(temp_obj,'down',0)
									this.$set(temp_obj,'look',0)
									this.$set(temp_obj,'comment_count',0)
									this.$store.commit("unshift_to_articalData",temp_obj);
									this.$msg({
										showClose: true,
										message: '发他丫的！',
										type: 'success'
									});
									this.$router.push({ 
										path: '/detail', 
										query: { 
											detail: 0,
										},
									})
									this.save(null,"无标题文章",'<p><br></p>');
									this.artical_title = "无标题文章";
									markdown_obj.$txt.html('<p><br></p>');
								}else{
									this.$msg({
										showClose: true,
										message: '数据库爆炸',
										type: 'error'
									});
								}
							},(data) => {
								console.error("请求失败，来自write.vue");
							});
						}).catch(() => {
							this.$msg({
								showClose: true,
								message: '那就不发',
								type: 'info'
							});    
						});
					}else{
						this.$msg({
							showClose: true,
							message: '标题！标题！标题！',
							type: 'error'
						});
					}
				}
			},
		},
		mounted(){
			//初始化富文本编辑器
			this.markdown = new wangEditor('write_markdown');
			//让表情显示为图片，而不是文字
			this.markdown.config.emotionsShow = 'icon'
			//配置markdown上的选项
			this.markdown.config.menus = ['source','bold','underline','italic','strikethrough','eraser','forecolor','bgcolor','quote','fontfamily','fontsize','head','unorderlist','orderlist','alignleft','aligncenter','alignright','link','unlink','table','emotion','img','video','insertcode','undo','redo','fullscreen'];
			//关闭菜单栏的fixed布局
			this.markdown.config.menuFixed = false;
			//不过滤用户输入的代码
			this.markdown.config.jsFilter = false;
			//粘贴的时候对于样式的处理
			this.markdown.config.pasteFilter = true;
			this.markdown.create();
			this.$refs.input.focus();

			
			// 啥都不用了，第一次进来，追加内容就好，之后又keep-alive，所以不会丢失草稿内容
			this.$http({
				url:this.url_root + "blog/home/index/get_draft",
				method:"post",
				body:{
					id:this.user_data.id,
				},
				emulateJSON: true,
			}).then( (data) => {
				if( data.data.res === 1 ){
					if( data.data.res_data){
						this.artical_title = data.data.res_data.title;
						this.markdown.$txt.html(this.escape2Html(data.data.res_data.content));
					}
				}else{
					this.$msg({
						showClose: true,
						message: '数据库爆炸',
						type: 'error'
					});
				}
			},(data) => {
				console.error("请求失败，来自write.vue");
			});
		},
	};
</script>