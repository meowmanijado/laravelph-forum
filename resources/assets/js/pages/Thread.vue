<script type="text/javascript">
	import Replies from '../components/Replies.vue';
	import SubscribeButton from '../components/SubscribeButton.vue';

	export default {
		props: ['thread'],
		components: { Replies, SubscribeButton },
		data() {
			return {
				repliesCount: this.thread.replies_count,
				locked: this.thread.locked
			}
		},

		methods: {
			toggleLock () {
				// ajax
				axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);
				this.locked = ! this.locked;
			}
		}
	}
</script>