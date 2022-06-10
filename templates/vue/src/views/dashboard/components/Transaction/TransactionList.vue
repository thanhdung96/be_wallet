<template lang="html">
	<v-container fluid>
		<v-card-title>
			<v-row no-gutter>
				<v-col md="11">
					<v-text-field
						v-model="searchQuery"
						append-icon="mdi-magnify"
						label="Search Transaction"
						single-line
						hide-details
					></v-text-field>
				</v-col>
				<v-col md="1">
					<v-btn
						color="accent"
						@click="newTransaction"
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
				<MaterialCard
					icon='mdi-arrow-collapse-vertical'
					title='Transactions'
				>
					<v-data-table
						:headers="headers"
						:items="transactions"
						:search="searchQuery"
						@click:row="rowClicked"
					></v-data-table>
				</MaterialCard>
			</v-col>
		</v-row>
	</v-container>
</template>

<script>
import { customAxios } from '@/axios'
import MaterialCard from '@/components/base/MaterialCard'

export default {
	name: "TransactionList",

	components: {
		MaterialCard
	},

	data() {
		return {
			headers: [
				{ text: "From", value: "wallet.name" },
				{ text: "To", value: "transferWallet.name" },
				{ text: "Note", value: "note"},
				{ text: "Type", value: "type" },
				{ text: "Amount", value: "amount" },
				{ text: "Fee", value: "fee" },
			],
			transactions: [],
			searchQuery: '',
		}
	},

	mounted() {
		customAxios
			.post('api/transaction/')
			.then(response => {
				this.transactions = response.data.transactions;
			});
	},

	methods: {
		rowClicked(item, event) {
			let data = {
				selectedTransactionId: item.id,
				showDialog: true,
				isUpdate: true,
			};

			this.emitStatusChangedEvent(data);
		},

		newTransaction() {
			let data = {
				selectedTransactionId: -1,
				showDialog: true,
				isUpdate: false,
			};

			this.emitStatusChangedEvent(data);
		},

		emitStatusChangedEvent(dataObject) {
			this.$emit('statusChangedEmit', dataObject);
		},
	}
}
</script>

<style lang="css" scoped>
</style>
