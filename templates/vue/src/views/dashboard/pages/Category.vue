<template lang="html">
	<v-card>
		<CategoryList
			@statusChangedEmit="statusChanged($event)"
		/>
		<CategoryDialog 
			v-model="showDialog"
			v-if="selectedCategoryId"
			:category-id="selectedCategoryId"
			:is-update="isUpdate"
		/>
	</v-card>
</template>

<script>
import CategoryDialog from '@/views/dashboard/components/Category/CategoryDialog'
import CategoryList from '@/views/dashboard/components/Category/CategoryList'

export default {
	name: "UserCategory",

	components: {
		CategoryDialog,
		CategoryList,
	},

	data() {
		return {
			// show dialog flag
			showDialog: false,
			//which category is selected to display in modal
			selectedCategoryId: null,
			isUpdate: true,
		}
	},

	methods: {
		statusChanged(dataObject) {
			this.showDialog = dataObject.showDialog;
			this.isUpdate = dataObject.isUpdate;
			this.selectedCategoryId = dataObject.selectedCategoryId;
		}
	}
}
</script>

<style lang="css" scoped>
</style>
