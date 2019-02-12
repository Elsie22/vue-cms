<template>
	<div class="goodsdetail">
		<h4 class="title">{{ goodsdetail.title }}</h4>
		<div class="content" v-html="goodsdetail.content"></div>
	</div>
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				id: this.$route.params.id,
				goodsdetail: {}
			}
		},
		created(){
			this.getGoodsDetail()
		},
		methods:{
			getGoodsDetail(){
				this.$http.get('api.php?a=getGoodsDetail&id='+this.id).then(res=>{
					if (res.body.error == 0) {
						this.goodsdetail = res.body.data.goodsdetail
					}
				})
			}
		}
	}
</script>

<style type="text/css" lang="less">
	.goodsdetail{
		.title{
			text-align: center;
			font-size: 16px;
			padding: 6px;
			line-height: 24px;
			color: #007aff;
		}
		img{
			width: 100%;
			height: 100%;
		}
	}
</style>
