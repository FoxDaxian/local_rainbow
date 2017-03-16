<style lang="scss" scoped>
	.home_wrap{
		&:after{
			content:"";
			display: block;
			clear: both;
		}
		width: 1024px;
		margin:0 auto;
	}
</style>

<template>
	<div class="home_wrap">
		<keep-alive>
			<router-view name="tab"></router-view>
		</keep-alive>
		<router-view name="main"></router-view>
		<!-- 保持切换出去的写组件，以临时保存用户的书写内容 -->
		<keep-alive>
			<router-view name="write"></router-view>
		</keep-alive>
	</div>
</template>

<script>
	export default {

		name: 'home',
		components:{

		},
		data () {
			return {
				
			};
		},
		computed:{

		},
		methods:{
			
		},
		mounted(){
			
		}
	};
</script>