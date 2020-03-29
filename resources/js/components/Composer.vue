<template>
    <div class="composer form-group mt-3">
        <textarea class="form-control" v-model="message" @keydown.enter="send" placeholder="Message"></textarea>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: ''
        }
    },
    methods: {
       send(e){
           e.preventDefault();
           
           if( this.message == '' ){
               return;
           }

           this.$emit('send', this.message);
           this.message = '';
       } 
    }
}
</script>