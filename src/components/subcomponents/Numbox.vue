<template>
	<div class="mui-numbox" data-numbox-min='1' data-numbox-max='99'>
		<button class="mui-btn mui-btn-numbox-minus" type="button">-</button>
		<input id="test" class="mui-input-numbox" type="number" ref="numbox" @change="changed" :value="initCount" />
		<button class="mui-btn mui-btn-numbox-plus" type="button">+</button>
	</div>
</template>

<script type="text/javascript">
	import mui from '../../lib/mui/js/mui.min.js'
	export default {
		data(){
			return {
				count: 1,
			}
		},
		props:['initCount','goodsid'],
		mounted(){
			mui('.mui-numbox').numbox()
		},
		methods:{
			changed(){
				//为什么不用双向数据绑定？
				this.$emit('getCount',parseInt(this.$refs.numbox.value))
				this.$store.commit('countChanged',{id: this.goodsid, count: parseInt(this.$refs.numbox.value)})
			}
		}
	}
</script>

<style type="text/css" lang="less" scoped>
	
</style>
