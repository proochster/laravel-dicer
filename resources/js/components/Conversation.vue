<template>
    <div class="conversation">
        <div class="scroll" ref="scroll">
            <div class="scroll-content">
                <ul>
                    <li v-for="message in messages" :key="message.id">
                        <div class="message rounded bg-light px-3 py-1 mb-2">
                            <span class="message_name">{{message.name}}</span>
                            <span class="message_text">{{message.text}}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <Composer @send="sendMessage"></Composer>
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
                response.data.name = this.userName; // Add local Username to the Message object
                this.$emit('new', response.data);
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