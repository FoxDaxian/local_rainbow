<style lang="scss" scoped>
	.edit_artical{
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
				height: 5vh;
				font-size: 40px;
				border:none;
				outline: none;
				border-bottom: 1px solid #c1c1c1;
				margin-bottom: 2vh;
				width: 650px;
				padding: 6px 10px;
			}
			#edit_markdown{
				height: 64vh;
				min-height: 390px;
				padding: 10px;
				font-size: 30px;
			}
			.other{
				&:after{
					content: "";
					display: block;
					clear: both;
				}
				.save{
					float: right;
					margin-right: 10px;
					margin-top: 1vh;
				}
			}
		}
	}
</style>

<template>
	<div class="edit_artical">
		<div class="head" v-text="doc_title"></div>
		<div class="main_box">
			<input type="text"  class="title" ref="input" v-model="artical_title">
			<div id="edit_markdown"></div>	
			<div class="other">
				<div  @click="modify" class="save myBtn">保存修改</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {

		name: 'edit_artical',

		data () {
			return {
				articles_in_editing:null,//当前文章
				artical_title:null,//当前编辑文章的标题
				markdown:null,//富文本编辑器实例对象
			};
		},
		methods:{
			modify(){
				let art_id = this.$route.query.key,
				tit = this.artical_title,
				cont = this.markdown.$txt.html();
				this.$http({
					url:this.url_root + "blog/home/index/save_modify",
					method:"post",
					body:{
						artical_id:art_id,
						title:tit,
						content:cont
					},
					emulateJSON: true,
				}).then( (data) => {
					this.$store.commit("modify_artical",{
						artical_id:art_id,
						title:tit,
						content:cont
					});
					if( data.data.res === 1 ){
						this.$msg({
							showClose: true,
							message: '我帮你改完了',
							type: 'error'
						});
					}
					if( data.data.res === 2 ){
						this.$msg({
							showClose: true,
							message: '老铁，你都没改',
							type: 'error'
						});
					}
					if( data.data.res === 0 ){
						this.$msg({
							showClose: true,
							message: '数据库爆炸',
							type: 'error'
						});
					}
				},(data) => {
					console.error("请求失败，来自edit_artical.vue");
				});

			}
		},
		computed:{
			doc_title(){
				return document.title;
			},
		},
		mounted(){
			this.markdown = new wangEditor('edit_markdown');
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

			this.$refs.input.focus()
			let all_artical = this.$store.state.articalData;
			all_artical.forEach((el,i) => {
				if( el.id === this.$route.query.key ){
					this.markdown.$txt.html(`${this.escape2Html(el.content)}`);
					this.artical_title = el.title;
					this.articles_in_editing = el;
					return false;
				}
			});
		}
	};
</script>