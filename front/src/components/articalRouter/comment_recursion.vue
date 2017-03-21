<style lang="scss" scoped>
	.wrap{
		box-shadow: none;
		padding: 0;
		.comment_box{
			border-radius: 8px;
			position: relative;
			font-size: 26px;
			margin:20px 0 5px;
			border:1px solid #c1c1c1;
			padding: 5px;
			box-shadow:0 0 5px #9c9c9c;
			&:after{
				content: "";
				display: block;
				clear: both;
			}
			.username{
				margin-top: 20px;
				margin-bottom: 10px;
				span{
					color:rgb(32, 160, 255);
				}
			}
			.comment_content{
				background-color: whitesmoke;
				line-height: 30px;
				border-left: 6px solid #b4b4b4;
				margin:20px 10px;
				word-break: break-word;
				padding: 10px;
			}
			.other{
				margin-bottom: 10px;
				&:after{
					content:"";
					clear: both;
					display: block;
				}
				.time{
					float: right;
					font-size: 20px;
					margin-right: 1em;
					padding: 5px;
				}
				.star{
					float: left;
					font-size: 20px;
					padding: 5px;
				}
				.toStar{
					font-size: 20px;
					float: left;
					margin:0 1em;
				}
			}
			.comment_btn_wrap{
				&:after{
					content:"";
					clear: both;
					display: block;
				}
				.comment_btn{
					text-align: center;
					margin-bottom: 20px;	
					margin-right: 20px;
					float: right;		
				}
			}
			.inner_comment_box{
				display: none;
				&:after{
					content:"";
					display: block;
					clear: both;
				}
				.markdown{
				}
			}
			.send_comment_wrap{
				&:after{
					content:"";
					display: block;
					clear: both;
				}
				.send_comment{
					display: none;
					float: right;
					margin: 10px 20px 10px 0;
				}
			}
		}
	}
</style>

<template>
	<div class="wrap">
		<div class="comment_box" v-for="(item,index) in treeData" :key="item.id">
			<div class="username"><span>{{item.username}}</span> 回复：</div>
			<div class="comment_content" v-html="escape2Html(item.content)"></div>
			<div class="other">
				<span class="time">回复时间:{{format_time(item.comment_time)}}</span>
				<div class="myBtn toStar" @click="star_fn(item,$event) && (item.can_star = !item.can_star)"></div>
				<span class="star">赞:{{item.stars}}</span>
			</div>
			<!-- 点击的时候显示出来 -->
			<div class="comment_btn_wrap">
				<div class="comment_btn myBtn" @click="show_md(item.id)">回复</div>
			</div>

			<div class="inner_comment_box" :ref="'md' + item.id">
				<div class="markdown" :data-id="item.id"></div>
			</div>
			<div class="send_comment_wrap">
				<div class="send_comment myBtn" title="发表" @click="send_comment(item,item.id)">飒</div>
			</div>

			<template v-if="item.children">
				<comment_recursion :treeData="item.children"></comment_recursion>
			</template>
		</div>
	</div>
</template>

<script>
	export default {

		name: 'comment_recursion',
		props:["treeData"],
		data () {
			return {
				key:true,
			};
		},
		computed:{

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
			//将每个刚开始（挂载）就生成的md，添加到vuex中，备用
			product_md(el,id){
				let temp_md = new wangEditor(el);
				//让表情显示为图片，而不是文字
				temp_md.config.emotionsShow = 'icon'
				//配置markdown上的选项
				temp_md.config.menus = [
				"emotion"
				];
				//关闭菜单栏的fixed布局
				temp_md.config.menuFixed = false;
				//不过滤用户输入的代码
				temp_md.config.jsFilter = false;
				//粘贴的时候对于样式的处理
				temp_md.config.pasteFilter = true;
				temp_md.create();
				this.$store.commit("add_allMd",{
					md_obj:temp_md,
					id:id
				});
			},
			show_md(id){
				var el = this.$refs["md" + id][0];
				if( !this.$store.state.all_md[id] ){
					if( !/wangEditor-txt/.test(el.querySelector('.markdown').className) ){
						this.product_md(el,id);
					}
				}
				if( getComputedStyle(el)["display"] === "block" ){
					el.parentNode.parentNode.querySelector('.send_comment_wrap .send_comment').style.display = "none";
					el.style.display = "none";
					el.parentNode.style.display = "none";
				}else{
					el.parentNode.parentNode.querySelector('.send_comment_wrap .send_comment').style.display = "block";
					el.style.display = "block";
					el.parentNode.style.display = "block";
				}
			},
			send_comment(item,id){
				let markdown_obj = this.$store.state.all_md[id],
				html = markdown_obj.$txt.html(),
				formatText = markdown_obj.$txt.formatText();

				if( this.$store.state.userInfo === null ){
					this.$msg({
						showClose: true,
						message: '不登录我很难做啊，老铁',
						type: 'error'
					});
				}else{
					if( formatText.trim().length === 0 && !/img/.test(html) ){
						this.$msg({
							showClose: true,
							message: '登陆了也不能这样啊，老铁',
							type: 'error'
						});
					}else{
						
						//带有html的文本 -->存储到数据库的
						this.$http({
							url:this.url_root + "blog/home/index/send_comment",
							method:"post",
							body:{
								//发送到数据库的评论
								parent_id:item.id,
								artical_id:item.artical_id,
								user_id:this.$store.state.userInfo.id,
								time:new Date().getTime(),
								content:html
							},
							emulateJSON: true,
						}).then( (data) => {
							if( data.data.res === 1 ){
								//立刻显示出评论的递归方法
								let immidiately_show = (arr_data) => {
									arr_data.forEach((el,i) => {
										if( data.data.data[0].parent_id === el.id ){
											if( el.children ){
												el.children.unshift(data.data.data[0]);
											}else{
												this.$set(el,"children",[]);
												el.children.unshift(data.data.data[0]);
											}
											return false;
										}else if( el.children ){
											immidiately_show(el.children);
										}
									});
								}
								immidiately_show(this.treeData);
								markdown_obj.$txt.html("<p><br></p>");
								this.$msg({
									showClose: true,
									message: '那你很棒哟，老铁',
									type: 'success'
								});
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
			star_fn( item_data,e ){
				var ev = e || window.event,
				target = ev.target.nextElementSibling.childNodes[0],//赞个数
				btn = ev.target;
				if( item_data.can_star ){
					this.$http({
						url:this.url_root + "blog/home/index/comment_down",
						method:"post",
						body:{
							comment_id:item_data.id
						},
						emulateJSON: true,
					}).then( (data) => {
						if( data.data.res === 1 ){
							target.deleteData(2,1);
							target.insertData (2,data.data.count);
						}else{
							console.error("失败");
						}
					},(data) => {
						console.error("http连接出错，来自comment_recursion.vue");
					});
				}else{
					this.$http({
						url:this.url_root + "blog/home/index/comment_up",
						method:"post",
						body:{
							comment_id:item_data.id
						},
						emulateJSON: true,
					}).then( (data) => {
						if( data.data.res === 1 ){
							target.deleteData(2,1);
							target.insertData (2,data.data.count);
						}else{
							console.error("失败");
						}
					},(data) => {
						console.error("http连接出错，来自comment_recursion.vue");
					});
				}
				return true;
			}
		},
		mounted(){
			if( this.treeData !== null ){
				this.treeData = this.treeData.reverse();
			}
		},
	};
</script>