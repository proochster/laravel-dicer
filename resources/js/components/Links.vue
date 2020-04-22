<template>
    <div class="links">
        <ul class="list-inline">
            <li v-for="link in links" :key="link.id" >
                <a :href="link.url" target="_blank" class="btn btn-outline-dark btn-sm d-block mb-1 text-capitalize text-left">{{link.title}}</a>
            </li>
        </ul>
        <hr>
        <div class="link-form row">
            <div class="form-group col-6">
                <label for="url">Link address</label>
                <input type="text" class="form-control form-control-sm" v-model="url" name="url" placeholder="https://link.com/to/asste">
            </div>
            <div class="form-group col-6">
                <label for="title">Title</label>
                <input type="text" class="form-control form-control-sm" v-model="title" name="title" placeholder="Soundtrack 1">
            </div>
        </div>
        <button @click="sendLink" type="submit" class="btn btn-success btn-sm w-100">Add</button>
    </div>
</template>

<script>
export default {
    props: {
        room_hash:{
            type: String,
            required: true
        }
    },
    data() {
        return {
            url: '',
            title: '',
            links: []
        }
    },

    mounted() {

        /**
         * Listens on channel {room_hash}
         */
        window.Echo.channel(`room-channel.${this.room_hash}`)
            .listen('NewLink', e => {
                this.saveNewLink(e.link);
            });

        /**
         * Gets all Links from Laravel API
         */
        axios.get(`/api/room/${this.room_hash}/links`)
            .then(response => {
                this.links = response.data;
                // console.log(this.links);
            });
        
    },
    
    methods: {

        sendLink() {

            if( this.url == '' || this.title == "" ){
                return;
            }

            axios.post('/api/links', {
                room_hash: this.room_hash,
                url: this.url,
                title: this.title
            })
            .then(response => {
                // this.$emit('e-new', response.data);
            })
            .catch(function (error) {         
                console.log(error);            
            });

            // Reset form
            this.url = '';
            this.title = "";
        },
        
        saveNewLink(l){                
            this.links.push(l);
        },
    }
}
</script>