<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update category</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category-name">Name</label>
                        <input type="text" maxlength="255" id="category-name" class="form-control"
                               placeholder="Enter name" name="name" v-model.trim="category.name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="edit" :disabled="category.name.length === 0">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import * as categoriesApi from '../../api/categories';

    export default {
        name: "CategoryCreate",
        props: ['category'],
        methods: {
            edit() {
                const self = this;

                categoriesApi
                    .update(this.category)
                    .then(category => {
                        self.$store.dispatch('updateCategory', category);
                        window.$(self.$el).modal("toggle");
                    });
            },
        }
    }
</script>

<style scoped>

</style>