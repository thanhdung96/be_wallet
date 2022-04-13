import axios from 'axios'
import VueAxios from 'vue-axios'

export const customAxios = axios.create({
	baseURL: process.env.VUE_APP_ROOT_API
});

// function triggered after response is received
customAxios.interceptors.response.use((response) => {
	return response;
}, async function (error) {
	const originalRequest = error.config;
	if (error.response.status === 401 && !originalRequest._retry) {
		originalRequest._retry = true;
		// request new token
		const response = await refreshAccessToken();
		// persist to local storage
		localStorage.setItem('user', JSON.stringify(response.data));

		// update access token to default request header
		let authToken = JSON.parse(localStorage.getItem('user'))['token'];
		customAxios.defaults.headers.common['Authorization'] = authToken;

		// update old request header
		originalRequest.headers['Authorization'] = authToken;
		// and resubmit the old request
		return customAxios(originalRequest);
	}

	return Promise.reject(error);
});

function refreshAccessToken(){
	let data = {
		refreshToken: JSON.parse(localStorage.getItem('user'))['refreshToken'],
		username: JSON.parse(localStorage.getItem('user'))['username']
	};

	return customAxios.post('/auth/refresh', data);
}

if (localStorage.getItem('user') && typeof localStorage.getItem('user') === 'string') {
	let authToken = JSON.parse(localStorage.getItem('user'))['token'];
	customAxios.defaults.headers.common['Authorization'] = authToken;
}
