import Vue from 'vue';
import App from './App';

//使用vue-router
import router_config from "./router/main_router.js";
import VueRouter from 'vue-router';
Vue.use(VueRouter);
var router = new VueRouter(router_config.config);
router.beforeEach(router_config.beforeEach);
router.afterEach(router_config.afterEach);

//使用vuex
import Vuex from 'vuex'
Vue.use(Vuex);
import store_config from "./vuex/main_vuex.js";
var store = new Vuex.Store(store_config.config);

//引入vue-resource
import VueResource from "vue-resource";
Vue.use(VueResource);
//vue-resource拦截器，用来设置ajax 是否而已携带cookie，这cookie携带的是服务器端的，而不是浏览器的
Vue.http.interceptors.push((request, next) => {
	request.credentials = true;
	next();
});


import "wangeditor";
wangEditor.config.printLog = false;




//引入初始化css
import "../static/reset.css";


//挂载全局函数
Vue.prototype.escape2Html = (str) =>{//反转义html转义符
	var arrEntities={'lt':'<','gt':'>','nbsp':' ','amp':'&','quot':'"'};
	return str.replace(/&(lt|gt|nbsp|amp|quot);/ig,function(all,t){
		return arrEntities[t];
	});
},

/* eslint-disable no-new */
new Vue({
	el: '#app',
	template: '<App/>',
	components: { App },
	router,store
});
