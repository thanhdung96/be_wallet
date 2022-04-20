<template>
	<v-dialog v-model="show" max-width="500px">
		<v-card class="elevation-12">
			<v-toolbar dark :color="decoration.modalColor">
				<v-toolbar-title>
					{{ decoration.modalTitle }}
				</v-toolbar-title>
			</v-toolbar>
			<v-card-text>
				<CategoryCard
					:category-id="categoryId"
					:is-update="isUpdate"
					@colorChangeEmit="onColorChange($event)"
				/>
			</v-card-text>
		</v-card>
	</v-dialog>
</template>

<script>
import CategoryCard from '@/views/dashboard/components/Category/CategoryCard'

export default {
	name: 'CategoryDialog',

	components: {
		CategoryCard,
	},

	props: {
		value: Boolean,
		isUpdate: Boolean,
		categoryId: Number
	},

	watch: {
		categoryId: function(newVal){
			if(newVal == -1) {
				this.decoration.modalTitle = "New Category";
			} else {
				this.decoration.modalTitle = "Update Category";
			}
		}
	},

	data() {
		return {
			decoration: {
				modalTitle: 'New Category',
				modalColor: '#4caf50'
			},
		}
	},

	methods: {
		onColorChange(dataObject){
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
