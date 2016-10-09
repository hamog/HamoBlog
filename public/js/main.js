new Vue({

    el: 'body',

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
                // If there was an error set the error message, if not fill the posts array.
                response.body.error ? this.error = response.body.error : this.posts = response.body;
            // The request is finished, change the loading to false again.
            this.loading = false;
            // Clear the query.
            this.query = '';
        });
        }
    }

});