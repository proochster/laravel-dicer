<template>
    <div class="conversation">
        <div class="scroll" ref="scroll">
            <div class="scroll-content">
                <ul class="mr-3">
                    <li v-for="message in messages" :key="message.id" :class="{'self': userID == message.from}" >
                        <div class="message rounded px-3 py-1 mb-2">
                            <span class="message_name">{{message.name}}</span>
                            <span class="message_text">{{message.text}}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <Composer @e-messagecomposed="sendMessage"></Composer>
    </div>
</template>

<script>
import Composer from "./Composer";

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
        sendMessage(text) {

            axios.post('/api/messages', {
                user_hash: this.userToken,
                room_hash: this.room,
                text: text
            })
            .then(response => {
                // this.$emit('e-new', response.data);
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
        Composer
    }
}
</script>