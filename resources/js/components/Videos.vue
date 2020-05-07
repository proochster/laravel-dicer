<template>
    <div class="videos">
        <ul class="list-inline">
            <li v-for="video in videos" :key="video.id" class="d-flex">
                <a :href="video.url" target="_blank" class="flex-fill mb-1 text-capitalize text-info text-left">{{video.url}}</a>
                <div class="btn btn-sm text-danger" @click="removeVideo(video.id)">x</div>
            </li>            
            <li v-if="!videos.length">Add first video.</li>
        </ul>
        <hr>
        <div class="link-form row">
            <div class="form-group col-6">
                <input type="text" class="form-control form-control-sm" v-model="videoId" name="video_id" placeholder="Video ID">
            </div>
            <div class="form-group col-6">
                <button @click="sendVideo" type="submit" class="btn btn-success btn-sm w-100">Add</button>
            </div>
        </div>
        
        <!-- <div class="relative">
            <div id="video-placeholder" class="w-100"></div>    
        </div>
        <button class="btn btn-danger" id="play" @click="playVideo">Play in room</button>
        <button class="btn btn-danger" id="pause" @click="pauseVideo">Pause in room</button>
        <button class="btn btn-danger" id="pause" @click="load">Load</button> -->
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
            videoId: '',
            videos: []
        }
    },

    mounted() {

        /**
         * Listens on channel {room_hash}
         */
        window.Echo.channel(`room-channel.${this.room_hash}`)
            .listen('NewVideo', e => {
                this.saveNewVideo(e.video);
            })
            .listen('DestroyVideo', e => {
                let mappedIndex = this.videos.map( l => l.id ).indexOf(e.video.id);
                this.videos.splice(mappedIndex, 1); 
            });

        /**
         * Gets all Links from Laravel API
         */
        axios.get(`/api/room/${this.room_hash}/videos`)
            .then(response => {
                this.videos = response.data;
            });   

        /**
         * Setup YouTube player 
         */    
        // var tag = document.createElement('script');

        // tag.src = "http://www.youtube.com/iframe_api";
        // var firstScriptTag = document.getElementsByTagName('script')[0];
        // firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // var player;

        // window.onYouTubeIframeAPIReady = function() {
        //     player = new YT.Player('video-placeholder', {
        //         height: '100',
        //         width: '300',
        //         videoId: 'DQmHPEnmv4Q', // I need ID here.. this.id won't work
        //         playerVars: {
        //             color: 'white',
        //             // controls: 0,
        //             disablekb: 0,
        //             loop: 1,
        //             playlist: 'taJ60kskkns,FG0fTKAqZ5g',
        //             modestbranding: 1
        //         },
        //         events: {
        //             'onReady': window.onPlayerReady,
        //             'onStateChange': window.onPlayerStateChange,
        //             // 'onStop': window.onPlayerStop,
        //             // 'onPlay': window.onPlayerStart
        //         }
        //     });
        // }

        // window.onPlayerReady = function(event) {
        //     // event.target.playVideo();
        // }

        // window.onPlayerStateChange = function(event) {
        //     // when video ends I need to emit notification to parent
        // }

        // window.onPlayerStart = function() {
        //     console.log('start');
        //     player.playVideo();
        // }

        // window.onPlayerStop = function() {
        //     console.log('stop');
        //     player.pauseVideo();
        // }

    },
    
    methods: {

        // load(){
        // console.log('hello');
        // window.onYouTubeIframeAPIReady = function() {
        //     player = new YT.Player('video-placeholder', {
        //         height: '200',
        //         width: '300',
        //         videoId: 'DQmHPEnmv4Q', // I need ID here.. this.id won't work
        //         playerVars: {
        //             color: 'white',
        //             // controls: 0,
        //             disablekb: 0,
        //             loop: 1,
        //             playlist: 'taJ60kskkns,FG0fTKAqZ5g',
        //             modestbranding: 1
        //         },
        //         events: {
        //             'onReady': window.onPlayerReady,
        //             'onStateChange': window.onPlayerStateChange,
        //             // 'onStop': window.onPlayerStop,
        //             // 'onPlay': window.onPlayerStart
        //         }
        //     });
        // }

        // },

        // playVideo(){
        //     window.onPlayerStart();
        // },

        // pauseVideo(){
        //     window.onPlayerStop();
        // },

        sendVideo() {

            if( this.url == '' ){
                return;
            }

            axios.post('/api/videos', {
                room_hash: this.room_hash,
                url: this.videoId,
            })
            .then(response => {
                // this.$emit('e-new', response.data);
            })
            .catch(function (error) {         
                console.log(error);            
            });

            // Reset form
            this.videoId = '';
        },

        removeVideo(itemID){

            axios.delete(`/api/room/${this.room_hash}/video/${itemID}`)
            .then(response => {

            })
            .catch(function (error) {         
                console.log("Oh no! ", error);            
            });
        },
        
        saveNewVideo(v, i){                
            this.videos.push(v);            
        },
    }
}
</script>