<template>
	<div class="newsinfo-container">
		<h3 class="title">{{ newsinfo.title }}</h3>
		<p class="info"><span>发表时间：{{ newsinfo.publish_time }}</span><span>点击{{ newsinfo.clicks }}次</span></p>
		<div class="content" v-html="newsinfo.content"></div>
		<comment :id="id"></comment>
	</div>
</template>

<script>
	import comment from '../subcomponents/Comment.vue'
	export default {
		data(){
			return {
				id: this.$route.query.id,
				newsinfo: {}
			}
		},
		created(){
			this.getNewsInfo();
		},
		methods:{
			getNewsInfo(){
				this.$http.post('api.php?a=getNewsInfo',{id:this.id}).then(res=>{
					if (res.body.error == 0) {
						this.newsinfo = res.body.data.newsinfo
					}
				})
			},
		},
		components:{
			comment
		}
	}
</script>

<style lang="less">

	.newsinfo-container{
		padding: 4px;
		.title{
			font-size: 14px;
			color: red;
			text-align: center;
			line-height: 24px;
		}
		.info{
			display: flex;
			justify-content: space-between;
			color: #42AEFF;
			font-size: 12px;
		}
		.content{
			img{
				width: 100%;
			}
			p{
				line-height: 18px;
				font-size: 14px;
			}
		}
	}
</style>
