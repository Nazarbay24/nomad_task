<template>
	<header class="header">
		<ul class="header__menu nav nav-pills">
			<li class="nav-item">
				<router-link
					aria-current="page"
					class="nav-link"
					to="/contacts"
					>Контакты
				</router-link>
			</li>
			<li class="nav-item">
				<router-link
					class="nav-link"
					to="/profile"
					>Профиль
				</router-link>
			</li>
		</ul>
	</header>
</template>

<script lang="ts">
    import { computed } from 'vue';
    import { useStore } from 'vuex';

    export default {
    };
</script>

<style lang="less" scoped>
	.header {
		width: 992px;
		margin: 0 auto;
		height: 100px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
</style>
