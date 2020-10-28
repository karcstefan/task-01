require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import RotationIndex from './components/rotations/index.vue';

const routes = [
    {
        path: '/',
        components: {
            rotationIndex: RotationIndex
        }
    },
]

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')
