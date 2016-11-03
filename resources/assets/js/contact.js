
// import FormError component
import FormError from './components/ContactFormError.vue';

// get csrf token
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

// instantiate a new Vue instance
new Vue({
    // mount Vue to .container
    el: 'body',

    // define components
    components: {
        FormError,
    },

    data: {
        contact: {
            name: '',
            email: '',
            message: ''
        },

        submitted: false,

        // array to hold form errors
        errors: [],
    },

    methods: {
        createContact() {
            let contact = this.contact;

            this.$http.contact('contact-me', contact).then(function(response) {
                // form submission successful, reset contact data and set submitted to true
                this.contact = {
                    name: '',
                    email: '',
                    message: ''
                };

                // clear previous form errors
                this.$set('errors', '');

                this.submitted = true;
            }, function(response) {
                // form submission failed, pass form  errors to errors array
                this.$set('errors', response.data);
            });
        }
    }
});