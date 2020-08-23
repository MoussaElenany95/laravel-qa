<template>
        <div>
            <question @deleted="remove(index)" v-for="(question,index) in questions " :question="question" :key="question.id"></question>
            <div v-if="!arrayLength" class="alert alert-warning">
                <strong>Sorry !</strong> , There are no questions available .
                <a href="/questions/create" class="btn btn-lg btn-outline-primary">Ask question</a>
            </div>
        </div>
</template>

<script>
    export default {
        name: "Questions",
        props:['questions'],
        data(){
            return {
                arrayLength: this.questions.length,
            }
        },
        methods:{
            remove(index){
                this.questions.splice(index,1);
                this.arrayLength = this.questions.length;
            }
        }
    }
</script>
