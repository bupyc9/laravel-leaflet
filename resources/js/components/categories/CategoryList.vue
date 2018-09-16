<template>
    <div>
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#category-create">Add
        </button>
        <Spinner v-if="loading" class="m-auto"></Spinner>
        <table class="table" v-if="categories.length > 0">
            <thead>
            <tr>
                <th>#</th>
                <th>Date create</th>
                <th>Date update</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="category in categories" :key="category.id">
                <th scope="row">{{category.id}}</th>
                <td>{{category.created_at.format("DD-MM-YYYY hh:mm:ss")}}</td>
                <td>{{category.updated_at.format("DD-MM-YYYY hh:mm::ss")}}</td>
                <td>{{category.name}}</td>
            </tr>
            </tbody>
        </table>
        <CategoryCreate id="category-create" />
    </div>
</template>

<script>
    import CategoryCreate from "./CategoryCreate";
    import {mapState} from "vuex";

    export default {
        name: "CategoryList",
        components: {CategoryCreate},
        data() {
            return {
                loading: false,
            }
        },
        computed: mapState(["categories"]),
        mounted: function () {
            this.loading = true;
            this.$store.dispatch("loadCategories")
                .then(() => {
                    this.loading = false;
                });
        },
    }
</script>

<style scoped>

</style>