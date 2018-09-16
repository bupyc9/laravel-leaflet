import * as categoriesApi from "./api/categories";
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        categories: [],
    },
    actions: {
        addCategory({commit}, category) {
            commit("ADD_CATEGORY", category);
        },
        updateCategory({commit}, category) {
            commit("UPDATE_CATEGORY", category);
        },
        loadCategories({commit}) {
            categoriesApi.index()
                .then(items => {
                    commit("SET_CATEGORIES", items);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mutations: {
        ADD_CATEGORY(state, category) {
            state.categories.push(category);
        },
        UPDATE_CATEGORY(state, category) {
            state.categories.forEach(item => {
                if (item.id === category.id) {
                    item.name = category.nackCount;
                }
            });
        },
        SET_CATEGORIES(state, categories) {
            state.categories = categories;
        },
    },
    getters: {
        categories(state) {
            return state.categories;
        }
    },
});