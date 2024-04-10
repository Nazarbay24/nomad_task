<template>
	<PrimaryHeader v-if="authenticated"/>
	<main class="main">
		<router-view />
	</main>
</template>

<script lang="ts">
    import {computed, defineComponent} from 'vue';
	import PrimaryHeader from './components/PrimaryHeader.vue';
    import {useStore} from "vuex";

	export default defineComponent({
		components: {
			PrimaryHeader,
		},
		setup() {
            const store = useStore();
            const authenticated = computed(() => store.state.authenticated);

            return {
                authenticated
            };
		},
	});
</script>

<style lang="less" scoped>
	.main {
		width: 992px;
		margin: 0 auto;
		padding: 40px;
	}
</style>
