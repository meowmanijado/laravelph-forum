<template>
	<div>
		<div v-for="(reply, index) in items">
			<reply :data="reply" @deleted="removed(index)"></reply>
		</div>
	</div>
</template>

<script type="text/javascript">
	import Reply from './Reply.vue';

	export default {
		props: ['data'],
		components: { Reply },
		data() {
			return {
				items: this.data
			}
		},
		methods: {
			removed(index) {
				this.items.splice(index, 1);
				this.$emit('removed');
				flash('Reply was deleted');
			}
		}
	}
</script>