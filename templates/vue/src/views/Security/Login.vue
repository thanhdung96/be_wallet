<template>
	<v-card class="elevation-12">
	   <v-toolbar dark color="primary">
		  <v-toolbar-title>Login form</v-toolbar-title>
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
			 <v-btn type="submit" class="mt-4" color="primary" value="log in">
				 Login
			 </v-btn>
		</form>
	   </v-card-text>
   </v-card>
</template>

<script>
import axios from 'axios'
import VueAxios from 'vue-axios'
import { router } from '../../router'

export default {
	name: "UserLogin",

	data () {
		return {
			username: "",
			password: "",
			errorMessage: null,
		}
	},

	methods: {
		login(event) {
			if(event){
				let data = {
					email: this.username,
					password: this.password
				};
				let url = this.$hostname + '/api/auth/login';

				axios.
					post(url,  data).
					then(response => {
						if(response.data.token){
							localStorage.setItem('user', JSON.stringify(response.data));
							router.push({name: 'Dashboard'});
						}
					}).
					catch(
						error => this.errorMessage = error.response.data.message
					);
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
