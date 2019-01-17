<template>
	<div class="mt-2">
		<div v-if="signedIn">
			<div class="form-group">
				<textarea 
					id="body"
					name="body"
					placeholder="Have something to say?"
					rows="5"
					class="form-control"
					required 
					v-model="body">
				</textarea>
			</div>

			<button type="submit" class="btn btn-default" @click="addReply">Post</button>
		</div>

		<p class="text-center" v-else>
			Please <a :href="loginRoute">sign in</a> to participate in this discussion.
		</p>
	</div>
</template>

<script>
	export default{

		data() {
			return {
				body: '',
				endpoint: location.pathname + '/replies'
			}
		},

		computed: {
			signedIn() {
				return window.App.signedIn;
			},

			loginRoute() {
				return this.$hostname + '/login';
			}
		},

		methods: {
			addReply() {
				axios.post(this.endpoint, {body: this.body})
				.then(({data}) => { //same as response.data
					this.body = '';

					flash('Your reply has been posted');

					this.$emit('created', data); //this is the axios reponse.data
				})
			}
		}
	}

</script>