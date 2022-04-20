<template>
	<v-dialog v-model="show" max-width="500px">
		<v-card class="elevation-12">
			<v-toolbar dark :color="decoration.modalColor">
				<v-toolbar-title>
					{{ decoration.modalTitle }}
				</v-toolbar-title>
			</v-toolbar>
			<v-card-text>
				<UserWalletCard
					:wallet-id="walletId"
					@colorChangeEmit="onColorChange($event)"
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
				modalColor: '#4caf50',
			}
		}
	},

	beforeUpdate() {
		if(this.isUpdate == true){
			this.decoration.modalTitle = "Update wallet";
		} else {
			this.decoration.modalTitle = "New wallet";
		}
	},

	methods: {
		onColorChange(dataObject) {
			this.decoration.modalColor = dataObject;
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
