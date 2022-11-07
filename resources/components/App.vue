<template>
    <router-link to="/list">список задач</router-link> |
    <router-link to="/create">создать задачу</router-link> <br/>
    <hr><br/>
    <router-view></router-view>
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

</style>
