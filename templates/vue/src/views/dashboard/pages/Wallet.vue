<template lang="html">
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
		<UserWalletDialog
			v-model="dialog.show"
			:is-update="dialog.isUpdate"
			:walletId="dialog.selectedWalletId"
		/>
	</v-card>
</template>

<script>
import { customAxios } from '@/axios'
import UserWalletDialog from '@/views/dashboard/components/Wallet/WalletDialog'
import WalletCard from '@/views/dashboard/components/Wallet/WalletCard'

export default {
	name: "UserWallet",

	components: {
		UserWalletDialog,
		WalletCard
	},

	data() {
		return {
			headers: [
				{ text: "Name", value: "name" },
				{ text: "Currency", value: "currency.currencyName" },
				{ text: "Amount", value: "amount" },
			],
			dialog: {
				show: false,
				isUpdate: false,
				selectedWalletId: null,
			},
			searchQuery: null,
			wallets: [],
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
			this.dialog.show = true;
			this.dialog.isUpdate = true;
			this.dialog.selectedWalletId = item.id;
		},

		newWallet() {
			this.dialog.show = true;
			this.dialog.isUpdate = false;
			this.dialog.selectedWalletId = -1;
		}
	}
}
</script>

<style lang="css" scoped>

</style>
