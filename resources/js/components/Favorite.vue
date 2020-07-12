<template>
        <a href="" :class="classes" title="mark as favorite ( click again to undo ) "
           @click.prevent="favoriteQuestion"
        >
            <i class="fas fa-star fa-2x"></i>
            <span class="favorite-count">{{favoritesCount}}</span>
        </a>
</template>

<script>
    export default {
        name: "Favorite",
        props:['question'],
        data(){
            return{
                favoritesCount : this.question.favorites_count,
                favorited: this.question.favoritted,
                questionId: this.question.id,
                isSignedIn: window.auth.signedIn,
            }
        },
        methods:{
            favoriteQuestion(){
                if (this.isSignedIn){
                    axios.post(`/questions/${this.questionId}/favorite`).then(res =>{
                            this.toggle();

                        }
                    )
                }else {
                    window.location.href = '/login';
                }
            }
        },
        computed:{
            classes(){
                return ['favorite','mt-2',this.favorited ?'favorited':''];
            },
            toggle(){
                return this.favorited ? this.destroy() : this.create();
            },
            create(){
                this.favoritesCount ++;
                this.favorited = true;
            },
            destroy(){
                this.favoritesCount --;
                this.favorited = false;
            }
        }
    }
</script>

<style scoped>

</style>
