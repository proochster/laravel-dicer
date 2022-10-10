<template>
    <div class="message rounded px-3 py-1 mb-2 mx-3" :class="'dicetype_' + m.diceType">
        <span class="message_name">{{m.user.name}}</span>
        <span v-if="m.text" class="message_text">{{m.text}}</span>
        <span v-if="m.diceType" class="message_dice text-white-50" :data-d="m.diceType"> D{{m.diceType}}</span>
        <div class="dice" v-if="m.dice_rolls">
            <span v-if="m.dice_rolls.length > 1" class="small text-accent pr-2"> x {{m.dice_rolls.length}} </span>
            <span v-if="m.dice_rolls.length > 0" :data-class="crit" class="dice-image" :class="roll">
                <img v-if="m.diceType" :src="imageLink" height="30">
                <span class="rolls-sum">{{sum}}</span>
            </span>
        </div>
        <ul v-if="m.dice_rolls.length > 1" class="rolls text-accent-light text-monospace">
            <li class="roll" v-for="(roll, index) in m.dice_rolls" :key="index" :class="'d_' + roll.dice_roll">{{roll.dice_roll}}</li>
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
       },
       crit(){
            let dice_class = '';

            if(this.m.dice_rolls.length == 1){

                // Low roll 
                if( this.m.dice_rolls[0].dice_roll == 1 ) dice_class = 'crit-fail';
                // High roll
                else if( this.m.dice_rolls[0].dice_roll == this.m.diceType ) dice_class = 'crit-win';

                return dice_class;
            }
       },

        roll(){
            let roll_class = '';

            if(this.m.dice_rolls.length == 1){

                roll_class += "diceroll_" + this.m.dice_rolls[0].dice_roll;
                return roll_class;

            }
        }
    },
}
</script>