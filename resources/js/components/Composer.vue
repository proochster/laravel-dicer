<template>
    <div class="composer form-group mt-3 mb-0">
        <textarea class="form-control" v-model="message" @keydown.enter="composeMessage" placeholder="Message"></textarea>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: '',
            // diceType: '',
            // diceRoll: ''
        }
    },
    methods: {
       composeMessage(e){
           e.preventDefault();
           
           if( this.message == '' ){
               return;
           }

           this.$emit('e-messagecomposed', this.message);
           this.message = '';
       } 
    }
}
</script>