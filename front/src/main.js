import Vue from 'vue';
import App from './App';



import store from './vuex/main_vuex.js';


//使用vue-router
import router_config from "./router/main_router.js";
import VueRouter from 'vue-router';
Vue.use(VueRouter);
var router = new VueRouter(router_config.config);
router.beforeEach(router_config.beforeEach);
router.afterEach(router_config.afterEach);




//引入el-ui
import { Message } from 'element-ui';
import { Loading } from 'element-ui';
import { MessageBox } from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
Vue.prototype.$msg = Message;
Vue.prototype.$load = Loading.service;
Vue.prototype.$confirm = MessageBox.confirm;


//引入vue-resource
import v from "./vue-resource/main_resource.js";
Vue.prototype.http = v.$http;



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
};


//引入不同环境下的ajax请求地址
import url_root from "./util/url_root.js";
Vue.prototype.url_root = url_root;

//生产环境取消提示啥的
if( process.env.NODE_ENV !== "development" ){
	Vue.config.silent = false;
	Vue.config.productionTip = false;
}


/* eslint-disable no-new */
new Vue({
	el: '#app',
	template: '<App/>',
	components: { App },
	store:store.store,
	router,
});
