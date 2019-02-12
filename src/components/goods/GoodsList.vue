<template>
	<div class="goodslist-container">
		<ul>
			<li v-for="item in goodsList" :key="item.id" @click="goGoodsInfo(item.id)">
				<img :src="item.img_url" alt="">
				<div class="info">
					<h4 class="title">{{ item.title }}</h4>
					<p><span class="sell_price">￥{{ item.sell_price }}</span> <span class="market_price"> ￥{{ item.market_price }}</span></p>
					<p class="tip"><span>热卖中</span><span>剩{{ item.stock_quantity }}件</span></p>
				</div>
			</li>
		</ul>
		<mt-button type="danger" size="large" @click="getMore">加载更多</mt-button>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				pageIndex: 1,
				goodsList:[]
			}
		},
		created(){
			this.getGoodsList();
		},
		methods:{
			getGoodsList(){
				this.$http.get('api.php?a=getGoodsList&pageIndex='+this.pageIndex).then(res=>{
					if (res.body.error == 0) {
						this.goodsList = this.goodsList.concat(res.body.data.goodsList);
					}
				})
			},
			getMore(){
				this.pageIndex++;
				this.getGoodsList();
			},
			goGoodsInfo(id){
				/*this.$router.push({path:'/home/goodslist/goodsinfo/'+id})*/
				this.$router.push({name:'goodsinfo', params:{ id:id }})
			}
		}
	}
</script>

<style lang="less" scoped>
	.goodslist-container{
		padding: 6px;
		ul{
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			li{
				width: 49%;
				border-radius: 4px;
				box-shadow: 0 0 2px 1px rgba(0,0,0,0.2);
				margin-bottom: 6px;
				display: flex;
				flex-direction: column;
				justify-content: space-between;
				img{
					width: 100%;
					border-radius: 4px 4px 0 0;
				}
				.title{
					padding: 0 4px;
					font-size: 14px;
					font-weight: bold;
					color: #111;
					line-height: 18px;
					text-align: justify;
				}
				.info{
					padding: 2px;
					p{
						background: #eee;
						margin: 0;
						padding: 0 2px;
					}
					.sell_price{
						color: red;
						font-weight: bold;
					}
					.market_price{
						font-size: 12px;
						text-decoration: line-through;
					}
					.tip{
						display: flex;
						justify-content: space-between;
						font-size: 12px;
					}

				}
			}
		}
	}
</style>