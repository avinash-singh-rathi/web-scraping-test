import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        name: 'home',
        component: require('../pages/Dashboard/home.vue').default
    },
    {
        path: '/websites',
        //name: 'pages',
        component: { render: h => h('router-view') },
        //component: require('../pages/Pages/pages.vue').default,
        children:[
          {
            path: '',
            name: 'websites',
            component: require('../pages/Websites/Index.vue').default,
          },
          {
              path: 'add',
              name: 'AddWebsite',
              component: require('../pages/Websites/Add.vue').default
          },
        ]
    },
    {
        path: '/categories',
        component: { render: h => h('router-view') },
        children:[
          {
            path: '',
            name: 'categories',
            component: require('../pages/Categories/Index.vue').default,
          },
          {
              path: 'add',
              name: 'AddCategory',
              component: require('../pages/Categories/Add.vue').default
          },
        ]
    },
    {
        path: '/brands',
        component: { render: h => h('router-view') },
        children:[
          {
            path: '',
            name: 'brands',
            component: require('../pages/Brands/Index.vue').default,
          },
          {
              path: 'add',
              name: 'AddBrand',
              component: require('../pages/Brands/Add.vue').default
          },
        ]
    },
    {
        path: '/process',
        component: { render: h => h('router-view') },
        children:[
          {
            path: '',
            name: 'process',
            component: require('../pages/Process/Index.vue').default,
          },
          {
              path: 'add',
              name: 'AddProcess',
              component: require('../pages/Process/Add.vue').default
          },
        ]
    },


];

export const router = new VueRouter({
    //mode: 'history',
    linkExactActiveClass: 'active',
    routes
});
