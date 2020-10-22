<template>
    <div class="message rounded px-3 py-1 mb-2 mx-3">
        <span class="message_name">{{m.user.name}}</span>
        <span v-if="m.text" class="message_text">{{m.text}}</span>
        <span v-if="m.diceType" class="message_dice text-white-50" :data-d="m.diceType"> D{{m.diceType}}</span>
        <div class="dice" v-if="m.dice_rolls">
            <span v-if="m.dice_rolls.length > 0" class="small text-white-50 pr-2"> x {{m.dice_rolls.length}} </span>
            <span v-if="m.dice_rolls.length > 0" class="dice-image">
                <img v-if="m.diceType" :src="imageLink" height="30">
                <span class="rolls-sum">{{sum}}</span>
            </span>
        </div>
        <ul v-if="m.dice_rolls.length > 1" class="rolls text-info text-monospace">
            <li class="roll" v-for="(roll, index) in m.dice_rolls" :key="index">{{roll.dice_roll}}</li>
        </ul>
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