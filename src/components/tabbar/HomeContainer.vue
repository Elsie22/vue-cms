<template>
	<div class="home-container">
		<swiper :swipeList="swipeList" :flag="false"></swiper>
		<ul class="mui-table-view mui-grid-view mui-grid-9">
            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
            	<router-link to="/home/newslist">
                    <img src="../../images/menu1.png">
                    <div class="mui-media-body">新闻资讯</div>
                </router-link>
            </li>
           <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
            	<router-link to="/home/photolist">
                    <img src="../../images/menu2.png">
                    <div class="mui-media-body">图片分享</div>
                </router-link>
            </li>
            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
            	<router-link to="/home/goodslist">
                    <img src="../../images/menu3.png">
                    <div class="mui-media-body">商品购买</div>
                </router-link>
            </li>
            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
            	<router-link to="/home/feedback">
                    <img src="../../images/menu4.png">
                    <div class="mui-media-body">留言反馈</div>
                </router-link>
            </li>
            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
            	<router-link to="/home/video">
                    <img src="../../images/menu5.png">
                    <div class="mui-media-body">视频专区</div>
                </router-link>
            </li>
            <li class="mui-table-view-cell mui-media mui-col-xs-4 mui-col-sm-3">
            	<router-link to="/home/contact">
                    <img src="../../images/menu6.png">
                    <div class="mui-media-body">联系我们</div>
                </router-link>
            </li>
        </ul> 
	</div>
</template>

<script>
	import swiper from '../subcomponents/Swipe.vue'
	export default {
		data(){
			return {
				swipeList:[]
			}
		},
		created(){
			this.getSwipeList()
		},
		methods:{
			getSwipeList(){
				// GET /someUrl
				this.$http.get('api.php?a=getSwipeList').then(res => {
			    	// success callback
			    	if (res.body.error == 0) {
			    		this.swipeList = res.body.data.list
			    	}
				}, err => {
			    	// error callback
				});
			}
		},
		components:{
			swiper
		}
	}
</script>

<style lang="less" scoped>
	.home-container{
		.mui-table-view{
			background-color: #fff;
			img{
				height: 60px;
			}
		}
	}
</style>