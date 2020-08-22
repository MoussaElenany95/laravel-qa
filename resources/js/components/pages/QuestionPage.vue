<template>
    <div class="container">
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
    import Question from "../questions/QuestionDetails";
    import Answers from "../answers/Answers";
    export default {
        name: "QuestionPage",
        props:['question'],
        components:{
            Question,Answers
        }
    }
</script>

<style scoped>

</style>
