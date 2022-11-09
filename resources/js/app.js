import './bootstrap';
import {createApp} from 'vue'
import *  as VueRouter from 'vue-router'
import BootstrapVue3 from 'bootstrap-vue-3'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'

import TaskForm from './components/TaskForm.vue';
import TaskList from './components/TaskList.vue';

const routes = [
    {path: '/create', component: TaskForm},
    {path: '/list', component: TaskList},
]

const router = VueRouter.createRouter({
    history: VueRouter.createWebHistory('/taskmanager'),
    routes
})

import App from './components/App.vue'

createApp(App).use(BootstrapVue3).use(router).mount("#app")
