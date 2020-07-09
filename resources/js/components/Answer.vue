<script>
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
                                     $(this.$el).stop().fadeOut();
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
        }
    }
</script>
