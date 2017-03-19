<style lang="scss" scoped>
	.not_found{
		position: absolute;
		left: 0;
		top: 0;
		bottom: 0;
		right: 0;
		margin:auto;
		text-align: center;
		line-height: 100vh;
		// 以上为全屏幕下垂直居中方案
		background-color: #222222;
		color:#fff;
		font-size: 16px;
		display: inline-block;
		vertical-align: bottom;
		font-size: 3em;
	}
</style>

<template>
	<div class="not_found">
		页面消失在你的脑海里
	</div>
</template>

<script>
	export default {

		name: 'not_found',

		data () {
			return {

			};
		}
	};
</script>