<template>
	<v-dialog v-model="show" max-width="60%">
		<v-card class="elevation-12">
			<v-toolbar dark color='orange'>
				<v-toolbar-title>
					Change your password
				</v-toolbar-title>
			</v-toolbar>
			<v-card-text>
				<form ref="form" @submit.prevent="changePassword">
					<v-text-field
						v-model="oldPassword"
						name="oldPassword"
						label="Current Password"
						type="password"
						placeholder="Enter your current password"
						@input="resetMessage"
						required
					></v-text-field>

					<v-text-field
						v-model="newPassword"
						name="newPassword"
						label="New Password"
						type="password"
						placeholder="Enter your new password"
						required
					></v-text-field>

					<v-text-field
						v-model="retypePassword"
						name="retypePassword"
						label="Re-type password"
						type="password"
						placeholder="Re-type your new password"
						@input="verifyMatch"
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
							Change
						</v-btn>
					</v-col>
				</form>
			</v-card-text>
		</v-card>
		<v-progress-linear
			indeterminate
			color="cyan"
			:active="isLoading"
		></v-progress-linear>
	</v-dialog>
</template>

<script>
import { customAxios } from '@/axios'

export default {
	name: "ChangePasswordDialog",

	props: {
		value: Boolean,
	},

	data() {
		return {
			oldPassword: '',
			newPassword: '',
			retypePassword: '',
			errorMessage: null,
			isLoading: false,
		}
	},

	methods: {
		changePassword() {
			let data = {
				oldPassword: this.oldPassword,
				newPassword: this.newPassword
			};
			this.isLoading = true;

			customAxios.
				post('/api/account/password/change',  data).
				then(response => {
					swal("Success!", response.data.message, "success");
				}).
				catch(error => {

				});

			this.isLoading = false;
		},

		resetMessage() {
			this.errorMessage = null;
		},

		verifyMatch() {
			if(this.newPassword != this.retypePassword) {
				this.errorMessage = 'Retype password must match the new password.'
			} else {
				this.errorMessage = null;
			}
		}
	},

	computed: {
		show: {
			get () {
				return this.value
			},
			set (value) {
				this.$emit('input', value)
			}
		}
	},
}
</script>
