//按需加载
//登录/注册页

// const login = r => require.ensure([], () => r(require('../components/login_head_router/loginPage.vue')), 'login')
const login = resolve => require(['../components/login_head_router/loginPage.vue'], resolve);

//文章详细页
// const detail = r => require.ensure([], () => r(require('../components/articalRouter/articalDetail.vue')), 'detail')
const detail = resolve => require(['../components/articalRouter/articalDetail.vue'], resolve);

//我的主页
// const home = r => require.ensure([], () => r(require('../components/home_router/home.vue')), 'home')
const home = resolve => require(['../components/home_router/home.vue'], resolve);

//页面404
// const not_found = r => require.ensure([], () => r(require('../components/not_found.vue')), 'not_found')
const not_found = resolve => require(['../components/not_found.vue'], resolve);

//页面的主体
// const login_head = r => require.ensure([], () => r(require('../components/login_head.vue')), 'login_head')
const login_head = resolve => require(['../components/login_head.vue'], resolve);
// const title_side = r => require.ensure([], () => r(require('../components/title_side.vue')), 'title_side')
const title_side = resolve => require(['../components/title_side.vue'], resolve);
// const main_side = r => require.ensure([], () => r(require('../components/main_side.vue')), 'main_side')
const main_side = resolve => require(['../components/main_side.vue'], resolve);
// const about_me = r => require.ensure([], () => r(require('../components/about_me.vue')), 'about_me')
const about_me = resolve => require(['../components/about_me.vue'], resolve);

//我的主页路由组件
// const home_info = r => require.ensure([], () => r(require('../components/home_router/info.vue')), 'home_info')
const home_info = resolve => require(['../components/home_router/info.vue'], resolve);
// const home_tab = r => require.ensure([], () => r(require('../components/home_router/home_tab.vue')), 'home_tab')
const home_tab = resolve => require(['../components/home_router/home_tab.vue'], resolve);
// const my_artical = r => require.ensure([], () => r(require('../components/home_router/my_artical.vue')), 'my_artical')
const my_artical = resolve => require(['../components/home_router/my_artical.vue'], resolve);
// const write = r => require.ensure([], () => r(require('../components/home_router/write.vue')), 'write')
const write = resolve => require(['../components/home_router/write.vue'], resolve);
// const edit_artical = r => require.ensure([], () => r(require('../components/home_router/edit_artical.vue')), 'edit_artical')
const edit_artical = resolve => require(['../components/home_router/edit_artical.vue'], resolve);


let config = {
	mode:"history",
	base:__dirname,//基路径
	linkActiveClass:"router_active",//跳转到的当前导航的active class名
	routes: [{ 
		path: '/',
		components: {
			default:login_head,
			title_side:title_side,
			main_side:main_side
		},
	},{ 
		path: '/about_me',
		components: {
			main_side:about_me,
		},
	},{ 
		path: '/login',
		components: {
			default:login
		},
		name:"用户登录",
	},{ 
		path: '/detail',
		components: {
			default:login_head,
			title_side:title_side,
			main_side:detail
		},
	},{
		path: '/home',
		components: {
			default:home
		},
		children:[{
			path:"/",
			components:{
				tab:home_tab,
				main:home_info
			},
			name:"我的信息",
		},{
			path:"artical",
			components:{
				tab:home_tab,
				main:my_artical
			},
			name:"我的文章",
		},{
			path:"write",
			components:{
				tab:home_tab,
				write:write
			},
			name:"发表博文",
		},{
			path:"edit",
			components:{
				tab:home_tab,
				main:edit_artical,
			},
			name:"编辑文章",
		}]
	},{ 
		path: '/notfound',
		components: {
			default:not_found,
		},
		name:"404",
	}],
	scrollBehavior (to, from, savedPosition) {
		if (savedPosition) {
			return savedPosition
		} else {
			return { x: 0, y: 0 }
		}
	}
};



import v from "../vue-resource/main_resource.js";
import url_root from "../util/url_root.js";

//为了在beforeEach中使用
import store_obj from '../vuex/main_vuex.js';
let store = store_obj.store;



let beforeEach = (to,from,next) => {
	//访问没有的页面，转到404
	if( to.matched.length === 0 ){
		next("notfound");
		return false;
	}
	var title = to.name || "Rainbow blog";
	document.title = title;
	//在这里记住用户七日登录信息
	//用户未登录访问，在router里做
	if( store.state.userInfo === null ){
		v.$http({
			url:url_root + "blog/home/index/autoLogin",
			method:"get",
		}).then( (data) => {
			if( data.data.res === 0 ){
				store.commit("changeUserInfo",undefined);
				if( /\/home/.test(to.path) ){
					next({
						path:"/login",
						query:{
							back:to.path
						}
					});
				}else{
					next();
				}
			}else {
				store.commit("changeUserInfo",data.data.res[0]);
				next();
			}
			
		},(data) => {
			console.error("自动登录失败,来自app.vue");
		});
	}else{
		next();
	}
	





	
};

let afterEach = () => {

};

export default {
	config,beforeEach,afterEach
};