<style lang="scss" scoped>
	.main_wrap{
		float: right;
		width: 710px;
		margin-top: 50px;
		.artical_box{
			box-shadow: 0 0 2px #c1c1c1;
			border-radius: 8px;
			background-color: #fff;
			margin-bottom:30px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			padding:30px 20px;
			transition:0.3s;
			-webkit-transition:0.3s;
			-moz-transition:0.3s;
			-ms-transition:0.3s;
			cursor: pointer;
			&:hover{
				background-color: #fffff1;
			}
			&:after{
				content:'';
				display: block;
				clear: both;
			}
			.title{
				font-size: 40px;
				color:#2f2f2f;
			}
			.content{
				line-height: 30px;
				font-size: 20px;
				margin:8px 0;
				color:#333;
			}
			.info{
				margin-top: 20px;
				&:after{
					content:"";
					clear: both;
					display: block;
				}
				.author{
					font-size: 16px;
					float: right;
					margin-right: 10px;
				}
				.time{
					float: right;
					font-size: 16px;
				}
			}
			.about{
				user-select:none;
				-webkit-user-select:none;
				margin-top: 10px;
				text-align: right;
				span{
					font-size: 16px;
					margin-left: 10px;
				}
			}
		}
		.page{
			position: relative;			
			>div{
				font-size: 18px;
				padding:4px 16px;
			}
			.prev,.next{
				top: 0;
				position: absolute;
				border-radius: 8px;
				border:1px solid #a0a0a0;
				color:#a0a0a0;
				cursor: pointer;
				&:hover{
					border-color:#000;
					color:#000;
				}
			}
			.prev{
				left: 0px;
			}
			.next{
				right: 0px;	
			}
			.pageNow{
				text-align: center;
				span{
					font-weight: bold;
					font-style:italic;
				}
			}
			.notActive{
				border-color:#ececec!important;
				color:#ececec!important;
				cursor: default;
			}
		}
	}
</style>

<template>
	<div class="main_wrap">
		<template v-if="allDataArr !== false">
			<div class="artical_box bs7" v-for="(item,index) in allDataArr.slice(8 * pageIndex,8 * (pageIndex + 1))" @mouseleave="changeCss" @click="routerFn(item,index,item.id)">
				<div class="title" v-text="item.title"></div>
				<div class="content">
					{{escape2Html(item.content).replace(/(\<.+?\>)/g,"").length > 150 ? escape2Html(item.content).replace(/(\<.+?\>)/g,"").substr(0,150) + "..." : escape2Html(item.content).replace(/(\<.+?\>)/g,"") }}
				</div>
				<div class="info">
					<div class="time">
						发布时间：{{format_time(item.release_time)}}
					</div>
					<div class="author">作者：{{item.username}}</div>
				</div>
				<div class="about">
					<span class="up" @click="upFn(index,item.id)">顶( {{item.up}} )</span>
					<span class="down" @click="downFn(index,item.id)">踩( {{item.down}} )</span>
					<span class="look">点击量( {{item.look}} )</span>
					<span class="comment">评论数( {{item.comment_count}} )</span>
				</div>
			</div>
		</template>
		<div v-else>获取文章失败，请重试</div>
		<div class="page">
			<div class="prev" :class="{'notActive':pageIndex === 0}" @click="prevFn">上一页</div>
			<div class="pageNow">当前第 <span>{{pageIndex + 1}}</span> 页</div>
			<div class="next" :class="{'notActive':pageIndex === max - 1}" @click="nextFn">下一页</div>
		</div>
	</div>
</template>	

<script>
	export default {

		name: 'main_side',

		data () {
			return {
				pageIndex:0
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
			changeCss(e){
				var ev = e || window.event;
				//兼容傻逼IE
				if( ev.target.classList.value !== undefined ){
					ev.target.classList.remove(ev.target.classList.value.match(/bs./g)[0]);
				}else{
					ev.target.classList.remove([].slice.call(ev.target.classList).join(",").match(/bs./g)[0]);
					
				}
				ev.target.classList.add("bs" + Math.ceil(Math.random() * 7));
			},
			routerFn(item,index,id){
				this.$http({
					url:this.url_root + "blog/home/index/increamentLook",
					method:"post",
					body:{
						id:id
					},
					emulateJSON: true,
				}).then( (data) => {
					if( data.data.res === 1 ){
						this.$store.commit("look",index);
						this.$router.push({ 
							path: 'detail', 
							query: { 
								detail: index + this.pageIndex * 8,
							},
						})
					}else{
						console.error('进入详情页失败');
					}
				},(data) => {
					console.error("请求失败，来自main_side.vue");
				});
			},
			upFn(index,id,e){
				let ev = e || window.event;
				ev.stopPropagation();

				this.$http({
					url:this.url_root + "blog/home/index/toUp",
					method:"post",
					body:{
						id:id
					},
					emulateJSON: true,
				}).then( (data) => {
					if( data.data.res === 1 ){
						this.$store.commit("up",index);
					}else{
						console.error('操作失败');
					}
				},(data) => {
					console.error("请求失败，来自main_side.vue");
				});
			},
			downFn(index,id,e){
				let ev = e || window.event;
				ev.stopPropagation();

				this.$http({
					url:this.url_root + "blog/home/index/toDown",
					method:"post",
					body:{
						id:id
					},
					emulateJSON: true,
				}).then( (data) => {
					if( data.data.res === 1 ){
						this.$store.commit("down",index);
					}else{
						console.error('操作失败');
					}
				},(data) => {
					console.error("请求失败，来自main_side.vue");
				});
			},
			prevFn(){
				this.pageIndex !== 0 && window.scrollTo(0,0);
				this.pageIndex--;
				if( this.pageIndex <= 0){
					this.pageIndex = 0;
				}
			},
			nextFn(){
				this.pageIndex !== (this.max -1) && window.scrollTo(0,0);
				this.pageIndex++;
				if( this.pageIndex >= this.max - 1){
					this.pageIndex = this.max - 1;
				}
			},
		},
		computed:{
			allDataArr(){
				//获取最大page
				this.max = Math.ceil(this.$store.state.articalData.length / 8);
				return this.$store.state.articalData;
			}
		},
		mounted(){

		},

	};
</script>
