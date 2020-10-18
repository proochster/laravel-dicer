<template>
    <div class="message rounded px-3 py-1 mb-2 mx-3">
        <span class="message_name">{{m.user.name}}</span>
        <span v-if="m.text" class="message_text">{{m.text}}</span>
        <span v-if="m.diceType" class="message_dice text-info pr-2" :data-d="m.diceType">rolling D{{m.diceType}} x {{m.dice_rolls.length}}</span>
        <div class="dice" v-if="m.dice_rolls">
            <img v-if="m.diceType" :src="imageLink" height="30">
            <ul v-if="m.dice_rolls.length > 1" class="rolls">
                <li class="roll" v-for="(roll, index) in m.dice_rolls" :key="index">{{roll.dice_roll}}</li>
            </ul>
            <span class="rolls-sum">{{sum}}</span>
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
    computed: {
       imageLink(){
           return `/images/d${this.m.diceType}.svg`;
       },
       sum(){
            let roll_sum = 0;
            for (let i = 0; i < this.m.dice_rolls.length; i++) {
                roll_sum += this.m.dice_rolls[i]['dice_roll'];
            }
            return roll_sum;
       }
    },
}
</script>