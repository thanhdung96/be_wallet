<template>
	<form ref="form" @submit.prevent="saveWallet">
		<v-text-field
			v-model="wallet.id"
			name="id"
			v-if="false"
			required
		></v-text-field>

		<v-text-field
			v-model="wallet.name"
			name="walletName"
			label="Category Name"
			type="text"
			placeholder="Category Name"
			required
		></v-text-field>

		<v-text-field
			v-model="wallet.balance"
			name="walletBalance"
			label="Current Balance"
			type="number"
			placeholder="Current Balance"
			required
		></v-text-field>

		<v-select
			v-model="wallet.currency"
			:items="decoration.currencies"
			item-text="currencyName"
			item-value="id"
			label="Default currency"
		>
		</v-select>

		<v-row>
			<v-col>
				<v-color-picker
					v-model="wallet.colour"
					dot-size="7"
					hide-mode-switch
					mode="hex"
					:show-swatches="decoration.showSwatches"
					swatches-max-height="70"
				></v-color-picker>
			</v-col>
			<v-col>
				<v-checkbox
					v-model="decoration.showSwatches"
					label="Show Presets"
				>
				</v-checkbox>
			</v-col>
		</v-row>

		<v-col class="text-right">
			<v-btn type="submit" class="mt-4" color="primary" value="log in">
				Save
			</v-btn>
		</v-col>
	</form>
</template>

<script>
import { customAxios } from '@/axios'

export default {
	name: "UserWalletCard",

	props: {
		walletId: Number,
	},

	data() {
		return {
			wallet: {
				id: -1,
				name: null,
				balance: null,
				currency: null,
				colour: '#4caf50',
			},
			decoration: {
				showSwatches: false,
				currencies: [],
				modalTitle: null,
				needsUpdate: true,
			},
		}
	},

	created() {
		this.getListCurrencies();
		this.updateInfo();
	},

	watch: {
		walletId: function(newVal, oldVal){
			if(this.walletId == -1){
				this.wallet.id = -1;
				this.wallet.name = null;
				this.wallet.balance = null;
				this.wallet.currency = null;
				this.wallet.colour = '#4caf50';
			} else {
				this.updateInfo();
			}
		},
	},

	methods: {
		saveWallet() {
			let selectedCurrencyId = this.wallet.id == -1 ? this.wallet.currency : this.wallet.currency.id;
			let data = {
				id: this.wallet.id,
				name: this.wallet.name,
				amount: this.wallet.balance,
				currency: selectedCurrencyId,
				color: this.wallet.colour,
			};

			customAxios
				.post('api/wallet/save', data)
				.then(response => {
					swal("Success", 'Wallet saved', 'success');
				})
				.catch(error => {
					swal("Oops!", error.data, "error");
				})
		},

		updateInfo() {
			if(this.walletId != -1){
				let rootComponent = this;
				let data = {
					id: this.walletId,
				};
				customAxios
					.post('api/wallet/detail', data)
					.then(response => {
						let returnedData = response.data.wallet;

						rootComponent.wallet.id = returnedData.id;
						rootComponent.wallet.name = returnedData.name;
						rootComponent.wallet.balance = returnedData.amount;
						rootComponent.wallet.currency = returnedData.currency;
						rootComponent.wallet.colour = returnedData.color;
					})
					.catch(error => {
						swal("Oops!", error.data, "error");
					});
			}
		},

		getListCurrencies(){
			customAxios
				.get('/public/api/currency')
				.then(response => {
					this.decoration.currencies = response.data.currencies;
				});
		}
	}
}
</script>
