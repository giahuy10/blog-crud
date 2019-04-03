<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Back</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Create blog</div>
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
                        <button class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        data: function () {
            return {
                blog: {
                    title: '',
                    description: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                axios.post('/api/blogitems/', this.blog)
                    .then(function (resp) {
                        console.log(resp)
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your blog");
                    });
            }
        }
    }
</script>
