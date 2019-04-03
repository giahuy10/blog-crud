<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createBlog'}" class="btn btn-success">Create new Blog</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Blogs list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Title</th>

                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(blog, index) in blogs" :key="index">
                        <td><router-link :to="{name: 'showblog', params: {id: blog.id}}" >{{ blog.title }}</router-link></td>

                        <td>
                            <router-link :to="{name: 'editblog', params: {id: blog.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(blog.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                blogs: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/blogitems')
                .then(function (resp) {
                    console.log(resp)
                    app.blogs = resp.data.data.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load blogs");
                });
        },
        methods: {
            changeStatus (id) {

            },
            deleteEntry (id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/blogitems/' + id)
                        .then(function (resp) {
                            app.blogs.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete blog");
                        });
                }
            }
        }
    }
</script>
