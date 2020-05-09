<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">LIPE To-do </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6"  v-if="!show">
                                  <li v-for="error in errors"  style="color:red">{{ error[0] }}</li>
                                <div class="form-group">
                                    <label>Task title</label>
                                    <input type="text" name="title" class="form-control" v-model="task.title">
                                </div>
                                <div class="form-group">
                                    <label>Task description</label>
                                    <textarea class="form-control" v-model="task.description"></textarea>
                                </div>
                                <div class="form-group">

                                    <button v-if="!editing" class="btn btn-primary" @click.prevent="addTask()">Add task</button>

                                <div v-else>
                                    <button  class="btn btn-primary" @click.prevent="updateTask(task.id)">Update task</button>

                                    <button class="btn btn-secondary" @click.prevent="clear()">
                                        Clear
                                    </button>
                                </div>


                                </div>
                            </div>
                        <div class="col-md-6" v-else>
                            <h4>{{ task.title }}</h4>
                            <p>created on {{ task.created_at }}</p>
                            <p>updated on {{ task.updated_at }}</p>
                            <hr>
                            <div>
                                <p>{{ task.description }}</p>
                            </div>
                            <button class="btn btn-secondary"  @click.prevent = "clear()">Back</button>
                        </div>

                        <div class="col-md-6">
                            <h4>Todolist</h4>
                            <div>
                                <ul class="list-group">
                                  <span class="list-group-item" v-for="task in tasks">
                                    {{task.title}}  
                                    <span class="float-right">
                                        <i class="fa fa-edit" @click.prevent="edit(task.id)"></i>
                                        <i class="fa fa-trash" @click.prevent="deleteTask(task.id)"></i>
                                        <i class="fa fa-check" @click.prevent="showTask(task.id)"></i>

                                    </span>
                                </span>
                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.fetch();
        },
        data(){
            return{
                task:{
                    title:"",
                    description:"",
                    id:""
                },
                errors:{},
                tasks:{},
                editing:false,
                show:false
            }
        },
        methods:{
            addTask:function(){
                var url = route("task.store");

               
                axios.post(url,this.task)
                    .then(info=>{
                       if (info.status == 200) {
                        this.tasks = info.data.tasks
                        this.tasks.title = "";
                        this.tasks.description = "";
                       
                       }
                    })
                    .catch(info=>{
                        console.log(info.response);

                        this.errors = info.response.data.errors;
                    })
            },

            fetch:function(){
                var url = route("task.index");
                axios.get(url)
                    .then(info=>{
                        if (info.status == 200) {
                            this.tasks = info.data.tasks;
                        }

                    })
                    .catch(info=>{
                        alert("could not load tasks");
                    })
            },

            deleteTask:function(id){

                var url = route("task.delete",{id:id});

                axios.delete(url)
                    .then(info=>{
                        console.log(info)
                       this.tasks = info.data.tasks;
                    })
                    .catch(info=>{
                        console.log(info.response);
                    })
            },
            edit:function(id){

                this.editing = true;

                var task = this.tasks.filter(value=>{
                    return value.id == id;
                }) 
                
                this.task.id = task[0].id;
                this.task.title = task[0].title;
                this.task.description = task[0].description;

                console.log(this.task);
            },
            updateTask:function(id){

                var url = route("task.update",{id:this.task.id});

                axios.patch(url,this.task)
                    .then(info=>{
                        console.log(info)
                        if (info.status == 200) {
                            this.tasks = info.data.tasks;
                            this.task = {};
                        }
                    })
                    .catch(info=>{
                        console.log(info)
                    })
            },
            clear:function(){
                this.editing = false

                this.show = false

                this.task = {};
            },
            showTask:function(task_id)
            {
                var task = this.tasks.filter(value=>{
                    return value.id == task_id;
                }) 
                
                this.task = task[0];

                this.show = true;
            },

        }
    }
</script>
