<template>
    <div class="conversation">
        <div class="scroll" ref="scroll">
            <div class="scroll-content">
                <ul class="mr-3">
                    <li v-for="message in messages" :key="message.id" :class="[message.id, {'self': userID == message.from}]" >
                        <Message :m="message" :key="message.id"></Message>
                    </li>
                </ul>
            </div>
        </div>
        <div class="diceset">
            <!-- <Dice :d="2" @e-messagecomposed="sendMessage"></Dice> -->
            <Dice :d="4" @e-messagecomposed="sendMessage"></Dice>
            <Dice :d="6" @e-messagecomposed="sendMessage"></Dice>
            <Dice :d="8" @e-messagecomposed="sendMessage"></Dice>
            <Dice :d="10" @e-messagecomposed="sendMessage"></Dice>
            <Dice :d="12" @e-messagecomposed="sendMessage"></Dice>
            <!-- <Dice :d="20" @e-messagecomposed="sendMessage"></Dice> -->
            <Dice :d="100" @e-messagecomposed="sendMessage"></Dice>
        </div>
        <Composer @e-messagecomposed="sendMessage"></Composer>
    </div>
</template>

<script>
import Composer from "./Composer";
import Dice from "./Dice";
import Message from "./Message";

export default {
    props: {
        room:{
            type: String,
            required: true
        },
        messages: {
            type: Array,
            default: []
        },
        userToken: {
            type: String,
            required: true
        },
        userName: {
            type: String,
            required: true
        },
        userID: {
            type: Number,
            required: true
        }
    },
    
    methods: {
        
        sendMessage(text, diceType, diceArray) {

            // console.log(text, diceType, diceArray);

            // console.log(diceArray);
            // let rolls = [];
            let rolls_roll = [];

            if (diceArray != undefined){
                // for (let i = 0; i < diceArray.length; i++) {
                //     rolls[i] = diceArray[i];
                // }
                
                for (let i = 0; i < diceArray.length; i++) {
                    rolls_roll[i] = {'dice_roll':diceArray[i]};
                }
            }

            this.messages.push({
                userHash: this.userToken,
                text: text,
                diceType: diceType,
                // diceRoll: diceRoll,
                dice_rolls: rolls_roll,
                user:{
                    name: this.userName,
                },
                from: this.userID
            });
            
            // console.log('Pushed message locally');

            // console.log('Sent message');
            axios.post('/api/messages', {
                userHash: this.userToken,
                text: text,
                diceType: diceType,
                // diceRoll: diceRoll,
                dice_rolls: rolls_roll,
                roomHash: this.room
            })
            .then(response => {
                // this.$emit('e-new', response.data);                
                // console.log('Message saved. Server responded' + response);
            })
            .catch(function (error) {         
                console.log(error);            
            });
        },
        scrollToBottom(){
            setTimeout(()=>{
                this.$refs.scroll.scrollTop = this.$refs.scroll.scrollHeight - this.$refs.scroll.clientHeight;
            }, 50);
        },
    },

    watch: {
        messages(messages){
            this.scrollToBottom();
        }
    },

    components: {
        Composer, Dice, Message
    },
}
</script>