<template lang="html">
</template>

<script>
import { router } from '../../router'

export default {
	name: "UserLogout",

	mounted() {
		if(localStorage.getItem('user')){
			localStorage.removeItem('user');
			router.push({name: 'Login'});
		}
	}
}
</script>

<style lang="css" scoped>
</style>
