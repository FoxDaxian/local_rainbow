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
		<router-view></router-view>
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
			// 获取全部的文章数据到vuex
			this.$http({
				url:this.url_root + "blog/home/index/allArtical",
				method:"get",
			}).then( (data) => {
				if( {}.toString.call(data.data) === "[object Array]" ){
					this.$store.commit("getArticalData",data.data.reverse());
				}else{
					console.error("获取失败,来自app.vue");
				}
			},(data) => {
				console.error("获取文章内容失败，来自main_side.vue");
			});
		}
	}
</script>
