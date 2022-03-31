import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/user',
      component: () => import('@/views/dashboard/Index'),
      children: [
        // Dashboard
        {
          name: 'Dashboard',
          path: '',
          component: () => import('@/views/dashboard/Dashboard'),
        },
        // Pages
        {
          name: 'User Profile',
          path: 'profile',
          component: () => import('@/views/dashboard/pages/UserProfile'),
        },
      ],
    },
	// authentication route
	{
		path: '/auth',
		component: () => import('@/views/Security/Base'),
		children: [
			// Login
			{
				name: 'Login',
				path: 'login',
				component: () => import('@/views/Security/Login'),
			},
			// Register
			{
				name: 'Register',
				path: 'register',
				component: () => import('@/views/Security/Register'),
			},
		]
	},
	// default route
	{
		path: '*',
		redirect: '/user'
	}
  ],
});

router.beforeEach((to, from, next) => {
	const publicPages = ['/auth/login', '/auth/register', '/'];
	const authRequired = !publicPages.includes(to.path);
	const loggedIn = localStorage.getItem('user');

	// trying to access a restricted page + not logged in
	// redirect to login page
	if (authRequired && !loggedIn) {
		next('/auth/login');
	} else {
		next();
	}
});
