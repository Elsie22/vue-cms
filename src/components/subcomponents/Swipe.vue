<template>
	<div class="swipe-container">
		<mt-swipe :auto="3000">
		  <mt-swipe-item v-for="item in swipeList" :key="item.id"><img :src="item.imgurl" :class="{'full':flag}"></mt-swipe-item>
		</mt-swipe>
	</div>
</template>

<script type="text/javascript">
	export default {
		data(){
			return {
				
			}
		},
		props:['swipeList', 'flag'],
		methods:{
		}
	}
</script>

<style lang="less" scoped>
	.swipe-container{
		.mint-swipe{
			height: 200px;
		}
		.mint-swipe-item{
			overflow: hidden;
			text-align: center;
			img{
				//width: 100%;
				height: 100%
			}
		}
		.full{
			width: 100%;
		}
	}
</style>
