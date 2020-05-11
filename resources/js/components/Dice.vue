<template>
    <div class="dice" :data-d="d" @click="rollDice">
        <span>{{d}}</span>
        <img :src="imageLink" :alt="d" height="50">
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
            message: ''
        }
    },

    computed: {
       imageLink(){
           return `/images/d${this.d}.svg`;
       }
    },

    methods: {
       rollDice(){

        let roll = 1 + Math.floor(Math.random()*this.d);        
        this.$emit('e-messagecomposed', this.message, this.d, roll );
       }
    }
}
</script>