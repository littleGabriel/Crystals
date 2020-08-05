/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import bsCustomFileInput from "bs-custom-file-input";

require('./bootstrap');

window.Vue = require('vue');



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Vue!'
    }
});

$('#renameModal').on('show.bs.modal', function (event) {
    var a = $(event.relatedTarget) // Button that triggered the modal
    var recipient = a.data('id') // Extract info from data-* attributes
    var file_name = a.data('name')
    var renameModal = $(this)
    renameModal.find('#id').val(recipient)
    renameModal.find('#fileNameInput').val(file_name)
})

$('#moveModal').on('show.bs.modal', function (event) {
    var a = $(event.relatedTarget)
    var recipient = a.data('id')
    $(this).find('#mvId').val(recipient)
})

function getShareUrl(){
    // this.submit();
    $.ajax({
        type:'post',
        url:'/home/share',
        data:$('#Share').serialize(),
        success:function(result){
            const input = document.createElement('input');
            document.body.appendChild(input);
            input.setAttribute('value', result);
            input.select();
            if (document.execCommand('copy')) {
                document.execCommand('copy');
                $('#myToast').toast('show');
            }
            document.body.removeChild(input);
        }
    });
}

$(document).ready(function(){
    $("#myToast").toast({
        delay: 3000
    });
    bsCustomFileInput.init();
});
