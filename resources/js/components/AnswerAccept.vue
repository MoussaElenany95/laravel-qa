<template>
    <div>
        <a v-if="authorize('accept',answer)" href="" title="Accept this answer ( click again to undo ) "  :class="classes" @click.prevent="acceptAnswer">
            <i class="fas fa-check fa-2x"></i>
        </a>
        <a v-else="accepted" title="this answer was accepted as the best answer  "
           :class="classes">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>

</template>

<script>
    export default {
        name: "AnswerAccept",
        props:['answer'],
        data(){
            return{
                answerId: this.answer.id,
                status: this.answer.status,
            }
        },
        methods:{
            acceptAnswer(){
                this.toggle();
                axios.post(`/answers/${this.answerId}/accept`).then(res =>{
                    this.$toast.success("Accept / Unaccept answer  ",'Success',{timeout:3000,position:"bottomCenter"})
                }).catch(error => {
                    this.$toast.error("Accept / Unaccept answer unknown error  ",'Failed',{timeout:3000,position:"bottomCenter"})
                })
            },
            toggle(){
                return this.status? this.destroy():this.create();
            },
            create(){
                this.status = true;
            },
            destroy(){
                this.status = false;
            }
        },
        computed:{
            classes(){
                return [
                    'mt-2',
                     this.status?'vote-accepted':'',
                ]
            },
            accepted(){
                return this.status;
            }
        }
    }
</script>

<style scoped>

</style>
