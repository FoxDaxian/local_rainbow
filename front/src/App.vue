<style scoped lang="scss">
	#app{
		&:after{
			content:"";
			clear: both;
			display: block;
		}
		.box{
			&:after{
				content:"";
				display: block;
				clear: both;
			}
			width: 1024px;
			margin:0 auto;
		}
	}
</style>
<template>
	<div id="app">
		<keep-alive>
			<router-view></router-view>
		</keep-alive>
		<div class="box">
			<keep-alive>
				<router-view name="title_side"></router-view>
			</keep-alive>
			<router-view name="main_side"></router-view>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'app',
		components: {
			
		},
		data(){
			return{
				
			}
		},
		methods:{
			
		},
		computed:{
			
		},
		watch:{
			
		},
		mounted(){
			
			// 记住登陆状态
			this.$http({
				url:"http://www.tp.com/blog/home/index/autoLogin",
				method:"get",
			}).then( (data) => {
				if( data.data.res === 0 ){
					this.$store.commit("changeUserInfo",undefined);
				}else {
					this.$store.commit("changeUserInfo",data.data.res[0]);
				}
			},(data) => {
				console.error("自动登录失败,来自app.vue");
			});


			// 获取全部的文章数据到vuex
			this.$http({
				url:"http://www.tp.com/blog/home/index/allArtical",
				method:"get",
			}).then( (data) => {
				this.$store.commit("getArticalData",data.data.reverse());
			},(data) => {
				console.error("获取文章内容失败，来自main_side.vue");
			});
		}
	}
</script>
