<template>
	<div class="app-container">
		<mt-header fixed title="vue-商城"></mt-header>
		<transition mode="out-in">
			<router-view class="main-content">中间内容部分</router-view>
		</transition>
		<nav class="mui-bar mui-bar-tab">
			<router-link class="mui-tab-item1" to="/home">
				<span class="mui-icon mui-icon-home"></span>
				<span class="mui-tab-label">首页</span>
			</router-link>
			<router-link class="mui-tab-item1" to="/member">
				<span class="mui-icon mui-icon-contact"></span>
				<span class="mui-tab-label">会员</span>
			</router-link>
			<router-link class="mui-tab-item1" to="/cart">
				<span class="mui-icon mui-icon-extra mui-icon-extra-cart"><span class="mui-badge">{{ $store.getters.allCounts }}</span></span>
				<span class="mui-tab-label">购物车</span>
			</router-link>
			<router-link class="mui-tab-item1" to="/search">
				<span class="mui-icon mui-icon-search"></span>
				<span class="mui-tab-label">搜索</span>
			</router-link>
		</nav>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				
			}
		},
		methods:{
			boforeEnter(el){
				el.style.trasform = "translateX(100%)"
			},
			enter(el,done){
				el.offsetWidth;
				el.style.transform = "translateX(0)";
				el.style.transition = "all 0.5s ease"
				done()
			},
			afterEnter(el){
				
			}
		}
	}
</script>

<style lang="less" scoped>
	.v-enter{
		transform: translateX(100%);
	}
	.v-leave-to{
		transform: translateX(-100%);
	}
	.v-enter-active, .v-leave-active{
		transition: all 0.3s ease;
	}
	.app-container{
		padding-top: 40px;
		padding-bottom: 50px;
		overflow-x: hidden;
		.mint-header{
			z-index: 999;
		}
		.main-content{
			
		}
		.mui-bar-tab .mui-tab-item1.mui-active {
	      	color: #007aff;
	    }
		.mui-bar-tab .mui-tab-item1 {
		    display: table-cell;
		    overflow: hidden;
		    width: 1%;
		    height: 50px;
		    text-align: center;
		    vertical-align: middle;
		    white-space: nowrap;
		    text-overflow: ellipsis;
		    color: #929292;
		}
		.mui-bar-tab .mui-tab-item1 .mui-icon {
		    top: 3px;
		    width: 24px;
		    height: 24px;
		    padding-top: 0;
		    padding-bottom: 0;
		}
		.mui-bar-tab .mui-tab-item1 .mui-icon~.mui-tab-label {
		    font-size: 11px;
		    display: block;
		    overflow: hidden;
		    text-overflow: ellipsis;
		}
	}
</style>