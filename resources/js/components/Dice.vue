<template>
    <div class="dice-menu" :data-d="d">
        <picture class="dice-button" @click="rollDice(1)">
            <img :src="imageLink" :alt="d" height="50">
            <span>{{d}}</span>
        </picture>
        <ul class="dice-rolls">
            <li @click="rollDice(10)">x 10</li>
            <li @click="rollDice(9)">x 9</li>
            <li @click="rollDice(8)">x 8</li>
            <li @click="rollDice(7)">x 7</li>
            <li @click="rollDice(6)">x 6</li>
            <li @click="rollDice(5)">x 5</li>
            <li @click="rollDice(4)">x 4</li>
            <li @click="rollDice(3)">x 3</li>
            <li @click="rollDice(2)">x 2</li>
        </ul>
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
        rollDice(count){
            let diceArray = [];
            
            for (var i = 1; i <= count; i++) {
                let d = 1 + Math.floor(Math.random()*this.d);
                diceArray.push(d);
                console.log('Count ++ : ' + i);
            }
                console.log('Count: ' + count);
            // let roll = 1 + Math.floor(Math.random()*this.d);
            

            this.$emit('e-messagecomposed', this.message, this.d, diceArray );
        }
    }
}
</script>