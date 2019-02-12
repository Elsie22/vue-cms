<template>
	<div class="goodsinfo-container">
		<transition 
			v-on:before-enter="beforeEnter"
			v-on:enter="enter"
			v-on:after-enter="afterEnter">
			<div class="ball" v-show="flag" ref="ball"></div>
		</transition>
		
		<swiper :swipeList="goodswipe" :flag="true"></swiper>
		<div class="cards">
			<div class="mui-card">
				<div class="mui-card-header">{{ goodsinfo.title }}</div>
				<div class="mui-card-content">
					<div class="mui-card-content-inner">
						<p>市场价：<span class="mprice">￥{{ goodsinfo.market_price }}</span>&nbsp;&nbsp;&nbsp;销售价：<span class="sprice">￥{{ goodsinfo.sell_price }}</span></p>
						<div class="num">
							购买数量 
							<numbox @getCount="showCount"></numbox>
						</div>
						<p>
							<mt-button type="primary">立即购买</mt-button>
							<mt-button type="danger" @click="addToCart">加入购物车</mt-button>
						</p>
					</div>
				</div>
			</div>
			<div class="mui-card info">
				<div class="mui-card-header">商品参数</div>
				<div class="mui-card-content">
					<div class="mui-card-content-inner">
						<p>商品货号：{{ goodsinfo.art_no }}</p>
						<p>库存情况：{{ goodsinfo.stock_quantity }}件</p>
						<p>上架时间：{{ goodsinfo.add_time | dateFormat('YYYY-MM-DD') }}</p>
					</div>
				</div>
				<div class="mui-card-footer">
					<mt-button type="primary" size="large" plain @click="goDetail(goodsinfo.id)">图文介绍</mt-button>
					<mt-button type="danger" size="large" plain @click="goComments(goodsinfo.id)">商品评论</mt-button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import swiper from '../subcomponents/Swipe.vue'
	import numbox from '../subcomponents/Numbox.vue'
	export default {
		data(){
			return {
				flag: false,
				id:this.$route.params.id,
				selectedCount: 1,
				goodsinfo:{},
				goodswipe:[]
			}
		},
		created(){
			this.getGoodsInfo();
			this.getGoodsSwipe();
		},
		methods:{
			getGoodsInfo(){
				this.$http.get('api.php?a=getGoodsInfo&id='+this.id).then(res=>{

					if (res.body.error == 0) {
						this.goodsinfo = res.body.data.goodsinfo
					}
				})
			},
			getGoodsSwipe(){
				this.$http.get('api.php?a=getPhotoImgs&id='+this.id).then(res=>{
					if (res.body.error == 0) {
						this.goodswipe = res.body.data.photoimgs
					}
				})
			},
			goDetail(){
				this.$router.push('/home/goodslist/goodsdetail/'+this.id)
			},
			goComments(){
				this.$router.push({path: '/home/goodslist/goodscomt/'+this.id})
			},
			beforeEnter(el){
				el.style.transform = 'translate(0, 0)'
			},
			enter(el,done){
				el.offsetWidth;
				let pball = this.$refs.ball.getBoundingClientRect();
				let pcart = document.getElementsByClassName('mui-badge')[0].getBoundingClientRect();
				let dx = pcart.left - pball.left;
				let dy = pcart.top - pball.top;
				el.style.transform = `translate(${dx}px, ${dy}px)`
				el.style.transition = 'all 0.4s cubic-bezier(0,-0.26,.72,.96)'
				done()
			},
			afterEnter(el){
				this.flag = !this.flag
			},
			addToCart(){
				this.flag = !this.flag
				let goods = {
					id: this.id,
					count: this.selectedCount,
					price: this.goodsinfo.sell_price,
					selected: true
				}
				this.$store.commit('addToCart',goods)
			},
			showCount(count){
				this.selectedCount = count
			}

		},
		components:{
			swiper,
			numbox
		}
	}
</script>

<style lang="less" scoped>
	.goodsinfo-container{
		background: #eee;
		position: relative;
		.ball{
			width: 16px;
			height: 16px;
			border-radius: 50%;
			background: red;
			position: absolute;
			left: 132px;
			top: 324px;
			z-index: 99;
		}
		.cards{
			padding: 8px;
		}
		.mui-card{
				margin: 0;
			}
		.mui-card-header{
			font-size: 16px;
		}
		.mui-card-content{
			p{
				font-size: 12px;
			}
		}
		.mprice{
			text-decoration: line-through;
		}
		.sprice{
			font-size: 14px;
			font-weight: bold;
			color: red;
		}
		.info{
			margin: 8px 0 0;
			.mui-card-footer{
				display: block;
				.mint-button:nth-child(1){
					margin-bottom: 8px;
				}
			}
		}
		.num{
			font-size: 12px;
			color: #999;
			margin-bottom: 10px;
			.mui-numbox{
				height: 28px;
				margin-left: 6px;
			}
		}
	}
</style>
