<template>
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
			v-model="category.categoryType"
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
</template>

<script>
import { customAxios } from '@/axios'

export default {
	name: 'CategoryCard',

	props: {
		categoryId: Number,
		isUpdate: Boolean,
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
				showSwatches: false,
			}
		}
	},

	watch: {
		categoryId: function(newVal){
			if(newVal == -1){
				this.category.id = -1;
				this.category.name = null;
				this.category.type = null;
				this.category.colour = '#4caf50';
			} else {
				this.updateInfo();
			}
		},

		'category.colour': function(newVal){
			this.$emit('colorChangeEmit', newVal);
		}
	},

	created() {
		this.updateInfo();
	},

	methods: {
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
						rootComponent.category.colour = returnedData.color;
					});
			}
		},

		saveCategory(){
			let data = {
				id: this.category.id,
				name: this.category.name,
				colour: this.category.colour
			};
			console.log(data);

			customAxios
				.post('api/category/save', data)
				.then(response => {
					swal("Success", 'Category saved', 'success');
				})
				.catch(error => {
					swal("Oops", error.data, 'error');
				});
		}
	},
}
</script>
