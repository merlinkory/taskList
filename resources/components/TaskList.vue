<template>
    <div class="nav">
        <button @click="getTaskList(7)">минус 7 дней</button> |
        <button @click="getTaskList(10)">минус 10 дней</button> |
        <button @click="getTaskList(30)">минус 30 дней</button>
    </div>
    <div class="wrapper">
        <div class="task_wrapper" v-for="(taskBystaff, date) in taskList">
            <div v-bind:class="date.split(':')[0] >= new Date().toISOString().substr(0, 10) ? 'task_future' : 'task_old'">
                <h3>{{date}}</h3>
                <div v-for="(tasks, staff) in taskBystaff">
                    <h4>{{staff}}</h4>
                    <ul>
                        <li class="li_task" v-for="task in tasks">{{task}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TaskList",
    data(){
        return{
            taskList:[],
        }
    },
    methods:{
        async getTaskList(subDays = 7){

            let response = await axios.get('/tasks/' + subDays );
            this.taskList = response.data;
        }
    },
    mounted() {
        this.getTaskList();
    }
}
</script>

<style scoped>
.task_old{
    background-color: #cccccc;
    border: 1px solid;
    margin-top: 5px;
    padding-left: 10px;
}

.task_future{
    background-color: #c3e3b5;
    border: 1px solid;
    margin-top: 5px;
    padding-left: 10px;
}
.li_task{
    padding-bottom: 10px;
}
</style>
