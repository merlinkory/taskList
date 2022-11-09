<template>
    <b-nav tabs>
        <b-nav-item><router-link to="/list">список задач</router-link></b-nav-item>
        <b-nav-item><router-link to="/create">создать задачу</router-link></b-nav-item>
        <b-nav-item><a href="/logout">Выйти</a></b-nav-item>
    </b-nav>
    <div class="wrapper">
    <router-view></router-view>
    </div>
</template>

<script>
import TaskForm from './TaskForm.vue';
export default {
    name: "App.vue",
    components: {
        TaskForm,
    }
}
</script>

<style scoped>
.wrapper{
    padding: 5px;
}
</style>
