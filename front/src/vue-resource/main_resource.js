import Vue from "vue";
//引入vue-resource
import VueResource from "vue-resource";
Vue.use(VueResource);
//vue-resource拦截器，用来设置ajax 是否而已携带cookie，这cookie携带的是服务器端的，而不是浏览器的
//这个相当于每次页面内的ajax请求都会走这里，所以可以获取到this，而你用箭头函数的话，就绑定到这个环境下了，而不是调用的obj
Vue.http.interceptors.push( function(request, next){
	request.credentials = true;
	let load = this.$load({
		text:"biubiubiu..."
	});
	next( ( response ) => {
		load.close();
		return response;
	});
});
//单独取出vue-resourced方法
export default new Vue;