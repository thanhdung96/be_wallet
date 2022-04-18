<template>
	<base-material-card>
		<v-card-text class="text-center">
			<div class="display-2 font-weight-light">Edit Your Setting</div>

			<v-form @submit.prevent="saveSetting">
				<v-container class="py-0">
					<v-row>
						<v-col cols="12">
							<v-switch
								v-model="setting.darkMode"
								color="primary"
								label="Dark Mode"
							></v-switch>
						</v-col>

						<v-col cols="12">
							<v-select
								v-model="setting.language"
								:items="languages"
								item-text="languageName"
								item-value="value"
								label="Display Language"
							></v-select>
						</v-col>

						<v-col cols="12">
							<v-select
								v-model="setting.currency"
								:items="currencies"
								item-text="currencyName"
								item-value="id"
								label="Default currency"
							></v-select>
						</v-col>
					</v-row>
				</v-container>

				<v-btn
					color="success"
					class="mr-0"
					type="submit"
					rounded
				>
					Save Setting
				</v-btn>
			</v-form>
		</v-card-text>
	</base-material-card>
</template>

<script>
import { customAxios } from '@/axios'

export default {
	name: "AccountSettingCard",

	data() {
		return {
			setting: {
				id: -1,
				darkMode: true,
				language: 'en',
				currency: null,
			},
			languages: [
				{
					languageName: 'English',
					value: 'en'
				},
				{
					languageName: 'Francais',
					value: 'fr'
				},
				{
					languageName: 'Tiếng Việt',
					value: 'vi'
				},
			],
			currencies: [],
		}
	},

	watch: {
		'setting.darkMode'(newVal) {
			this.$vuetify.theme.dark = newVal;
		},
	},

	created() {
		customAxios
			.get('/public/api/currency')
			.then(response => {
				this.currencies = response.data.currencies;
			});
	},

	mounted() {
		customAxios
			.post('api/setting/')
      		.then(response => {
				let data = response.data.setting;

				this.setting.id = data.id;
				this.setting.darkMode = data.darkMode;
				this.setting.language = data.language;
				this.setting.currency = data.currency.id;
			})
			.catch(error => {
				swal('Oops!', "Something with the setting went wrong", 'error');
			});
	},

	methods: {
		saveSetting() {
			customAxios
				.post('/api/setting/save', this.setting)
				.then(response => {
					swal('Success!', response.data.message, 'success');
				})
				.catch(error => {
					swal('Oops!', error.data.message, 'error');
				});
		},
	},
}
</script>
