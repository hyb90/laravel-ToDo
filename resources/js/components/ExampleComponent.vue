import axios, { Button } from '../../../public/js/app';
<template>
    <div class="container">
                <div  class="card">
                    <div v-show="!edit" class="card-header"><span v-show="add">Add Todo</span><button v-show="!add" class="btn btn-success" @click="showAdd">Add Todo</button><button v-show="add" class="btn btn-primary float-right" @click="cancelEdit()">Cancel</button></div>
                    <div v-show="edit" class="card-header">Edit Todo<button v-show="edit" class="btn btn-primary float-right" @click="cancelEdit()">Cancel</button></div>
                    <div v-show="add" class="card-body">
                        <form action="#" @submit.prevent="edit ? updateTodo(todo.id) : createTodo()">
                            <div class="form-group">
                            <lable for="title">Name</lable>
                            <input v-model="todo.name" type="text" name="name" class="form-control" required>

                            </div>
                        
                            <div class="form-group">
                            <div class="text-center">
                            <button v-show="!edit" class="btn btn-success" type="submit">Add Todo</button>
                            <button v-show="edit" class="btn btn-success" type="submit">Update Todo</button>
                            </div>

                            </div>

                        </form>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header">Todos List<span v-show="list.length!=0" class="float-right">You have {{ list.length }} Todos</span><span v-show="list.length==0" class="float-right">You don't have any Todo yet</span></div>

                    <div class="card-body">
                        <table class='table table-striped'>
                            <tbody>
                                <tr v-for="todo in list" v-bind:key="todo.id">
                                    <td>
                                        <h3>{{todo.name}}</h3>
                                    </td>
                                    <td>
                                        <button @click="showTodo(todo.id)" class="btn btn-primary btn-xs float-right">Edit</button>
                                        <button @click="deleteTodo(todo.id)" class="btn btn-danger btn-xs float-right">delete</button>
                                        <button v-show="todo.done==0"  @click="markAsDone(todo.id)" class="btn btn-success btn-xs float-right">Mark As Completed</button>
                                        <h2 v-show="todo.done==1"  class="float-right">Completed</h2>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                edit:false,
                add:false,
                list:[],
                todo:{
                    id:'',
                    name:'',
                    user_id:'',
                    done:''
                }
            }
        },
        mounted() {
            console.log('mounted');
            this.fetchTodos();
        },
        methods:{
            showAdd(){
                this.add=true
            },
            markAsDone(id){
                axios.post('todo/done/'+id, this.todo).then((r)=>{
                this.fetchTodos();
            }).catch((e)=>console.log(e.response));
            },
            fetchTodos(){
                axios.get('todos').then((r)=>{
                this.list=r.data;
            }).catch((e)=>console.log(e.response));
            },
            createTodo(){
                
                axios.post('todo/store', this.todo).then((r)=>{
                this.todo.name='';
                this.edit=false;
                this.add=false;
                this.fetchTodos();
            }).catch((e)=>console.log(e.response));
            },
            showTodo(id){
                axios.get('todo/'+id).then((r)=>{
                this.todo.id=r.data.id;
                this.todo.name=r.data.name;
                this.edit=true;
                this.add=true;
            }).catch((e)=>console.log(e.response));
            },
            updateTodo(id){
                axios.patch('todo/update/'+id, this.todo).then((r)=>{
                this.todo.name='';
                this.edit=false;
                this.add=false;
                this.fetchTodos();
            }).catch((e)=>console.log(e.response));
            },
            deleteTodo(id){
                axios.delete('todo/delete/'+id).then((r)=>{
                this.fetchTodos();
            }).catch((e)=>console.log(e.response));
            },
            cancelEdit(){
                this.todo.name='';
                this.edit=false;
                this.add=false;

            },

        }
    }
</script>
