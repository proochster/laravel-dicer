<template>
    <div class="dice" :data-d="d" @click="rollRice">
        <span>{{d}}</span>
        <img :src="src" :alt="d" height="50">
    </div>
</template>

<script>
export default {
    props:{
        d:{
            type: Number,
            required: true
        }
    },
    data() {
        return {
            message: '',
            src: ''
        }
    },
    methods: {
       rollRice(){

        let roll = 1 + Math.floor(Math.random()*this.d);        
        this.$emit('e-messagecomposed', this.message, this.d, roll );
       },

       imageLink(){
           this.src = `/images/d${this.d}.svg`;
       }
    },
    mounted() {
        this.imageLink();
    }
}
</script>