import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', redirect: '/index' },
    {
      path: '/',
      component: () => import('../layouts/default.vue'),
      children: [     
        {
          path: 'index',
          component: () => import('../pages/index.vue'),
          meta: { requiresAuth: true }
        },
      ],
    },
    {
      path: '/',
      component: () => import('../layouts/blank.vue'),
      children: [
        {
          path: 'login',
          component: () => import('../pages/login.vue'),
        },
        {
          path: 'logout',
          component: () => import('../pages/logout.vue'),
        },      

      ],
    },
    { path: '/register', component: () => import('../pages/register.vue') },
    { path: '/logout', component: () => import('../pages/logout.vue') }, 
    { path: '/:pathMatch(.*)*', component: () => import('../pages/[...all].vue') }, 
  ],
});

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('login_token');
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!token) {
      next('/login');
    } else {
      next();
    }
  } else {
    next();
  }
});

export default router;
function loadCSS(files) {
  files.forEach(file => {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = file;
    document.head.appendChild(link);
  });
}

function loadJS(files) {
  files.forEach(file => {
    const script = document.createElement('script');
    script.src = file;
    document.body.appendChild(script);
  });
}
