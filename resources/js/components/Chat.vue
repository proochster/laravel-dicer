<template>
    <div class="chat">
        <AddName v-if="showUserInput" @send="sendName"></AddName>
        <Conversation :room="room_hash" :userID="userID" :userToken="userToken" :userName="userName" :messages="messages"/>
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
                userID: 0
            }
        },

        created(){
            /**
             * Gets all messages from Laravel API
             */
            axios.get(`/api/room/${this.room_hash}/messages`)
                .then(response => {
                    // Limit the number of messgaes
                    this.messages = response.data.slice(Math.max( response.data.length - 50, 1));
                });
        },

        mounted() {

            this.checkUser();

            /**
             * Listens on channel {room_hash}
             * 
             * Returns: id, from, toRoom, text, name
             */
            window.Echo.channel(`room-channel.${this.room_hash}`)
                .listen('NewMessage', e => {
                    // console.log('MEssage: ', e.message);
                    this.saveNewMessage(e.message);
                });           
        },

        methods: {

            sendName(name) {
                axios.post(`/api/user`, {
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
                    this.userName = this.getCookieValue('diceroom_user_name');
                    this.userID = Number(this.getCookieValue('diceroom_user_ID'));

                }
            },

            setUserData(data){
                this.userToken = data.hash;
                this.userName = data.name;
                this.userID = data.id;
                document.cookie = `diceroom_user_token=${data.hash}; expires=${new Date(new Date().getTime()+1000*60*60*24*365).toGMTString()}; path=/;`;
                document.cookie = `diceroom_user_name=${data.name}; expires=${new Date(new Date().getTime()+1000*60*60*24*365).toGMTString()}; path=/;`;
                document.cookie = `diceroom_user_ID=${data.id}; expires=${new Date(new Date().getTime()+1000*60*60*24*365).toGMTString()}; path=/;`;
            },

            saveNewMessage(m){                
                this.messages.push(m);
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
