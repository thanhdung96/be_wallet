<template>
	<v-container id="user-profile" fluid tag="section">
		<v-row justify="center">
			<v-col cols="12" md="8">
				<ProfileCard />
			</v-col>

			<v-col cols="12" md="4">
				<AccountSettingCard />
				<v-btn
					color="success"
					type="submit"
					class="mr-0"
					rounded
					@click="showDialog = true"
				>
					Change your password
				</v-btn>
			</v-col>
		</v-row>
		<ChangePasswordDialog
			v-model="showDialog"
		/>
	</v-container>
</template>

<script>
import ProfileCard from "@/views/dashboard/components/Profile/ProfileCard";
import AccountSettingCard from "@/views/dashboard/components/Profile/AccountSettingCard";
import ChangePasswordDialog from "@/views/dashboard/components/Profile/ChangePasswordDialog";

export default {
	name: "UserProfile",

	components: {
		ProfileCard,
		AccountSettingCard,
		ChangePasswordDialog
	},

	data() {
		return {
			// show dialog flag
			showDialog: false,
		}
	},

	methods: {
		btnChangePwdClicked() {
			this.showDialog = true;
		}
	},
};
</script>
