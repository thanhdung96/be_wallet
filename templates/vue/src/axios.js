import axios from 'axios'
import VueAxios from 'vue-axios'

export const customAxios = axios.create({
 	baseURL: process.env.VUE_APP_ROOT_API
});

if(localStorage.getItem('user')){
	let authToken = JSON.parse(localStorage.getItem('user'))['token'];
	customAxios.defaults.headers.common['Authorization'] = authToken;
}
