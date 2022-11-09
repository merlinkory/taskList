<template>
    <div class="nav">
        <button @click="getTaskList(7)">7 дней</button> |
        <button @click="getTaskList(10)">10 дней</button> |
        <button @click="getTaskList(30)">30 дней</button>
    </div>
    <div class="wrapper">
        <div class="task_wrapper" v-for="(data, date) in taskList">
            <div v-bind:class="date >= new Date().toISOString().substr(0, 10) ? 'task_future' : 'task_old'">
                <h3>{{data.dateUserFriendly}} - ({{data.dayOfWeek}})</h3>
                <div v-for="(tasks, staff_id) in data.tasks">
                    <h4>{{this.staff[staff_id]}}</h4>
                    <ul>
                        <li v-bind:class="task.status" v-for="task in tasks" @dblclick="showTask(task,staff_id)">{{task.title}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Модальное окно для редактирвоание задачи -->
    <b-modal scrollable size="lg" v-model="taskDetailShow" hide-footer id="task_info" title="задача">
        <div class="my-4">
            <b-form-textarea
                id="textarea"
                v-model="taskTitle"
                placeholder="Введите задачу"
                rows="3"
                max-rows="6"
            ></b-form-textarea><br/>
            <input type="date" v-model="taskDate" />
            <b-form-select v-model="taskStaffId" :options="staff"></b-form-select><br/>
            <b-form-select v-model="taskStatus" :options="taskStatuses"></b-form-select><br/>
        </div>
        <b-button id="saveTaskBtn" class="mt-3" block @click="changeTask()">Сохранить изменения</b-button>
    </b-modal>
</template>

<script>
import axios from "axios";

export default {
    name: "TaskList",
    data(){
        return{
            taskList:[],
            staff: [],

            //data for one task
            taskDetailShow: false,
            taskStatuses:[
                {value: 'new', text:'новый'},
                {value: 'pending', text:'в процессе'},
                {value: 'canceled', text:'отменен'},
                {value: 'completed', text:'выполнен'},
            ],

            taskTitle: '',
            taskId:0,
            taskStatus: '',
            taskStaffId: 0,
            taskDate: ''
        }
    },
    methods:{
        showTask(task, staff_id){
            this.taskDetailShow = !this.taskDetailShow;
            console.log(task, staff_id);
            this.taskTitle = task.title;
            this.taskId = task.id;
            this.taskStatus = task.status;
            this.taskDate = task.date;
            this.taskStaffId = staff_id;
        },
        async changeTask(){
            console.log(this.taskTitle,this.taskId,this.taskStatus, this.taskStaffId);
            let payload = {
                'title': this.taskTitle,
                'status': this.taskStatus,
                'staff_id': this.taskStaffId,
                'date': this.taskDate,
            }
            let response =  await axios.post('/tasks/' + this.taskId, JSON.stringify(payload),{
                headers: {
                'Content-Type': 'application/json'
            }
        });
            if(response.status == 200) {
                this.taskTitle = this.taskStatus = this.taskStaffId = this.taskDate = 0;
                alert('Задача успешно изменена');
                await this.getTaskList();
                this.taskDetailShow = !this.taskDetailShow;
            }

        },
        async getTaskList(subDays = 7){

            let response = await axios.get('/tasks/' + subDays );
            this.taskList = response.data;
        },
        async getStaffList() {
            let response = await axios.get('/staff');
            this.staff =  response.data;
        }
    },
    async mounted() {
        await this.getStaffList();
        await this.getTaskList();
        console.log(this.staff);
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
.new{
    padding-bottom: 10px;
    padding-right:10px;
}
.pending{
    padding-bottom: 10px;
    padding-right:10px;
    font-style: italic;
}
.completed{
    background-color: #72fa24;
}
</style>
