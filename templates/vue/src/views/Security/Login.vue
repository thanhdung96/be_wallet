<template>
	<v-card class="elevation-12">
	   <v-toolbar dark color="primary">
		  <v-toolbar-title>Login</v-toolbar-title>
	   </v-toolbar>
	   <v-card-text>
	   <form ref="form" @submit.prevent="login">
			  <v-text-field
				v-model="username"
				name="username"
				label="Username"
				type="text"
				placeholder="username"
				@input="resetMessage"
				required
			 ></v-text-field>

			  <v-text-field
				v-model="password"
				name="password"
				label="Password"
				type="password"
				placeholder="password"
				@input="resetMessage"
				required
			 ></v-text-field>
			 <v-alert
				dense
				elevation="12"
				outlined
				text
				type="error"
				v-if="errorMessage != null"
			>
				{{ errorMessage }}
			</v-alert>
			<v-col class="text-right">
				 <v-btn type="submit" class="mt-4" color="primary" value="log in">
					 Login
				 </v-btn>
				 <p class="pt-5">
					 Not a member?
					 <router-link :to="{ name: 'Register' }">
						 Signup now
					 </router-link>
				 </p>
			 </v-col>
		</form>
	   </v-card-text>
		<v-progress-linear
			indeterminate
			color="cyan"
			:active="isLoading"
		></v-progress-linear>
   </v-card>
</template>

<script>
import { customAxios } from '@/axios'
import { router } from '@/router'

export default {
	name: "UserLogin",

	props: {
		username: String,
	},

	data () {
		return {
			password: null,
			errorMessage: null,
			isLoading: false,
		}
	},

	methods: {
		login(event) {
			// toggle loading bar
			this.isLoading = true;

			if(event){
				let data = {
					email: this.username,
					password: this.password
				};

				customAxios.
					post('/auth/login',  data).
					then(response => {
						if(response.data.token){
							localStorage.setItem('user', JSON.stringify(response.data.token));
							let authToken = JSON.parse(localStorage.getItem('user'))['token'];
							customAxios.defaults.headers.common['Authorization'] = authToken;

							// apply application setting
							localStorage.setItem('setting', JSON.stringify(response.data.setting));
							this.$vuetify.theme.dark = JSON.parse(localStorage.getItem('setting')).darkMode;
							
							router.push({name: 'Dashboard'});
						}
					}).
					catch((error) => {
						this.errorMessage = error.response.data.message;
						// toggle loading bar
						this.isLoading = false;
					});
			}
		},

		resetMessage(event) {
			this.errorMessage = null;
		}
	}
}
</script>

<style lang="css" scoped>
</style>
