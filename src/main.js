import Vue from 'vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueResource from 'vue-resource'
Vue.use(VueResource)
Vue.http.options.root = 'http://www.practice.com/vue/vue-cms'
Vue.http.options.emulateJSON = true;

import Vuex from 'vuex'
Vue.use(Vuex)
var cart = JSON.parse(localStorage.getItem('cartList') || '[]')
let store = new Vuex.Store({
	state:{
		cartList:cart
	},
	mutations:{
		addToCart(state, goods){
			let flag = false;
			state.cartList.some(item=>{
				if (item.id == goods.id) {
					item.count += goods.count
					item.selected = true;
					flag = true;
					return true
				}
			})
			if (!flag) {
				state.cartList.unshift(goods)
			}
			localStorage.setItem('cartList', JSON.stringify(state.cartList))
		},
		selectChange(state, id){
			state.cartList.some(item=>{
				if (item.id == id) {
					item.selected = !item.selected
				}
			})
			localStorage.setItem('cartList', JSON.stringify(state.cartList))
		},
		countChanged(state,goods){
			state.cartList.some(item=>{
				if (item.id == goods.id) {
					item.count = goods.count
					return true;
				}
			})
			localStorage.setItem('cartList', JSON.stringify(state.cartList))
		},
		delGoods(state,id){
			state.cartList.some((item,index)=>{
				if (item.id == id) {
					state.cartList.splice(index, 1);
					return true
				}
			})
			localStorage.setItem('cartList', JSON.stringify(state.cartList))
		}
	},
	getters:{
		allCounts:function(state){
			let c = 0;
			state.cartList.forEach(item=>{
				c += item.count
			})
			return c
		},
		getGoodsStatus: (state) => {
			let obj = {}
			state.cartList.forEach(item=>{
				obj[item.id] = item.selected
			})
			return obj
		},
		getGoodsCount: (state) => {
			let obj = {}
			state.cartList.forEach(item=>{
				obj[item.id] = item.count
			})
			return obj
		},
		getCountsAmounts: (state)=>{
			let obj = {
				count: 0,
				amount: 0
			}
			state.cartList.forEach(item=>{
				if (item.selected) {
					obj.count += item.count
					obj.amount += parseFloat(item.price) * item.count
				}
			})
			return obj
		}
	}
})

import moment from 'moment'
Vue.filter('dateFormat', function(dateStr,pattern="YYYY-MM-DD HH:mm:ss"){
	return moment(dateStr).format(pattern)
})


import '../node_modules/mint-ui/lib/style.css'
/*import { Header, Swipe, SwipeItem, Button, Lazyload} from 'mint-ui'
Vue.component(Header.name, Header)
Vue.component(Swipe.name, Swipe)
Vue.component(SwipeItem.name, SwipeItem)
Vue.component(Button.name, Button)
Vue.use(Lazyload)*/
import MintUI from 'mint-ui'
Vue.use(MintUI)

import './lib/mui/css/mui.min.css'
import './lib/mui/css/icons-extra.css'


import VuePreview from 'vue-preview'
Vue.use(VuePreview)

import router from './router.js'
import app from './App.vue'

let vm = new Vue({
	el:'#app',
	render:c=>c(app),
	router,
	store
})