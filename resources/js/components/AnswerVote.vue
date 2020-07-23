<template>
    <div>
        <a href="" title="This question is useful" class="vote-up" @click.prevent="voteAnswer(1)">
            <i class="fas fa-caret-up fa-3x"></i>
        </a>
        <span class="votes-count">{{votesCount}}</span>
        <a href="" title="This question is not useful" class="vote-down" @click.prevent="voteAnswer(-1)">
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        name: "AnswerVote",
        props:['answer'],
        data(){
            return{
                votesCount:this.answer.votes_count,
                answerId:this.answer.id,
                vottedUp:this.answer.votted_up,
                vottedDown:this.answer.votted_down,
            }
        },
        methods : {
            voteAnswer(vote){
                if (vote === 1 && this.vottedUp )
                    this.$toast.warning("You already voted up this answer ","Warning",{timeout:3000, position: "bottomCenter"});
                else if (vote === -1 && this.vottedDown)
                    this.$toast.warning("You already voted down this answer ","Warning",{timeout:3000, position: "bottomCenter"});
                else
                    this.request(vote);

            },
            request(vote){
                if(window.auth.signedIn) {
                    axios.post(`/answers/${this.answerId}/vote`, {'vote': vote}).then(
                        res => {

                            this.votesCount = res.data.votesCount;
                            this.$toast.success(res.data.message, "Success", {timeout: 3000 , position: "bottomCenter"});
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
                            console.log(error);
                            this.$toast.error("Unknown error , try again", "Failed", {timeout: 3000, position: "bottomCenter"});
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
