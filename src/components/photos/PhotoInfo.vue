<template>
	<div class="photoinfo-container">
		<h3 class="title">{{ photoinfo.title }}</h3>
		<p class="info"><span>发表时间：{{ photoinfo.add_time }}</span><span>点击：{{ photoinfo.clicks }}次</span></p>
		<hr>
		<vue-preview class="photos" :slides="slide1" @close="handleClose"></vue-preview>
		<!-- <div class="thumbs">
			      	<img class="preview-img" v-for="(item, index) in slide1" :src="item.src" height="100" @click="$preview.open(index, list)" :key="item.src">
			    </div> -->
		<p class="summary">{{ photoinfo.summary }}</p>
		<commet v-bind:id="id"></commet>
	</div>
</template>

<script>
	import commet from '../subcomponents/Comment.vue'
	export default {
		data(){
			return {
				id: this.$route.params.id,
				photoinfo: {},
				slide1:[]
			}
		},
		created(){
			this.getPhotoInfo()
			this.getPrePhotos()
		},
		methods:{
			handleClose () {
		    	console.log('close event')
		    },
			getPhotoInfo(){
				this.$http.get('api.php?a=getPhotoInfo&id='+this.id).then(res=>{
					if (res.body.error == 0) {
						this.photoinfo = res.body.data.photoinfo
					}
				})
			},
			getPrePhotos(){
				this.$http.get('api.php?a=getPhotoImgs&id='+this.id).then(res=>{
					if (res.body.error == 0) {
						imgarr = res.body.data.photoimgs
						var imgs = [];
						imgarr.forEach(item => {
							imgs.push({
								src:item.imgurl,
								msrc:item.imgurl,
								w: 600,
								h: 400
							})
						})
						this.slide1 = imgs;
					}
				})
			}
		},
		components:{
			commet
		}
	}
</script>

<style lang="less">
	.photoinfo-container{
		padding: 6px;
		.title{
			font-size: 14px;
			color: #007aff;
			text-align: center;
			line-height: 26px;
		}
		.info{
			font-size: 12px;
			display: flex;
			justify-content: space-between;
		}
		.summary{
			font-size: 12px;
			line-height: 24px;
			color: #555;
			margin: 0;
		}
		.photos{
			width: 100%;
			margin-bottom: 10px;
			.my-gallery{
				width: 100%;
				overflow: hidden;
				// .clear{ clear:both}
			}
			figure{
				width: 31%;
				float: left;
				margin: 1%;
			}
			img{
				width: 100%;
				height: 72px;
			}
		}
	}
</style>
