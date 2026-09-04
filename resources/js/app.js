/*
This file will be used by jetstream to add alpine.js. This file must exist to install jetstream successfully.
You can remove it if you don't want to use jetstream.
*/

import Vue from 'vue/dist/vue.js';

require('./common');
if(document.getElementById('app')){
  Vue.prototype.$LangFlag = ["ua", "pl", "tr", "ru", "by", "lv", "lt", "de", "kz"];
  Vue.component('Phone', require('./components/Phone.vue').default);
    new Vue({
        el:'#app'
      })
}

