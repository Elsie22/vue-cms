<template>
	<div class="cart-container">
		<div class="goodsList">
			<div class="mui-card" v-for="(item,i) in goodsList" :key="item.id">
				<div class="mui-card-content">
					<div class="mui-card-content-inner">
						<mt-switch v-model="$store.getters.getGoodsStatus[item.id]" @change="selectChanged(item.id)"></mt-switch>
						<img :src="item.img_url">
						<div class="detail">
							<h4>{{item.title}}</h4>
							<p>
								<span class="price">￥{{item.price}}</span>
								<numbox :initCount="$store.getters.getGoodsCount[item.id]" :goodsid="item.id"></numbox>
								<span class="del" @click="del(item.id,i)">删除</span>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mui-card settle">
			<div class="mui-card-content">
				<div class="mui-card-content-inner">
					<div >
						<p>总计（不含运费）</p>
						<p>已勾选商品<span>{{$store.getters.getCountsAmounts.count}}</span>件，总价：<span>￥{{$store.getters.getCountsAmounts.amount}}</span></p>
					</div>
					<mt-button type="danger">去结算</mt-button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import numbox from '../subcomponents/Numbox.vue'
	export default {
		data(){
			return {
				selectedCount: 0,
				cartList: this.$store.state.cartList,
				goodsList: []
			}
		},
		created(){
			this.getCtGdsInfo();
		},
		methods:{
			selectChanged(id , selected){
				this.$store.commit('selectChange',id);
			},
			getCtGdsInfo(){
				let idArr = []
				this.cartList.forEach(item=>{
					idArr.push(item.id)
				})
				if (idArr.length > 0) {
					console.log(idArr.join(','))
					this.$http.get('api.php?a=getCtGdsInfo&idarr='+idArr.join(',')).then(res=>{
						if (res.body.error == 0) {
							console.log(res)
							this.goodsList = res.body.data.gdsInfo;
						}
					})
				}
			},
			del(id,i){
				this.goodsList.splice(i, 1)
				this.$store.commit('delGoods',id);
			}
		},
		components:{
			numbox
		}
	}
</script>

<style lang="less" scoped>
	.cart-container{
		.goodsList{
			background: #eee;
			overflow: hidden;
			.mui-card{
				.mui-card-content-inner{
					display: flex;
					align-items: center;
				}
				img{
					width: 60px;
					height: 60px;
					margin: 0 4px;
				}
				.mui-numbox{
					height: 28px;
				}
				.detail{
					display: flex;
					flex-direction: column;
					justify-content: space-between; 
					h4{
						font-size: 14px;
						margin: 2px 0 8px;
						text-overflow: -o-ellipsis-lastline;
						overflow: hidden;
						text-overflow: ellipsis;
						display: -webkit-box;
						-webkit-line-clamp: 2;
						line-clamp: 2;
						-webkit-box-orient: vertical;
					}
					p{
						margin: 0;
						font-size: 12px;
					}
					.price{
						color: red;
						font-weight: bold;
					}
					.del{
						color: #007aff;
					}
				}
			}
		}
		.settle{
			.mui-card-content-inner{
				display: flex;
				justify-content: space-between;
				align-items: center;
			}
			p{
				font-size: 12px;
				margin: 0;
				span{
					font-size: 16px;
					color: red;
					font-weight: bold;
				}
			}
		}
	}
</style>