<template>
    <div class="videos">

        <div :class="{ 'd-none': hideVideo}" >
            <div id="player" class="w-100"></div>
        </div>
        
        <div v-if="hideVideo" class="card video-guide small mb-4 text-white-50">
            <div class="card-header">
                <h5 class="mb-0">Videos</h5>
            </div>
            <div class="card-footer">
                Use only the ID from the video URL. <br>
                It's the last part of the address: <br>
                <span class="text-monospace font-italic">https://www.youtube.com/watch?v=<span class="font-weight-bold text-light">abc123ABC456</span></span>
            </div>
        </div>

        <ul class="list-inline">
            <li v-for="video in videos" :key="video.id" class="d-flex align-items-center mb-1">
                <a v-if="video.url != selected" class="btn flex-fill text-capitalize text-info text-left" @click="sendPlayVideo(video.url)" title="Play this video in the room">
                     <img src="/images/icon-play.svg" class="pr-1" alt="Play" height="12">
                    {{video.title}}
                </a>
                <a  v-if="video.url == selected" class="btn flex-fill text-capitalize text-info text-left" :class="{ 'btn-outline-info shadow': video.url == selected }" @click="sendPauseVideo(video.url)" title="Pause this video">
                    <img src="/images/icon-pause.svg" class="pr-1" alt="Pause" height="10">
                    {{video.title}}</a>
                <a class="btn btn-sm text-danger" @click="removeVideo(video.id)" title="Remove this video">x</a>
            </li>            
            <li v-if="!videos.length">Add first video.</li>
        </ul>
            
        <hr>



        <div class="link-form row">
            <div class="form-group col-6">
                <input type="text" class="form-control form-control-sm" v-model="videoId" name="video_id" placeholder="Video ID">
            </div>
            <div class="form-group col-6">                
                <input type="text" class="form-control form-control-sm" v-model="videoTitle" name="video_title" placeholder="Title">
            </div>
        </div>

        <button @click="sendVideo" type="submit" class="btn btn-success btn-sm w-100">Add Video</button>

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
            videoTitle: '',
            hideVideo: true,
            selected: undefined,
            videos: []
        }
    },

    created() {
        /**
         * Gets all Videos from Laravel API
         */
        axios.get(`/api/room/${this.room_hash}/videos`)
            .then(response => {
                this.videos = response.data;
            });   
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
                let mappedIndex = this.videos.map( v => v.id ).indexOf(e.video.id);
                this.videos.splice(mappedIndex, 1); 
            })
            .listen('PlayVideo', e => {
                this.playVideo(e.videoUrl);
                this.hideVideo = false;
                this.selected = e.videoUrl;
            })
            .listen('PauseVideo', e => {
                this.pauseVideo(e.videoUrl);
                this.selected = undefined;
            });

        /**
         * Setup YouTube player 
         */    
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;

        // console.log(this.videos);

        window.onYouTubeIframeAPIReady = () => {
            player = new YT.Player('player', {
                height: '200',
                width: '300',
                playerVars: {
                    color: 'white',
                    // controls: 0,
                    disablekb: 0,
                    loop: 1,
                    // playlist: 'taJ60kskkns,FG0fTKAqZ5g',
                    modestbranding: 1
                },
                events: {
                    // 'onReady': window.onPlayerReady,
                    // 'onStateChange': window.onPlayerStateChange
                }
            });

        }

        window.onPlayerStart = function(vUrl) {
            // Play this video at 0 seconds
            player.loadVideoById(vUrl, 0);
        }

        window.onPlayerStop = function() {
            // console.log('stop');
            player.pauseVideo();
        }
    },
    
    methods: {

        sendPlayVideo(vUrl){

            axios.post(`/api/room/${this.room_hash}/play/${vUrl}`)
                .then(response => {
                    this.playVideo(vUrl);
                })
                .catch(function (error) {         
                    console.log("Oh no! ", error);            
                });
        },

        playVideo(vUrl){
            window.onPlayerStart(vUrl);
        },

        sendPauseVideo(vUrl){

            axios.post(`/api/room/${this.room_hash}/pause/${vUrl}`)
                .then(response => {
                    this.pauseVideo();
                })
                .catch(function (error) {         
                    console.log("Oh no! ", error);            
                });
        },

        pauseVideo(){
            window.onPlayerStop();
        },

        sendVideo() {

            if( this.videoId == '' || this.videoTitle == "" ){
                return;
            }

            axios.post('/api/videos', {
                room_hash: this.room_hash,
                url: this.videoId,
                title: this.videoTitle
            })
            .then(response => {
            })
            .catch(function (error) {         
                console.log(error);            
            });

            // Reset form
            this.videoId = '';
            this.videoTitle = '';
        },

        removeVideo(itemID){

            axios.delete(`/api/room/${this.room_hash}/video/${itemID}`)
            .then(response => {

            })
            .catch(function (error) {         
                console.log("Oh no! ", error);            
            });
        },
        
        saveNewVideo(v){                
            this.videos.push(v);            
        },
    }
}
</script>