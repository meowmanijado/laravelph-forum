<template>
	<div>
		<div v-for="(reply, index) in items" :key="reply.id">
			<reply :data="reply" @deleted="removed(index)"></reply>
		</div>
		<new-reply :endpoint="endpoint" @created="add"></new-reply>
	</div>
</template>

<script type="text/javascript">
	import Reply from './Reply.vue';
	import NewReply from './NewReply.vue';

	export default {
		props: ['data'],
		components: { Reply, NewReply },
		data() {
			return {
				items: this.data,
				endpoint: location.pathname + '/replies'
			}
		},
		methods: {
			add(reply) {
				this.items.push(reply);

				this.$emit('added');
			},

			removed(index) {
				this.items.splice(index, 1);
				this.$emit('removed');
				flash('Reply was deleted');
			}
		}
	}
</script>