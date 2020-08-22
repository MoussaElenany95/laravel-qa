<template>
    <div class="media post">
        <div class="d-flex flex-column counters">
            <div class="vote">
                <strong> {{ votesCount }} </strong> {{plural(votesCount,"vote")}}
            </div>
            <div :class="classes">
                <strong> {{ answersCount }} </strong>{{plural(answersCount,"answer")}}
            </div>
            <div  class="view">
                {{viewsCount +" "+ plural(viewsCount,'view')}}
            </div>
        </div>
        <div class="media-body">
            <div v-if="!editing">
                <div class="d-flex align-items-center">
                    <h3 class="mt-0"><a :href="url">{{title}}</a></h3>
                    <div v-if="authorize('modify',question)" class="ml-auto">
                        <a @click.prevent="edit" class="btn btn-outline-primary btn-sm">Edit</a>
                    </div>
                    <div  v-if="authorize('deleteQuestion',question)" class="ml-2">
                        <button class="btn btn-sm btn-outline-danger" @click.prevent="remove" >Delete</button>
                    </div>

                </div>
                <p class="lead">
                    Asked by <a :href="question.user.url">{{question.user.name}}</a>
                    <small class="text-muted">{{question.created_date}}</small>
                </p>
                {{question.body_html}}
            </div>
            <form v-else @submit.prevent="update">
                <div class="form-group">
                    <label for="question-title">Title</label>
                    <input type="text" name="title" v-model="title" id="question-title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="question-body">Explain your question</label>
                    <textarea name="body" rows="10" class="form-control" v-model="body"  id="question-body"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" :disabled="isInvalid" class="btn btn-outline-primary btn-lg">Update</button>
                    <button class="btn btn-danger btn-lg" @click.prevent="cancel">Cancel</button>
                </div>
            </form>


        </div>
    </div>
</template>

<script>
    export default {
        name: "Question",
        props:['question'],
        data(){
            return {
                votesCount : this.question.votes_count,
                answersCount: this.question.answers_count,
                viewsCount:this.question.views,
                status:this.question.status,
                url:this.question.url,
                title:this.question.title,
                id:this.question.id,
                body:this.question.body,
                editing:false,
                titleError:true,
                beforeUpdateCash:{}
            }
        },
        computed:{
            classes(){
                return [
                    'status',
                     this.status
                ]
            },
            isInvalid(){
                return this.title.trim().length < 5 || this.body.trim().length < 5 || ( this.beforeUpdateCash.body === this.body.trim() && this.beforeUpdateCash.title === this.title.trim()  ) ;
            }
        },
        methods:{
            edit(){
                this.editing = true;
                this.beforeUpdateCash = this.question;
            },
            update(){
                axios.put(`/questions/${this.id}/`,{
                    title:this.title,
                    body:this.body
                }).then( res=> {
                    this.editing = false;
                    this.beforeUpdateCash.title = this.title;
                    this.beforeUpdateCash.body = this.body;
                    this.question.body_html  = res.data.bodyHtml;

                    this.$toast.success(res.data.message,'Success',{timeout:3000});

                }).catch( error =>{
                        if( error.response.data.errors.title){
                            this.titleError =  error.response.data.errors.title[0];
                            this.$toast.error(this.titleError,'Failed',{timeout:3000});
                        }
                    }
                );
            },
            remove(){
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
                            axios.delete(`/questions/${this.id}/`)
                                .then( res =>{
                                    this.$emit("delete",this.id);
                                    $(this.$el).fadeOut(500);
                                    this.$toast.success(res.data.message,"Success",{timeout:3000});
                                })
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }, true],
                        ['<button>NO</button>', function (instance, toast) {

                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                        }],
                    ],
                });

            }
            ,
            cancel(){
              this.editing = false;
              this.body = this.beforeUpdateCash.body;
              this.title = this.beforeUpdateCash.title;
            },
            plural(value,name){
                return value > 1 ? name+"s":name;
            }
        }
    }
</script>

<style scoped>

</style>
