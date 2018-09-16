<template>
    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add category</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category-name">Name</label>
                        <input type="text" maxlength="255" id="category-name" class="form-control"
                               placeholder="Enter name" name="name" v-model.trim="categoryName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="add" :disabled="categoryName.length === 0">
                        Add
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
        data() {
            return {
                categoryName: '',
            }
        },
        methods: {
            add() {
                const self = this;

                categoriesApi
                    .create(this.categoryName)
                    .then(category => {
                        self.$store.dispatch('addCategory', category);
                        self.categoryName = '';
                    });
            },
        }
    }
</script>

<style scoped>

</style>