import Vue from 'vue'
import VueRouter from 'vue-router'

import app from './App.vue'
import HomeContainer from './components/tabbar/HomeContainer.vue'
import MemberContainer from './components/tabbar/MemberContainer.vue'
import CartContainer from './components/tabbar/CartContainer.vue'
import SearchContainer from './components/tabbar/SearchContainer.vue'
import NewsList from './components/news/NewsList.vue'
import PhotoList from './components/photos/PhotoList.vue'
import GoodsList from './components/goods/GoodsList.vue'
import Feedback from './components/feedback/Feedback.vue'
import Video from './components/videos/Video.vue'
import Contact from './components/contact/Contact.vue'
import NewsInfo from './components/news/NewsInfo.vue'
import PhotoInfo from './components/photos/PhotoInfo.vue'
import GoodsInfo from './components/goods/GoodsInfo.vue'
import GoodsDetail from './components/goods/GoodsDetail.vue'
import GoodsComt from './components/goods/GoodsComt.vue'

Vue.use('VueRouter')

let router = new VueRouter({
	routes:[
		{path:'/', redirect: '/home'},
		{path:'/home', component:HomeContainer},
		{path:'/member', component:MemberContainer},
		{path:'/cart', component:CartContainer},
		{path:'/search', component:SearchContainer},
		{path:'/home/newslist', component:NewsList},
		{path:'/home/photolist', component:PhotoList},
		{path:'/home/goodslist', component:GoodsList},
		{path:'/home/feedback', component:Feedback},
		{path:'/home/video', component:Video},
		{path:'/home/contact', component:Contact},
		{path:'/home/newslist/newsinfo', component:NewsInfo},
		{path:'/home/photolist/photoinfo/:id', component:PhotoInfo},
		// {path:'/home/goodslist/goodsinfo/:id', component:GoodsInfo},
		{path:'/home/goodslist/goodsinfo/:id', component:GoodsInfo, name:'goodsinfo'},
		{path:'/home/goodslist/goodsdetail/:id', component:GoodsDetail},
		{path:'/home/goodslist/goodscomt/:id', component:GoodsComt},
	],
	linkActiveClass: 'mui-active'
})

export default router
