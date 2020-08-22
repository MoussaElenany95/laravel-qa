<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h2>{{title}}</h2>
                                <div class="ml-auto">
                                    <a href="/questions" class="btn btn-outline-secondary">Back to all questions</a>
                                </div>
                            </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column  vote-controls">
                                <question-vote :question="question"></question-vote>
                                <favorite :question="question"></favorite>
                            </div>
                            <div class="media-body">
                                <div v-html="bodyHtml"></div>
                                <div class="row mt-2">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <user-info :model="question" label="Asked "></user-info>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <new-answer :question-id="questionId"></new-answer>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
    import NewAnswer from "../answers/NewAnswer";
    import UserInfo from "../UserInfo";
    import QuestionVote from "./QuestionVote";
    import Favorite from "./Favorite";
    export default {
        name: "Question",
        props:['question'],
        data(){
            return{
                questionId : this.question.id,
                bodyHtml : this.question.body_html,
                title : this.question.title
            }
        },
        components:{
            NewAnswer,QuestionVote,Favorite,UserInfo
        }
    }
</script>

<style scoped>

</style>
