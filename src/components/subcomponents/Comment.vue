<template>
	<div class="comment-container">
		<h3>发表评论</h3>
		<hr>
		<textarea placeholder="请输入评论（不超过120个字）" v-model="comment"></textarea>
		<mt-button type="primary" size="large" @click="submitCmt">发表评论</mt-button>
		<ul>
			<li v-for="(item,i) in cmtlist" :key="item.id">
				<p class="cmtinfo">第{{i+1}}楼 &nbsp;&nbsp; 用户:{{ !item.user_name ? '匿名用户' : item.user_name }} &nbsp;&nbsp; 发表时间:{{ item.add_time | dateFormat }}</p>
				<p class="cmtcont">{{ item.content }}</p>
			</li>
		</ul>
		<mt-button type="danger" size="large" @click="getMore">加载更多</mt-button>
	</div>
</template>

<script>
	import { Toast } from 'mint-ui'
	export default {
		data(){
			return {
				pageIndex: 1,
				cmtlist:[],
				comment: ''
			}
		},
		props:['id'],
		created(){
			this.getNewsCmt()
		},
		methods:{
			getNewsCmt(){
				this.$http.get('api.php?a=getNewsCmt&id='+this.id+'&pageIndex='+this.pageIndex).then(res=>{
					if (res.body.error == 0) {
						this.cmtlist = this.cmtlist.concat(res.body.data.cmtlist)
					}
				})
			},
			getMore(){
				this.pageIndex++;
				this.getNewsCmt()
			},
			submitCmt(){
				if (!this.comment) {
					return Toast({message:'评论内容不能为空', duration:600});
				}
				this.$http.post('api.php?a=submitCmt',{id:this.id, content:this.comment}).then(res=>{
					if (res.body.error == 0) {
						Toast({message:'评论成功', duration:500});
						let cmt = { user_name:'匿名用户', content:this.comment, add_time: Date.now()}
						this.cmtlist.unshift(cmt);
						this.comment = ''
					}
				})
			}
		}
	}
</script>

<style lang="less" scoped>
	.comment-container{
		h3{
			font-size: 16px;
		}
		textarea{
			height: 88px;
			font-size: 14px;
			margin: 0;
		}
		ul{
			margin: 6px 0;
			padding: 0;
			li{
				list-style: none;
				p{
					margin: 0;
				}
				.cmtinfo{
					background: #eee;
					font-size: 12px;
					line-height: 22px;
				}
				.cmtcont{
					line-height: 24px;
				}

			}
		}
	}
</style>
