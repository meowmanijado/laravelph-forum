<template>
	<div>
		<!-- @if (auth()->check())
            <form method="POST" action="{{ $thread->path() . '/replies' }}"> -->
                <div class="form-group">
                    <textarea name="body" 
							  id="body" 
							  class="form-control" 
							  placeholder="Have something to say?" 
							  rows="5" required 
							  v-model="body"></textarea>
                </div>
                <button type="submit" 
						class="btn btn-default" 
						@click="addReply">Post</button>
       <!--      </form>
        @else
            <p class="text-center">Please <a href="{{ route('login') }}">sign</a> in to participate in this discusiion.</p>
        @endif -->
	</div>
</template>
<script type="text/javascript">
	export default {
		data() {
			return {
				body: '',
				endpoint: '/threads/cumque/63/replies'
			};
		},
		methods: {
			addReply() {
				axios.post(this.endpoint, { body: this.body })
					 .then(({data}) => {
						this.body = '';
						flash('Your reply has been posted.');
						this.$emit('created', data);
					 });
			}
		}
	}
</script>