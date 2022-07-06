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
					<v-tabs
						v-model="tab"
						background-color="transparent"
						grow
					>
						<v-tab
							v-for="tabHandle in tabs"
						>
							<v-icon>{{ tabHandle.icon }} </v-icon>
							{{ tabHandle.name }}
						</v-tab>
					</v-tabs>

					<v-tabs-items
						v-model="tab"
					>
						<v-tab-item>
							<v-data-table
								:headers="headers"
								:items="revenueCategories"
								:search="searchQuery"
								@click:row="rowClicked"
							></v-data-table>
						</v-tab-item>
						<v-tab-item>
							<v-data-table
								:headers="headers"
								:items="expenseCategories"
								:search="searchQuery"
								@click:row="rowClicked"
							></v-data-table>
						</v-tab-item>
					</v-tabs-items>
				</MaterialCard>
			</v-col>
		</v-row>
	</v-container>
</template>

<script>
import { customAxios } from '@/axios'
import CategoryDialog from '@/views/dashboard/components/Category/CategoryDialog'
import MaterialCard from '@/components/base/MaterialCard'
import TransferTypes from '@/enums/TransferTypes'
import moment from 'moment'

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
			// tabbing decoration
			tab: null,
			tabs: [
				{
					name: 'Revenue',
					icon: 'mdi-tray-arrow-down'
				},
				{
					name: 'Expense',
					icon: 'mdi-tray-arrow-up'
				},
			],
		}
	},

	mounted() {
		let rootComponent = this;
		customAxios
			.post('/api/category/')
			.then((response) => {
				response.data.categories.map(function (value, key){
					if(value.type == TransferTypes.EXPENSE){
						value.type = 'Expense';
					} else if(value.type == TransferTypes.REVENUE){
						value.type = 'Revenue';
					}
					rootComponent.categories.push(value);
				})
			});
	},

	computed: {
		revenueCategories() {
			let categories = [];

			this.categories.forEach(category => {
				if(category.type === 'Revenue'){
					categories.push(category);
				}
			});
			return categories;
		},

		expenseCategories() {
			let categories = [];

			this.categories.forEach(category => {
				if(category.type === 'Expense'){
					categories.push(category);
				}
			});

			return categories;
		}
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
