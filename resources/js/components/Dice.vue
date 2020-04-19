<template>
    <div class="btn btn-primary dice" @click="rollRice">{{d}}</div>
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
        }
    },
    methods: {
       rollRice(){

        let roll = 1 + Math.floor(Math.random()*this.d);        
        this.$emit('e-messagecomposed', this.message, this.d, roll );
       } 
    }
}
</script>