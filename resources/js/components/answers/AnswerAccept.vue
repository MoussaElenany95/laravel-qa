<template>
    <div>
        <a v-if="authorize('accept',answer)" href="" title="Accept this answer ( click again to undo ) "  :class="classes" @click.prevent="acceptAnswer">
            <i class="fas fa-check fa-2x"></i>
        </a>
        <a v-else-if="accepted" title="this answer was accepted as the best answer  "
           :class="classes">
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>

</template>

<script>
    import EventBus from '../../event-bus';
    export default {
        name: "AnswerAccept",
        props:['answer'],
        data(){
            return{
                answerId: this.answer.id,
                status: this.answer.status,
            }
        },
        created(){
            EventBus.$on('accepted',id => {
                this.status = ( id == this.answerId);
            })
        }
        ,
        methods:{
            acceptAnswer(){
                this.toggle(); // change color for current answer to unaccept
                axios.post(`/answers/${this.answerId}/accept`).then(res =>{

                    if (this.status)
                        EventBus.$emit('accepted',this.answerId);

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
