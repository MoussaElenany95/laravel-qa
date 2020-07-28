<template>
    <div class="media post" v-cloak>
        <div class="d-flex flex-column  vote-controls">
            <answer-vote :answer="answer"></answer-vote>
            <answer-accept :answer="answer"></answer-accept>
        </div>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea  class="form-control" v-model="body" rows="7"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" :disabled="isInvalid"  type="submit">Update</button>
                    <button class="btn btn-danger" @click="cancel"  type="button">Cancel</button>
                </div>
            </form>
            <div v-if="!editing">
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div  class="col-4 d-flex flex-row">
                        <div v-if="authorize('modify',answer)" class="">
                            <a @click.prevent="edit" class="btn btn-outline-primary btn-sm">Edit</a>
                        </div>
                        <div  v-if="authorize('modify',answer)" class="ml-2">
                            <button class="btn btn-sm btn-outline-danger" @click.prevent="destroy">Delete</button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <user-info :model="answer" label="Answered "></user-info>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    import UserInfo from "./UserInfo";
    import AnswerVote from "./AnswerVote";
    import AnswerAccept from "./AnswerAccept";
    export default {
        name: "Answer",
        props:['answer'],
        data(){
            return{
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                beforeUpdateCash: this.answer.body,
                answerId: this.answer.id,
                questionId: this.answer.question_id,
            }
        },
        methods:{
            update(){
               axios.patch(`/questions/${this.questionId}/answers/${this.answerId}`,
                   {'body': this.body}
                    )
                   .then( res =>{
                        this.bodyHtml = res.data.bodyHtml;
                        this.beforeUpdateCash = this.body;
                        this.editing = false;
                        this.$toast.success(res.data.message,'Success',{ timeout:3000 });

                   })
                   .catch(err =>{
                       this.$toast.error(err.response.data.message,'Error',{ timeout:3000 });
                   });
            },destroy(){
                this.$toast.question('Are you sure to delete ? ','Delete',{
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {
                            axios.delete(`/questions/${this.questionId}/answers/${this.answerId}`)
                                 .then(res => {
                                     this.$emit('deleted');
                                     this.$toast.success(res.data.message,'Success',{ timeout:3000 });
                                 })
                                 .catch( err => {

                                     this.$toast.error(err.response.data.message,'Error',{ timeout:3000 });
                                 });
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                });
                // if(confirm('Are you sure to delete ? ')){
                //     axios.delete(`/questions/${this.questionId}/answers/${this.answerId}`)
                //          .then(res => {
                //              $(this.$el).stop().fadeOut();
                //              this.$toast.success(res.data.message,'Success',{ timeout:3000 });
                //
                //          })
                //          .catch( err => {
                //
                //              this.$toast.error(err.response.data.message,'Error',{ timeout:3000 });
                //          });
                // }
            },
            cancel(){
                this.editing = false;
                this.body = this.beforeUpdateCash;
            },
            edit(){
                this.editing = true;
            }
        },
        computed:{
            isInvalid(){
                return this.body.trim().length < 5 || this.beforeUpdateCash === this.body ;
            }
        },
        components:{UserInfo,AnswerVote,AnswerAccept}

    }
</script>

