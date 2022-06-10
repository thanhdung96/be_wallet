<template lang="html">
	<v-container fluid>
		<v-card-title>
			<v-row no-gutter>
				<v-col md="11">
					<v-text-field
						v-model="searchQuery"
						append-icon="mdi-magnify"
						label="Search Category"
						single-line
						hide-details
					></v-text-field>
				</v-col>
				<v-col md="1">
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
				<MaterialCard
					icon='mdi-label-multiple'
					title='Categories'
				>
					<v-data-table
						:headers="headers"
						:items="categories"
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
import CategoryDialog from '@/views/dashboard/components/Category/CategoryDialog'
import MaterialCard from '@/components/base/MaterialCard'

export default {
	name: "UserCategory",

	components: {
		CategoryDialog,
		MaterialCard
	},

	data() {
		return {
			headers: [
				{ text: "Name", value: "name", groupable: false },
				{ text: "Type", value: "type" }
			],
			searchQuery: null,
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
			let data = {
				selectedCategoryId: item.id,
				showDialog: true,
				isUpdate: true,
			};

			this.emitStatusChangedEvent(data);
		},

		newCategory(event){
			let data = {
				selectedCategoryId: -1,
				showDialog: true,
				isUpdate: false,
			};

			this.emitStatusChangedEvent(data);
		},

		emitStatusChangedEvent(dataObject) {
			this.$emit('statusChangedEmit', dataObject);
		}
	}
}
</script>

<style lang="css" scoped>
</style>
