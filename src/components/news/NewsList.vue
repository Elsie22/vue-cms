<template>
	<div class="newslist-container">
		<ul class="mui-table-view">
			<li class="mui-table-view-cell mui-media" v-for="item in newsList" :key="item.id">
				<router-link :to="'/home/newslist/newsinfo?id='+item.id">
					<img class="mui-media-object mui-pull-left" :src="item.imgurl">
					<div class="mui-media-body">
						<h4 class="mui-ellipsis">{{ item.title }}</h4>
						<p><span>发表时间：{{ item.publish_time }}</span><span>点击：{{ item.clicks }}次</span></p>
					</div>
				</router-link>
			</li>
		</ul>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				newsList:[]
			}
		},
		created(){
			this.getNewsList()
		},
		methods:{
			getNewsList(){
				this.$http.get('api.php?a=getNewsList').then(res=>{
					if (res.body.error == 0) {
						console.log()
						this.newsList = res.body.data.list;
					}
				})
			}
		}
	}
</script>

<style lang="less" scoped>
	.newslist-container{
		.mui-table-view{
			h4{
				font-size: 14px;
				font-weight: normal;
			}
			p{
				font-size: 12px;
				color: #42AEFF;
				display: flex;
				justify-content: space-between;
			}
		}
	}
</style>