// This file will be loaded automatically after installing the package.
// See: https://github.com/rapidez/rapidez/blob/master/resources/js/app.js
import { defineAsyncComponent } from 'vue'

document.addEventListener('vue:loaded', function (event) {
    const { vue } = event.detail
    vue.component('order-reminder-form', defineAsyncComponent(() => import('./components/Form.vue')))
    vue.component('order-reminder-list', defineAsyncComponent(() => import('./components/List.vue')))
    vue.component('order-reminder-add-to-cart', defineAsyncComponent(() => import('./components/AddMultipleToCart.vue')))
})
