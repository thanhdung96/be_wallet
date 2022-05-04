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
          path: 'home',
          component: () => import('@/views/dashboard/Dashboard'),
        },
        // Pages
        {
          name: 'Profile',
          path: 'profile',
          component: () => import('@/views/dashboard/pages/UserProfile'),
        },
		// Category
        {
          name: 'Transaction',
          path: 'transaction',
          component: () => import('@/views/dashboard/pages/Transaction'),
        },
		// Category
        {
          name: 'Category',
          path: 'category',
          component: () => import('@/views/dashboard/pages/Category'),
        },
		// Wallet
        {
			name: 'Wallet',
			path: 'wallet',
			component: () => import('@/views/dashboard/pages/Wallet'),
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
				props: true,
			},
			// Logout
			{
				name: 'Logout',
				path: 'logout',
				component: () => import('@/views/Security/Logout'),
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
		redirect: '/user/home'
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
