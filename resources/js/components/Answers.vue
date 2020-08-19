<template>
    <div v-if="count" class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ title }}</h2>
                    </div>
                    <hr>
                    <answer @deleted="remove( index )" v-for=" ( answer,index) in answers " :answer="answer"  :key="answer.id"></answer>
                    <div class="text-center mt-2" v-if="nextUrl">
                        <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load  {{remaining}} more answers</button>
                    </div>
                </div>
                </div>
            </div>
    </div>
</template>

<script>
     import Answer from "./Answer";
     import EventBus from "../event-bus";
     export default {
        name: "Answers",
        props: ['question'],
        data(){
            return{
                questionId : this.question.id,
                count :this.question.answers_count,
                answers : [],
                answersIds:[],
                nextUrl: null,
                remaining : 0,
            }
        } ,
        created() {
            this.fetch(`/questions/${this.questionId}/answers`);
            //When answer has created
            EventBus.$on('answer_created',answer => {
               this.answers.push(answer);
               this.answersIds.push(answer.id);
               this.count++;
               setTimeout( function(){

                    document.getElementById('answer'+answer.id).scrollIntoView();
                },500);
            })
        },
         methods:{
            fetch(endpoint){
                axios.get(endpoint)
                     .then(({data})=> {
                         // to avoid repeated answer
                         data.data.forEach(answer => {
                                   if( this.answersIds.indexOf(answer.id) === -1 ){
                                       this.answersIds.push(answer.id);
                                       this.answers.push(answer);
                                   }
                         });
                         //Or
                         // this.answers.push(...data.data);
                         this.remaining = this.count - data.to;
                         this.nextUrl = data.next_page_url;
                     })
            },
            remove(index){
                 this.answers.splice(index,1);
                 this.count --;
            }
        } ,
        computed:{
            title(){
                return this.count +" "+ ( this.count > 1 ?"Answers":"Answer");
            }
        },
         components:{Answer}
    }
</script>

<style scoped>

</style>
