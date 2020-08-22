<template>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h3>Answer this question</h3>
                    </div>
                    <hr>
                    <form @submit.prevent="create">

                        <div class="form-group">
                            <textarea name="body" v-model="body" class="form-control" rows="5" placeholder="Type your answer here"></textarea>
                        </div>
                        <div class="form-group">
                            <button title="Answer must be more than 3 character" type="submit" :disabled="isInvalid"  class="btn btn-lg btn-outline-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import EventBus from "../../event-bus";
    export default {
        name: "NewAnswer",
        props:['questionId'],
        data() {
            return{
                body:''
            }
        },
        computed: {
            isInvalid(){
                return this.body.trim().length  < 3 ;
            }
        },
        methods:{
            create(){
               if (this.isSignedIn){
                   axios.post(`/questions/${this.questionId}/answers`,{
                       body:this.body
                   }).then(({data}) => {
                       this.$toast.success("Create new answer",'Success',{timeout:3000,position:"bottomCenter"})
                       EventBus.$emit("answer_created",data.answer);
                       this.body = '';
                   }).catch( error =>{
                       this.$toast.error("Create new answer error",'Error',{timeout:3000,position:"bottomCenter"})

                   })
               }else{
                   window.location.hrepf ="/login";
               }
            }
        }

    }
</script>

<style scoped>

</style>
