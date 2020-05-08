<template>
    <div class="links">
        <ul class="list-inline">
            <li v-for="link in links" :key="link.id" class="d-flex align-items-center">
                <a :href="link.url" target="_blank" class="flex-fill text-capitalize text-info text-left btn">{{link.title}}</a>
                <a class="btn btn-sm text-danger" @click="removeLink(link.id)" title="Remove this link">x</a>
            </li>            
            <li v-if="!links.length">Add first link below.</li>
        </ul>
        <hr>
        <div class="link-form row">
            <div class="form-group col-6">
                <input type="text" class="form-control form-control-sm" v-model="url" name="url" placeholder="URL address">
            </div>
            <div class="form-group col-6">
                <input type="text" class="form-control form-control-sm" v-model="title" name="title" placeholder="Title">
            </div>
        </div>
        <button @click="sendLink" type="submit" class="btn btn-success btn-sm w-100">Add Link</button>
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
            })
            .listen('DestroyLink', e => {
                let mappedIndex = this.links.map( l => l.id ).indexOf(e.link.id);
                this.links.splice(mappedIndex, 1); 
            });

        /**
         * Gets all Links from Laravel API
         */
        axios.get(`/api/room/${this.room_hash}/links`)
            .then(response => {
                this.links = response.data;
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

        removeLink(itemID){

            axios.delete(`/api/room/${this.room_hash}/link/${itemID}`)
            .then(response => {

            })
            .catch(function (error) {         
                console.log("Oh no! ", error);            
            });
        },
        
        saveNewLink(l, i){                
            this.links.push(l);            
        },
    }
}
</script>