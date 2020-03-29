<template>
    <div class="chat">
        <AddName v-if="showUserInput" @send="sendName"></AddName>
        <Conversation :room="room_hash" :userToken="userToken" :userName="userName" :messages="messages" @new="saveNewMessage" />
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import AddName from './AddName';

    export default {
        props: {
            room_hash:{
                type: String,
                required: true
            }
        },
        data(){
            return{
                currentRoom: null,
                messages: [],
                showUserInput: true,
                userToken: '',
                userName: '',
            }
        },
        mounted() {
            axios.get(`/api/room/${this.room_hash}/messages`)
                .then(response => {
                    this.messages = response.data;
                });
            this.checkUser();
        },
        methods: {
            sendName(name) {
                axios.post(`/api/user/`, {
                    'username': name
                })
                .then(response => {
                    this.setUserData(response.data);
                    this.showUserInput = false;
                })
                .catch(function (error) {
                    console.log(error);            
                });
            },
            checkUser(){
                if (document.cookie.indexOf('diceroom_user_') == -1 ) {
                    this.showUserInput = true;
                } else {
                    this.showUserInput = false;
                    this.userToken = this.getCookieValue('diceroom_user_token');
                    this.userName= this.getCookieValue('diceroom_user_name');
                }
            },
            setUserData(data){
                document.cookie = `diceroom_user_token=${data.hash}; expires=${new Date(new Date().getTime()+1000*60*60*24*365).toGMTString()}; path=/;`;
                document.cookie = `diceroom_user_name=${data.name}; expires=${new Date(new Date().getTime()+1000*60*60*24*365).toGMTString()}; path=/;`;
                this.userToken = data.hash;
                this.userToken = data.name;
            },
            saveNewMessage(text){
                this.messages.push(text);
            },
            getCookieValue(cname){
                var name = cname + "=";
                var decodedCookie = decodeURIComponent(document.cookie);
                var ca = decodedCookie.split(';');
                for(var i = 0; i <ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                    }
                    if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                    }
                }
                return "";
            }
        },
        components: {
            Conversation, AddName
        }
    }
</script>
