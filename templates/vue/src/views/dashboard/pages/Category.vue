<template lang="html">
	<v-card>
		<v-container fluid>
			<v-card-title>
				<v-row no-gutter>
					<v-col md="10">
						<v-text-field
							v-model="searchQuery"
							append-icon="mdi-magnify"
							label="Search Category"
							single-line
							hide-details
						></v-text-field>
					</v-col>
					<v-col md="2">
						<v-btn
							color="accent"
							@click="newCategory"
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
						:items="categories"
						:search="searchQuery"
						:group-by="groupBy"
						:show-group-by="showGroupBy"
						@click:row="rowClicked"
					></v-data-table>
				</v-col>
			</v-row>
		</v-container>
		<CategoryDialog 
			v-model="showDialog"
			v-if="selectedCategoryId"
			:category-id="selectedCategoryId"
			:is-update="isUpdate"
		/>
	</v-card>

</template>

<script>
import { customAxios } from '@/axios'
import CategoryDialog from '@/views/dashboard/components/Category/CategoryDialog'

export default {
	name: "UserCategory",

	components: {
		CategoryDialog,
	},

	data() {
		return {
			headers: [
				{ text: "Name", value: "name", groupable: false },
				{ text: "Type", value: "type" }
			],
			searchQuery: null,
			groupBy: 'type',
			showGroupBy: true,
			categories: [],
			// show dialog flag
			showDialog: false,
			//which category is selected to display in modal
			selectedCategoryId: null,
			isUpdate: true,
		}
	},

	mounted() {
		let rootComponent = this;
		customAxios
			.post('/api/category/')
			.then((response) => {
				response.data.categories.map(function (value, key){
					if(value.type == 1){
						value.type = 'Expense';
					} else if(value.type == 0){
						value.type = 'Revenue';
					}
					rootComponent.categories.push(value);
				})
			});
	},

	methods: {
		rowClicked(item, event){
			this.selectedCategoryId = item.id;
			this.showDialog = true;
			this.isUpdate = true;
		},

		newCategory(event){
			this.selectedCategoryId = -1;
			this.showDialog = true;
			this.isUpdate = false;
		}
	}
}
</script>

<style lang="css" scoped>
</style>
