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
               this.editing = false;
               axios.patch(`/questions/${this.questionId}/answers/${this.answerId}`,
                   {'body': this.body}
                    )
                   .then( res =>{
                        this.bodyHtml = res.data.bodyHtml;
                        this.editing = false;
                   })
                   .catch(err =>{
                       alert('Something went wrong !'+err.response.data.message)
                   });
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
                return this.body.trim().length < 5 ;
            }
        }
    }
</script>
