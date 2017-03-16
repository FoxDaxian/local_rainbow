<style lang="scss" scoped>
	.home_tab_wrap{
		margin-top: 50px;
		height: 84.8vh;
		width: 260px;
		float: left;
		background-color: #fff;
		box-shadow: 0 0 2px #c1c1c1;
		border-radius: 8px;
		position: relative;
		padding: 20px 0 0px;
		box-sizing: border-box;
		-moz-box-sizing: border-box;
		&:after{
			content:"";
			display: block;
			clear: both;
		}
		.list{
			position: relative;
			width: 100%;
			z-index: 1000;
			overflow: hidden;
			margin:20px 0;
			padding:10px 0;
			.like_a{
				text-align: center;
				width: 100%;
				display: inline-block;
				font-size: 30px;
				cursor: pointer;
				i{
					transition:0.3s;
					-webkit-transition:0.3s;
					-ms-transform:scale(0);
					-webkit-transform: scale(0);
					transform: scale(0);
				}
			}
			.special_hover{
				&:after,&:before{
					content:attr(data-text);
					position: absolute;
					height: 50%;
					width: 100%;
					left: 0;
					overflow: hidden;
					background-color: #fff;
					box-sizing: border-box;
					-moz-box-sizing: border-box;
					transition:0.3s;
					-webkit-transition:0.3s;
				}
				&:after{
					top: 0;
					padding-top: 0.37em;
				}
				&:before{
					bottom: 0;
					line-height: 0;
				}
			}
			&:hover{
				.special_hover{
					&:after{
						top: -50%;
					}
					&:before{
						bottom: -50%;
					}
				}
				.like_a{
					i{
						-ms-transform:scale(1);
						-webkit-transform: scale(1);
						transform: scale(1);
					}
				}
			}
		}
		.more{
			border-top: 1px solid #c1c1c1;
			border-bottom: 1px solid #c1c1c1;
			margin-top:20px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			.like_a{
				cursor: default;
			}
		}
		.bottom{
			box-shadow: 0 -1px 0px #c1c1c1;
			position: absolute;
			width: 100%;
			bottom: 0;
		}
	}
</style>

<template>
	<div class="home_tab_wrap">
		<div class="list" v-for="(item,index) in home_options">
			<router-link :to="item.url" exact class="like_a special_hover" :data-text="item.name"><i>图标</i></router-link>
		</div>

		<div class="list more">
			<div class="like_a special_hover" data-text="敬请期待"><i>图标</i></div>
		</div>
		<div class="bottom">
			<div class="list">
				<div class="like_a special_hover" data-text="飒" @click="back_one"><i>图标</i></div>
			</div>
			<div class="list">
				<router-link to="/" exact class="like_a special_hover" data-text="飒飒"><i>图标</i></router-link>
			</div>
		</div>
	</div>
</template>

<script>
	export default {

		name: 'home_tab',

		data () {
			return {
				home_options:[{
					name:"我的信息",
					url:"/home",
				},{
					name:"我的文章",
					url:"/home/artical",
				},{
					name:"发表博文",
					url:"/home/write",
				},]
			};
		},
		computed:{

		},
		methods:{
			back_one(){
				this.$router.go(-1);
			}
		},
		mounted(){
			
		}
	};
</script>