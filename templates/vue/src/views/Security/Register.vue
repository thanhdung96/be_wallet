<template lang="html">
	<v-card class="elevation-12">
		<v-toolbar dark color="error">
			<v-toolbar-title>Registratrion</v-toolbar-title>
		</v-toolbar>
		<v-card-text>
		<form ref="form" @submit.prevent="register">
			<v-text-field
				v-model="username"
				name="username"
				label="Username"
				type="text"
				placeholder="username"
				required
				@input="resetMessage"
			></v-text-field>

			<v-text-field
				v-model="email"
				name="email"
				label="Email"
				type="text"
				placeholder="username"
				required
				@input="resetMessage"
			></v-text-field>

			<v-text-field
				v-model="password"
				name="password"
				label="Password"
				type="password"
				placeholder="password"
				required
				@input="resetMessage"
			></v-text-field>

			<v-select
				v-model="defaultCurrency"
				:items="currencies"
				item-text="currencyName"
				item-value="id"
				label="Default currency"
				@change="resetMessage"
			>
			</v-select>

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
					 Register
				 </v-btn>
				 <p class="pt-5">
					 Already a member?
					 <router-link :to="{ name: 'Login' }">
						 Return to login.
					 </router-link>
				 </p>
			 </v-col>
		</form>
		</v-card-text>
	</v-card>
</template>

<script>
import { customAxios } from '@/axios'
import { router } from '@/router'

export default {
	name: "UserRegister",

	data() {
		return {
			currencies: [],
			defaultCurrency: null,
			username: null,
			email: null,
			password: null,
			errorMessage: null
		}
	},

	mounted() {
		customAxios
			.get('/public/api/currency')
			.then(response => {
				this.currencies = response.data.currencies
			})
	},

	methods: {
		register(event) {
			let data = {
				username: this.username,
				email: this.email,
				password: this.password,
				defaultCurrency: this.defaultCurrency
			};

			customAxios
				.post('/auth/register', data)
				.then(response => {
					router.push({ name: 'Login', params: { username: this. username } });
				})
				.catch(
					error => this.errorMessage = error.response.data.message
				);
		},

		resetMessage(event) {
			this.errorMessage = null;
		},
	}
}
</script>

<style lang="css" scoped>
</style>
