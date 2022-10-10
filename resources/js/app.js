require('./bootstrap');
require('./theme');

window.Vue = require('vue');

Vue.component('chat-box', require('./components/Chat.vue').default);
Vue.component('link-box', require('./components/Links.vue').default);
Vue.component('video-box', require('./components/Videos.vue').default);

// Pusher.logToConsole = true;

const app = new Vue({
    el: '#app',
});
