<template>
    <div class="videos">

        <div :class="{ 'd-none': hideVideo, 'full-screen': videoSize}" >
            <div id="player" class="w-100"></div>
        </div>
        
        <div v-if="hideVideo" class="card video-guide small mb-4 text-white-50">
            <div class="card-header">
                <h5 class="mb-0">Videos</h5>
            </div>
            <div class="card-body">
                Simply copy YouTube video URL from the address bar, paste it in the field below and add a fancy title. 
            </div>
        </div>

        <div v-if="!hideVideo" class="card mb-2">
            <div class="card-body p-2">
                <a v-if="!videoSize" @click="fullScreen" class="btn btn-primary btn-sm" title="Full screen"><img src="/images/icon-full-screen.svg" alt="Full screen" height="16"></a>
                <a v-if="videoSize" @click="smallScreen" class="btn btn-primary btn-sm" title="Exit full screen"><img src="/images/icon-small-screen.svg" alt="Exit full screen" height="16"></a>
            </div>
        </div>

        <ul class="list-inline">
            <li v-for="(video, index) in videos" :key="video.id" class="d-flex align-items-center mb-1">
                <a v-if="video.url != selected" class="btn flex-fill text-capitalize text-info text-left" @click="sendPlayVideo(video.url), currentVideo = index" title="Play this video in the room">
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
                <input type="text" class="form-control form-control-sm" v-model="videoAddress" name="video_id" placeholder="Video address">
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
            videoAddress: '',
            videoTitle: '',
            hideVideo: true,
            selected: undefined,
            currentVideo: 0,
            videoSize: 0,
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
            })
            .listen('PlayerStatus', e => {
                this.videoSize = e.playerStatus;
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
                    modestbranding: 1,
                    fs: 0,
                    autoplay: 0,
                    cc_lang_pref: 0,
                    showinfo: 0
                },
                events: {
                    // 'onReady': window.onPlayerReady,
                    'onStateChange': window.onPlayerStateChange
                }
            });

        }

        window.onPlayerStateChange = (state) => {

            // Finished playing
            if(state.data === 0){

                // Next video or loop to start of the video list
                this.currentVideo < this.videos.length -1 ? this.currentVideo++ : this.currentVideo = 0;
                this.selected = this.videos[this.currentVideo]['url'];
                player.loadVideoById(this.selected, 0);
            }
        },

        window.onPlayerStart = function(vUrl) {
            // Play this video at 0 seconds
            // player;
            player.loadVideoById(vUrl).seekTo(0);
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

            if( this.videoAddress == '' || this.videoTitle == "" ){
                return;
            }

            // Get only video ID
            var videoId = this.videoAddress.split('v=')[1];
            var ampersandPosition = videoId.indexOf('&');
            if(ampersandPosition != -1) {
                videoId = videoId.substring(0, ampersandPosition);
            }

            // Strip out special characters
            videoId.replace(/[^a-zA-Z ]/g, "");

            axios.post('/api/videos', {
                room_hash: this.room_hash,
                url: videoId,
                title: this.videoTitle
            })
            .then(response => {
            })
            .catch(function (error) {         
                console.log(error);            
            });

            // Reset form
            this.videoAddress = '';
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

        fullScreen() {
            this.videoSize = 1;
            this.sendPlayerStatus();
        },

        smallScreen() {
            this.videoSize = 0;
            this.sendPlayerStatus();
        },

        sendPlayerStatus(){

            axios.post(`/api/room/${this.room_hash}/player`, {
                videoSize: this.videoSize
            })
            .then(response => {
                // console.log(response);
            })
            .catch(function (error) {         
                console.log(error);            
            });
        }
    }
}
</script>