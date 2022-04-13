<template>
	<v-dialog v-model="show" max-width="500px">
		<v-card class="elevation-12">
			<v-toolbar dark>
				<v-toolbar-title>
					{{ decoration.modalTitle }}
				</v-toolbar-title>
			</v-toolbar>
			<v-card-text>
				<UserWalletCard
					:wallet-id="walletId"
					:is-shown="show"
				/>
			</v-card-text>
		</v-card>
	</v-dialog>
</template>

<script>
import UserWalletCard from '@/views/dashboard/components/Wallet/WalletCard'

export default {
	name: "UserWalletDialog",

	components: {
		UserWalletCard,
	},

	props: {
		value: Boolean,
		isUpdate: Boolean,
		walletId: Number,
	},

	data() {
		return {
			decoration: {
				modalTitle: null,
			}
		}
	},

	created() {

	},

	beforeUpdate() {
		if(this.isUpdate == true){
			this.decoration.modalTitle = "Update wallet";
		} else {
			this.decoration.modalTitle = "New wallet";
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
