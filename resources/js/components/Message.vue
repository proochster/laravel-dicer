<template>
    <div class="message rounded px-3 py-1 mb-2 mx-3">
        <span class="message_name">{{m.name}}</span>
        <span v-if="m.text" class="message_text">{{m.text}}</span>
        <span v-if="m.diceType" class="message_dice text-info" :data-d="m.diceType">rolling D{{m.diceType}}</span>
        <div class="dice" v-if="m.diceRoll">
            <span class="message_roll">{{m.diceRoll}}</span>
            <img :src="src" height="30">
        </div>
    </div>
</template>

<script>
export default {
    props:{
        m:{
            type: Object,
            required: true
        }
    },
    data() {
        return {
            src: ''
        }
    },
    methods: {
       imageLink(){
           this.src = `/images/d${this.m.diceType}.svg`;
       }
    },
    mounted() {
        this.imageLink();
    }
}
</script>