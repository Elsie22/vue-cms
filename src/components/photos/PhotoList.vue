<template>
	<div class="photolist-container">
		<div id="slider" class="mui-slider">
			<div id="sliderSegmentedControl" class="mui-scroll-wrapper mui-slider-indicator mui-segmented-control mui-segmented-control-inverted">
				<div class="mui-scroll">
					<a :class="['mui-control-item', item.id==0?'mui-active':'']" v-for="item in categories" :key="item.id" @tap="getPhotoList(item.id)">
						{{ item.category }}
					</a>
				</div>
			</div>
		</div>
		<div class="photo_list">
			<router-link tag="div" class="photo_box" v-for="item in photolist" :key="item.id" :to="'/home/photolist/photoinfo/'+item.id">
				<img v-lazy="item.imgurl">
				<div class="imginfo">
					<h4>{{ item.title }}</h4>
					<p>{{ item.summary }}</p>
				</div>
			</router-link>
		</div>
	</div>
</template>

<script>
	import mui from '../../lib/mui/js/mui.min.js';
	import '../../lib/mui/js/webviewGroup.js'

	export default {
		data(){
			return {
				categories:[],
				photolist:[]
			}
		},
		created(){
			this.getCategory();
			this.getPhotoList(0)
		},
		mounted(){
			mui('.mui-scroll-wrapper').scroll({
				deceleration: 0.0005 //flick 减速系数，系数越大，滚动速度越慢，滚动距离越小，默认值0.0006
			});
		},
		methods:{
			getCategory(){
				this.$http.get('api.php?a=getCategory').then(res=>{
					if (res.body.error == 0) {
						this.categories = res.body.data.categories;
						this.categories.unshift({id:0, category:'全部'})
					}
				})
			},
			getPhotoList(id){
				this.$http.get('api.php?a=getPhotosByCate&id='+id).then(res=>{
					if (res.body.error == 0) {
						this.photolist = res.body.data.photolist
					}else{
						this.photolist = []
					}
				})
			}
		}
	}
</script>

<style lang="less">
	// * { touch-action: none; }
	.photolist-container{
		.photo_list{
			padding: 6px;
			.photo_box{
				background: #ccc;
				margin-bottom: 6px;
				position: relative;
				border-radius: 4px;
				text-align: center;
				box-shadow: 0 0 4px 1px rgba(0,0,0,0.3);
				img{
					border-radius: 4px;
					width: 100%;
				}
				img[lazy=loading] {
					width: 40px;
					height: 300px;
					margin: auto;
				}
				.imginfo{
					text-align: justify;
					max-height: 92px;
					width: 100%;
					border-radius: 0 0 4px 4px;
					position: absolute;
					bottom: 0;
					background: rgba(0,0,0,0.4);
					color: #fff;
					padding: 4px;
					h4{
						font-size: 14px;
					}
					p{
						font-size: 12px;
						color: #fff;
						margin: 0;
					}
				}
			}
		}
	}
</style>