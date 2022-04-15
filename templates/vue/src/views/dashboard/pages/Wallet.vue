<template lang="html">
	<div>
		<WalletList
			@statusChangedEmit="statusChanged($event)"
		/>
		<UserWalletDialog
			v-model="dialog.show"
			:is-update="dialog.isUpdate"
			:walletId="dialog.selectedWalletId"
		/>
	</div>
</template>

<script>
import UserWalletDialog from '@/views/dashboard/components/Wallet/WalletDialog'
import WalletList from '@/views/dashboard/components/Wallet/WalletList'

export default {
	name: "UserWallet",

	components: {
		UserWalletDialog,
		WalletList
	},

	data() {
		return {
			dialog: {
				show: false,
				isUpdate: false,
				selectedWalletId: null,
			},
		}
	},

	methods: {
		statusChanged(dataObject) {
			this.dialog.show = dataObject.show;
			this.dialog.isUpdate = dataObject.isUpdate;
			this.dialog.selectedWalletId = dataObject.selectedWalletId;
		},
	},
}
</script>

<style lang="css" scoped>

</style>
