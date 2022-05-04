<template lang="html">
	<v-card>
		<TransactionList 
			@statusChangedEmit="statusChanged($event)"
		/>
		<TransactionDialog 
			v-model="showDialog"
			v-if="selectedTransactionId"
			:transaction-id="selectedTransactionId"
			:is-update="isUpdate"
		/>
	</v-card>
</template>

<script>
import TransactionList from '@/views/dashboard/components/Transaction/TransactionList'
import TransactionDialog from '@/views/dashboard/components/Transaction/TransactionDialog'

export default {
	name: "UserTransaction",

	components: {
		TransactionList,
		TransactionDialog,
	},

	data() {
		return {
			// show dialog flag
			showDialog: false,
			//which transaction is selected to display in modal
			selectedTransactionId: null,
			isUpdate: true,
		}
	},

	methods: {
		statusChanged(dataObject) {
			this.showDialog = dataObject.showDialog;
			this.isUpdate = dataObject.isUpdate;
			this.selectedTransactionId = dataObject.selectedTransactionId;
		}
	}
}
</script>

<style lang="css" scoped> 
</style>
