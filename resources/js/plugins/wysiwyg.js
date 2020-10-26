import Vue from 'vue';
import wysiwyg from "vue-wysiwyg";
Vue.use(wysiwyg, {
    // { [module]: boolean (set true to hide) }
    hideModules: { 
        "table": true,
        "image": true,
        "code": true,
        "link": true,
    },


    // limit content height if you wish. If not set, editor size will grow with content.
    maxHeight: "1000px",

    // set to 'true' this will insert plain text without styling when you paste something into the editor.
    forcePlainTextOnPaste: true,

    // specify editor locale, if you don't specify this, the editor will default to english.
    locale: 'en'
});
