<template lang="html">
    <p>{{ lstCategories }}</p>
</template>

<script>
import axios from 'axios';

export default {
    name: 'DashboardCategory',

    data() {
        return {
            searchQuery: '',
            lstCategories: null,
        }
    },

    methods: {

    },

    mounted() {
        axios
            .get('http://localhost/api/category')
            .then(response => (this.lstCategories = response));
    },
}
</script>

<style lang="css" scoped>
</style>
