<template>
	<v-card>
		<v-container fluid>
			<v-card-title>
				<v-row no-gutter>
					<v-col md="10">
						<v-text-field
							v-model="searchQuery"
							append-icon="mdi-magnify"
							label="Search Wallet"
							single-line
							hide-details
						></v-text-field>
					</v-col>
					<v-col md="2">
						<v-btn
							color="accent"
							@click="newWallet"
						>
							<v-icon>
								mdi-plus
							</v-icon>
						</v-btn>
					</v-col>
				</v-row>
			</v-card-title>
			<v-row>
				<v-col>
					<v-data-table
						:headers="headers"
						:items="wallets"
						:search="searchQuery"
						@click:row="rowClicked"
					></v-data-table>
				</v-col>
			</v-row>
		</v-container>
	</v-card>
</template>

<script>
import { customAxios } from '@/axios';

export default {
	name: 'WalletList',

	props: {
		dialogShow: Boolean,
		dialogIsUpdate: Boolean,
		dialogSelectedWalletId: Number,
	},

	data() {
		return {
			searchQuery: null,
			wallets: [],
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Currency", value: "currency.currencyName" },
				{ text: "Amount", value: "amount" },
			],
		}
	},

	mounted() {
		let rootComponent = this;
		customAxios
			.post('/api/wallet/')
			.then((response) => {
				rootComponent.wallets = response.data.wallets;
			});
	},

	methods: {
		rowClicked(item, event) {
			let dataObject = {
				show: true,
				isUpdate: true,
				selectedWalletId: item.id,
			};
			
			this.emitStatusChangeEvent(dataObject);
		},

		newWallet() {
			let dataObject = {
				show: true,
				isUpdate: false,
				selectedWalletId: -1, 
			};

			this.emitStatusChangeEvent(dataObject);
		},

		// event emitted from list to parent (currently is wallet main screen)
		emitStatusChangeEvent(dataObject){
			this.$emit('statusChangedEmit', dataObject);
		}
	}
}
</script>
