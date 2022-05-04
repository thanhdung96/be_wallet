<template>
	<form ref="form" @submit.prevent="saveTransaction">
		<v-text-field
			v-model="transaction.id"
			name="id"
			v-if="false"
			required
		></v-text-field>

		<v-row>
			<v-col md='6'>
				<v-menu
					v-model="decoration.menu2"
					:close-on-content-click="false"
					:nudge-right="40"
					transition="scale-transition"
					offset-y
					min-width="auto"
				>
					<template v-slot:activator="{ on, attrs }">
						<v-text-field
							:value="formattedDate"
							label="Picker without buttons"
							prepend-icon="mdi-calendar"
							readonly
							v-bind="attrs"
							v-on="on"
						></v-text-field>
					</template>

					<v-date-picker
						v-model="transaction.dateTime"
						@input="decoration.menu2 = false"
					></v-date-picker>
				</v-menu>

				<v-select
					v-model="transaction.category"
					:items="categories"
					item-text="name"
					item-value="id"
					label="Transaction Category"
				></v-select>

				<v-select
					v-model="transaction.type"
					:items="types"
					item-text="name"
					item-value="id"
					label="Transaction Type"
				></v-select>

				<v-select
					v-model="transaction.wallet"
					:items="wallets"
					item-text="name"
					item-value="id"
					label="From Wallet"
				></v-select>

				<v-select
					v-model="transaction.transferWallet"
					:items="wallets"
					item-text="name"
					item-value="id"
					label="To Wallet"
					v-if="decoration.showTransfer"
				></v-select>
			</v-col>

			<v-divider
				vertical
			></v-divider>

			<v-col md='6'>
				<v-text-field
					v-model="transaction.amount"
					name="fee"
					label="Amount"
					type='number'
				></v-text-field>

				<v-row v-if="decoration.showTransfer">
					<v-col :md='decoration.fromWalletLength'>
						<v-checkbox
							v-model="transaction.withFee"
							label="With Fee"
							color="primary"
							hide-details
						></v-checkbox>
					</v-col>
					
					<v-col md='6'>
						<v-text-field
							v-model="transaction.fee"
							name="fee"
							label="Transfer Fee"
							type='number'
							:disabled='!transaction.withFee'
						></v-text-field>
					</v-col>
				</v-row>

				<v-textarea
					v-model="transaction.note"
					name="note"
					label="Transaction Note"
					type="text"
					placeholder="Transaction Note"
					required
				></v-textarea>
			</v-col>
		</v-row>

		<v-col class="text-right">
			<v-btn type="submit" class="mt-4" color="primary" value="Save">
				Save
			</v-btn>
		</v-col>
	</form>
</template>
 
<script>
import { customAxios } from '@/axios'
import moment from 'moment'

export default {
	name: 'TransactionCard',

	props: {
		transactionId: Number,
		isUpdate: Boolean,
	},

	data() {
		return {
			transaction: {
				id: -1,
				note: null,
				type: null,
				amount: 0,
				wallet: null,
				transferWallet: null,
				withFee: true,
				fee: 0,
				category: null,
				dateTime: moment().format(new Date().toISOString(), 'YYYY-MM-DD'),
			},
			types: [
				{
					id: 0,
					name: 'Revenue',
				},
				{
					id: 1,
					name: 'Expense',
				},
				{
					id: 2,
					name: 'Transfer',
				},
			],
			categories: [],
			wallets: [],
			decoration: {
				showTransfer: false,
				fromWalletLength: 6,
				menu2: false,
			},
		}
	},

	computed: {
		formattedDate(){
			return this.transaction.dateTime ? moment(this.transaction.dateTime).format('DD-MM-YYYY') : '';
		},
	},

	watch: {
		transactionId: function(newVal){
			if(newVal == -1) {
				this.resetToDefault();
			} else {
				this.updateInfo();
			}
		},

		// show or hide to wallet on demand, depends on the selected transaction type
		'transaction.type': function(newVal){
			this.decoration.showTransfer = newVal == 2 ? true : false;
			this.decoration.fromWalletLength = newVal == 2 ? 6 : 12;
		},
	},

	created() {
		// get user categories
		if(this.categories.length == 0){
		customAxios
			.post('/api/category/')
			.then((response) => {
				this.categories = response.data.categories;
			});
		}
		// the user wallets
		if(this.wallets.length == 0){
			customAxios
				.post('/api/wallet/')
				.then((response) => {
					this.wallets = response.data.wallets;
				});
		}

		if(this.transactionId == -1) {
			this.resetToDefault();
		} else {
			this.updateInfo();
		}
	},

	methods: {
		resetToDefault() {
			this.transaction.id = -1;
			this.transaction.note = null;
			this.transaction.type = this.types[1];
			this.transaction.amount = 0;
			this.transaction.wallet = null;
			this.transaction.transferWallet = null;
			this.transaction.withFee = true;
			this.transaction.fee = 0;
			this.transaction.category = null;
			this.transaction.dateTime = null;
		},

		updateInfo(){
			let data = {
				id: this.transactionId,
			};

			customAxios
				.post('/api/transaction/detail', data)
				.then((response) => {
					this.transaction = response.data.transaction;
					this.transaction.withFee = response.data.transaction.fee != 0 ? true : false;
				})
				.catch((error) => {
					swal("Oops!", error.message, "error");
				});
		},

		saveTransaction(){
			let data = {
				transaction: this.transaction,
				isNew: this.transactionId == -1,
			};

			data.transaction.dateTime = this.formattedDate;

			customAxios
				.post('/api/transaction/save', data)
				.then((response) => {
					swal("Success!", response.data.message, "success");
				})
				.catch((error) => {
					swal("Oops!", error.data.message, "error");
				});
		}
	},
}
</script>
