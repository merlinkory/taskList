<template>
    <div class="form_wrapper">
        <form @submit.prevent="createTask">
            <textarea v-model="taskTitle" placeholder="task title" type="text" id="title" class="task_title"></textarea><br/>
            <select class="staff_list" id="staff">
                <option v-for="_staff in staff" v-bind:value="_staff.id">{{ _staff.name}}</option>
            </select><br/>
            <input v-model="taskDate" type="date" class="input_date"><br/>
            <button class="create_task_btn">Создать задачу</button>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "TaskForm.vue",
    data(){
        return{
            taskTitle: '',
            staff:[],
            taskDate : new Date().toISOString().substr(0, 10),
        }
    },
    methods : {
        async createTask(){
            if(this.taskTitle == ''){
                alert('Введите задачу');
            }
            let payload = {
                'staff_id' : document.getElementById('staff').value,
                'title' : this.taskTitle,
                'date' : this.taskDate
            };

            let response = await axios.post('/tasks',JSON.stringify(payload),{
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            if(response.status == 200){
                alert("Задача успешно добавлена");
                this.taskTitle = '';
            }
            console.log(response.data);
        },
        async getStaffList() {
            let response = await axios.get('/staff');
            this.staff =  response.data;
        }
    },
    mounted() {
        this.getStaffList();
    }

}
</script>

<style scoped>
.form_wrapper{
    text-align: left;
}
.task_title{
    font-size: 18px;
    padding: 10px 10px 10px 10px;
    border-radius: 5px;
    border: 1px solid #000;
    width: 90%;
    height: 100px;
}
.staff_list{
    font-size: 26px;
    padding: 10px 10px 10px 10px;
}
.input_date{
    font-size: 26px;
    padding: 10px 10px 10px 10px;
}
.create_task_btn{
    font-size: 26px;
    padding: 10px 10px 10px 10px;
}
</style>
