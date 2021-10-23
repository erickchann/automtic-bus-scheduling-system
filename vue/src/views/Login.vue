<template>
	<div class="container">
		<div class="card mt-4">
			<div class="card-header">
				Login
			</div>

			<div class="card-body">
				<form @submit.prevent="login">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Enter username" v-model="formData.username">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" v-model="formData.password">
					</div>

					<button type="submit" class="btn btn-primary">Login</button>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
import axios from 'axios'

export default {
	data() {
		return {
			formData: {
				username: '',
				password: ''
			}
		}
	},
	methods: {
		login() {
			axios.post(`auth/login`, this.formData)
				.then(res => {
					localStorage.setItem('token', res.data);
					
					this.$router.push('/bus');
				})
				.catch(err => {
					alert(err.response.data.message);
				}); 		
		}
	},
}
</script>