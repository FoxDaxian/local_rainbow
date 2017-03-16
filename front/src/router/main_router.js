//按需加载
//登录/注册页
const login = resolve => require(['../components/login_head_router/loginPage.vue'], resolve);
//文章详细页
const detail = resolve => require(['../components/articalRouter/articalDetail.vue'], resolve);
//我的主页
const home = resolve => require(['../components/home_router/home.vue'], resolve);

//页面的主体
const login_head = resolve => require(['../components/login_head.vue'], resolve);
const title_side = resolve => require(['../components/title_side.vue'], resolve);
const main_side = resolve => require(['../components/main_side.vue'], resolve);
const about_me = resolve => require(['../components/about_me.vue'], resolve);

//我的主页路由组件
const home_info = resolve => require(['../components/home_router/info.vue'], resolve);
const home_tab = resolve => require(['../components/home_router/home_tab.vue'], resolve);
const my_artical = resolve => require(['../components/home_router/my_artical.vue'], resolve);
const write = resolve => require(['../components/home_router/write.vue'], resolve);
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
			path:"",
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
	}],
	scrollBehavior (to, from, savedPosition) {
		if (savedPosition) {
			return savedPosition
		} else {
			return { x: 0, y: 0 }
		}
	}
};


let beforeEach = (to,from,next) => {
	var title = to.name || "Rainbow blog";
	document.title = title;
	next();
};

let afterEach = () => {

};

export default {
	config,beforeEach,afterEach
};