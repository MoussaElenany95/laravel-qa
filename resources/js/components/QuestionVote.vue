<template>
    <div>
        <a href="" title="This question is useful" class="vote-up" @click.prevent="voteQuestion(1)">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <span class="votes-count">{{votesCount}}</span>
        <a href="" title="This question is not useful" class="vote-down" @click.prevent="voteQuestion(-1)">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        name: "QuestionVote",
        props:['question'],
        data(){
            return{
                votesCount:this.question.votes_count,
                questionId:this.question.id,
                vottedUp:this.question.votted_up,
                vottedDown:this.question.votted_down,
            }
        },
        methods : {
            voteQuestion(vote){
                if (vote === 1 && this.vottedUp )
                    this.$toast.warning("You already voted up this question ","Warning",{timeout:3000});
                else if (vote === -1 && this.vottedDown)
                    this.$toast.warning("You already voted down this question ","Warning",{timeout:3000});
                else
                    this.request(vote);

            },
            request(vote){
                if(window.auth.signedIn) {
                    axios.post(`/questions/${this.questionId}/vote`, {'vote': vote}).then(
                        res => {

                            this.votesCount = res.data.votesCount;
                            this.$toast.success(res.data.message, "Success", {timeout: 3000});
                            if (vote === 1 ) {
                                this.vottedUp = true;
                                this.vottedDown = false;
                            }
                            else {
                                this.vottedDown = true;
                                this.vottedUp = false;
                            }
                        }
                    ).catch(
                        error => {
                            this.$toast.error("Unknown error , try again", "Failed", {timeout: 3000});
                        }
                    )
                }else{

                    window.location.href = "/login";

                }
            }

        }

    }
</script>

<style scoped>

</style>
