<template>
	<v-dialog v-model="show" max-width="60%">
		<v-card class="elevation-12">
			<v-toolbar dark :color="decoration.modalColor">
				<v-toolbar-title>
					{{ decoration.modalTitle }}
				</v-toolbar-title>
			</v-toolbar>
			<v-card-text>
				<TransactionCard
					:transaction-id="transactionId"
					:is-update="isUpdate"
				/>
			</v-card-text>
		</v-card>
	</v-dialog>
</template>

<script>
import TransactionCard from '@/views/dashboard/components/Transaction/TransactionCard'

export default {
	name: 'TransactionDialog',

	components: {
		TransactionCard,
	},

	props: {
		value: Boolean,
		isUpdate: Boolean,
		transactionId: Number
	},

	watch: {
		transactionId: function(newVal){
			if(newVal == -1) {
				this.decoration.modalTitle = "New Transaction";
			} else {
				this.decoration.modalTitle = "Update Transaction";
			}
		}
	},

	data() {
		return {
			decoration: {
				modalTitle: 'New Transaction',
				modalColor: '#4caf50'
			},
		}
	},

	methods: {

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
