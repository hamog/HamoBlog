<div class="well well-sm">
    <div class="form-group">
        <div class="input-group input-group-md">
            <div class="icon-addon addon-md">
                <input type="text" placeholder="What are you looking for?" class="form-control" v-model="query">
            </div>
            <span class="input-group-btn">
                    <button class="btn btn-default" type="button" @click="search()" v-if="!loading">Search!</button>
                <button class="btn btn-default" type="button" disabled="disabled" v-if="loading">Searching...</button>
                </span>
        </div>
    </div>
</div>
<div class="alert alert-danger" role="alert" v-if="error">
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    @{{ error }}
</div>
<div id="posts" class="row list-group">
    <div class="item col-xs-4 col-lg-4" v-for="post in posts">
        <div class="thumbnail">
            <img class="group list-group-image img-thumbnail" width="100" height="100" :src="post.image_path" alt="@{{ post.title }}" />
            <div class="caption">
                <h4 class="group inner list-group-item-heading"><a href="/blog/@{{ post.slug }}">@{{ post.title }}</a></h4>
                <p class="group inner list-group-item-text">@{{ post.body }}</p>
                <hr>
                <p>@{{ post.visit }} visits. Published At @{{ post.published_at }}</p>
            </div>
        </div>
    </div>
</div>