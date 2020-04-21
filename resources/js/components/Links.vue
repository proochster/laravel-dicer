<template>
    <div class="links">
        <div class="form-group">
            <label for="url">Link address</label>
            <input type="text" class="form-control" v-model="url" name="url" placeholder="https://link.com/to/asste">
        </div>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" v-model="title" name="title" placeholder="Soundtrack 1">
        </div>
        <button @click="sendLink" type="submit" class="btn btn-success mb-2">Add</button>
        <!-- <div class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add name</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="name" @keydown.enter="sendName" placeholder="Your name">
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div> -->
    </div>
</template>

<script>
export default {
    props: {
        room_hash:{
            type: String,
            required: true
        }
        // messages: {
        //     type: Array,
        //     default: []
        // },
        // userToken: {
        //     type: String,
        //     required: true
        // },
        // userName: {
        //     type: String,
        //     required: true
        // },
        // userID: {
        //     type: Number,
        //     required: true
        // }
    },
    data() {
        return {
            url: '',
            title: ''
        }
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
        }
    }
}
</script>