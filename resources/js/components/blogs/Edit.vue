<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Update blog</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="form-group">
                        <label class="control-label">Title</label>
                        <input type="text" v-model="blog.title" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <textarea v-model="blog.description" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            axios.get('/api/blogitems/' + id)
                .then(function (resp) {
                    console.log(resp)
                    app.blog = resp.data;
                })
                .catch(function () {
                    // alert("Could not load your blog")
                });
        },
        data: function () {
            return {
                blog: {
                    id: 0,
                    title: '',
                    description: ''
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;

                axios.put('/api/blogitems/' + app.blog.id, {title: app.blog.title, description: app.blog.description})
                    .then(function (resp) {
                        console.log(resp)
                        alert("Update successfully");
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not update your blog");
                    });
            }
        }
    }
</script>
