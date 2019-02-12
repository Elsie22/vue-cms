<template>
	<div class="goodscomt">
		<comment :id="id"></comment>
	</div>
</template>

<script type="text/javascript">
	import comment from '../subcomponents/Comment.vue'
	export default {
		data(){
			return {
				id: this.$route.params.id
			}
		},
		components:{
			comment
		}
	}
</script>

<style type="text/css" lang="less" scoped>
	.goodscomt{
		padding: 6px;
	}
</style>
