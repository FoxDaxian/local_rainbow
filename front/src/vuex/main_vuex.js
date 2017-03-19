//使用vuex
import Vue from 'vue';
import Vuex from 'vuex'
Vue.use(Vuex);

var config = {
	state: {
		userInfo:null,//当前用户信息，不刷新、跳转的情况下都存在这了
		articalData:[],
		comment_data:null,//当前详细页面评论信息
		all_md:{},//全部评论框的markdown数组
		draft_data:null,//临时草稿箱
	},
	mutations: {
		//记住用户登录状态
		changeUserInfo(state,arg){
			if( arg === undefined ){
				state.userInfo = null;
			}else{
				state.userInfo = arg;
			}
		},
		//退出登录清楚数据
		log_out(state){
			state.userInfo = null;
		},
		//设置评论数据
		set_comment_data(state,data){
			state.comment_data = data;
		},
		//获取文章数据
		getArticalData(state,data){
			state.articalData = data;
		},
		//发表的时候添加一条文章记录到articalData
		unshift_to_articalData(state,obj){
			state.articalData.unshift(obj);
		},
		//顶
		up(state,index){
			state.articalData[index].up++;
		},
		//踩
		down(state,index){
			state.articalData[index].down++;
		},
		//阅读量
		look(state,index){
			state.articalData[index].look++;
		},
		//增加markdown到全部的数据里，备用
		add_allMd(state,options){
			state.all_md[options.id] = options.md_obj;
		},
		//更新用户修改已发表文章的信息
		modify_artical(state,options){
			state.articalData.forEach(function(el,i) {
				if( el.id === options.artical_id ){
					el.content = options.content;
					el.title = options.title;
					return false;
				}
			});
		},
		//用户删除文章之后，更改vue的数据
		delete_artical(state,artical_id){
			state.articalData.forEach(function(el,i) {
				if( el.id === artical_id ){
					console.log(i);
					if( i === 0 ){
						state.articalData.shift();
					}else{
						state.articalData.splice(i,1);
					}
					return false;
				}
			});
		},
		//设置草稿箱内容
		set_draft_data(state,options){
			state.draft_data = options;
		},
		//用户更改完用户名之后重设
		set_articalData_username(state,options){
			state.articalData.forEach( ( el,i ) => {
				if( el.user_id === options.id ){
					el.username = options.name;
				}
			});
		}
	}
};


let store = new Vuex.Store(config);

export default {
	store
};