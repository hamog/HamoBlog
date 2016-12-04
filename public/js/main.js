new Vue({

    el: '#app',

    data: {
        posts: [],
        loading: false,
        error: false,
        query: ''
    },

    methods: {
        search: function() {
            // Clear the error message.
            this.error = '';
            // Empty the posts array so we can fill it with the new posts.
            this.posts = [];
            // Set the loading property to true, this will display the "Searching..." button.
            this.loading = true;

            // Making a get request to our API and passing the query to it.
            this.$http.get('/search?q=' + this.query).then((response) => {
                // success callback
                var res = JSON.parse(response.body);
                // If there was an error set the error message, if not fill the posts array.
                (res.error) ? (this.error = res.error) : (this.posts = res);
                // The request is finished, change the loading to false again.
                this.loading = false;
                // Clear the query.
                this.query = '';
            }, (response) => {
                // error callback
                console.log(response);
            });
        }
    }

});