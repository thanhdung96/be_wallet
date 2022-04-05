<template>
	<v-dialog v-model="show" max-width="500px">
		<v-card class="elevation-12">
			<v-toolbar dark :color="category.colour">
				<v-toolbar-title>
					{{ decoration.modalTite }}
				</v-toolbar-title>
			</v-toolbar>
			<v-card-text>
			<form ref="form" @submit.prevent="saveCategory">
				<v-text-field
					v-model="category.id"
					name="id"
					v-if="false"
					required
				></v-text-field>

				<v-text-field
					v-model="category.name"
					name="categoryname"
					label="Category Name"
					type="text"
					placeholder="Category Name"
					required
				></v-text-field>

				<v-select
					v-model="decoration.type"
					:items="type"
					item-text="name"
					item-value="id"
					label="Category Type"
					v-if="!isUpdate"
				></v-select>

				<v-row>
					<v-col>
						<v-color-picker
							v-model="category.colour"
							dot-size="7"
							hide-mode-switch
							mode="hexa"
							:show-swatches="decoration.showSwatches"
							swatches-max-height="70"
						></v-color-picker>
					</v-col>
					<v-col>
						<v-checkbox
							v-model="decoration.showSwatches"
							label="Show Presets"
						>
						</v-checkbox>
					</v-col>
				</v-row>

				<v-col class="text-right">
					 <v-btn type="submit" class="mt-4" color="primary" value="log in">
						 Save
					 </v-btn>
				 </v-col>
			</form>
		   </v-card-text>
	   </v-card>
	</v-dialog>
</template>

<script>
import { customAxios } from '@/axios'

export default {
	name: 'CategoryDialog',

	props: {
		value: Boolean,
		isUpdate: Boolean,
		categoryId: Number
	},

	data() {
		return {
			category: {
				id: -1,
				name: null,
				type: null,
				colour: '#4caf50'
			},
			type: [
				{
					id: '0',
					name: 'Revenue',
				},
				{
					id: '1',
					name: 'Expense',
				},
			],

			decoration: {
				needsUpdate: true,
				showSwatches: false,
				categoryType: null,
				modalTite: null,
			}
		}
	},

	created() {
		this.updateInfo();
		this.updateModal();
	},

	beforeUpdate() {
		// updated hook catches twice, when the dialog is hidden and shown,
		// only update when the modal is shown
		if(this.show == true && this.decoration.needsUpdate == true){
			this.updateInfo();
			this.decoration.needsUpdate = false;
			this.updateModal();
		} else if(this.show == false){
			this.decoration.needsUpdate = true;

			// reset value to default
			this.category.id = -1;
			this.category.name = null;
			this.category.type = null;
			this.category.colour = '#4caf50';
		}
	},

	methods: {
		updateModal(){
			if(this.isUpdate){
				this.decoration.modalTite = "Update Category";
			} else {
				this.decoration.modalTite = "New Category";
			}
		},

		updateInfo(){
			if(this.categoryId != -1){
				let rootComponent = this;
				let data = {
					id: this.categoryId,
				};

				customAxios
					.post('api/category/detail', data)
					.then(response => {
						let returnedData = response.data.category;
						rootComponent.category.id = returnedData.id;
						rootComponent.category.name = returnedData.name;
						rootComponent.category.type = returnedData.type;
						rootComponent.decoration.type = rootComponent.type[returnedData.type];
						rootComponent.category.colour = returnedData.color;
					});
			}
		},

		saveCategory(){
			let rootComponent = this;

			let data = {
				id: rootComponent.category.id,
				name: rootComponent.category.name,
				type: rootComponent.category.type,
				colour: rootComponent.category.colour
			};

			customAxios
				.post('api/category/save', data)
				.then(response => {
					swal("Success", 'Category saved', 'success');
					if(isUpdate){

					} else {

					}
				})
				.catch(error => {
					console.log('Something went wrong', error.data, 'error');
				});
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
