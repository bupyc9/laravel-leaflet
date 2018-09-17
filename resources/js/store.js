import * as categoriesApi from "./api/categories";
import * as pointsApi from "./api/points";
import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        categories: [],
        points: [],
    },
    actions: {
        addCategory({commit}, category) {
            commit("ADD_CATEGORY", category);
        },
        updateCategory({commit}, category) {
            commit("UPDATE_CATEGORY", category);
        },
        loadCategories({commit}) {
            return new Promise(function (resolve, reject) {
                categoriesApi.index()
                    .then(items => {
                        commit("SET_CATEGORIES", items);
                        resolve(items);
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    });
            });
        },
        addPoint({commit}, point) {
            commit("ADD_POINT", point);
        },
        async loadPoints({commit}, categoryId = null) {
            return new Promise(function (resolve, reject) {
                pointsApi.index(categoryId)
                    .then(items => {
                        commit("SET_POINTS", items);
                        resolve(items);
                    })
                    .catch(error => {
                        console.log(error);
                        reject(error);
                    });
            });
        },
    },
    mutations: {
        ADD_CATEGORY(state, category) {
            state.categories.push(category);
        },
        UPDATE_CATEGORY(state, category) {
            state.categories.forEach(item => {
                if (item.id === category.id) {
                    item.name = category.name;
                }
            });
        },
        SET_CATEGORIES(state, categories) {
            state.categories = categories;
        },
        ADD_POINT(state, point) {
            state.points.push(point);
        },
        SET_POINTS(state, points) {
            state.points = points;
        },
    },
    getters: {
        categories(state) {
            return state.categories;
        },
        points(state) {
            return state.points;
        }
    },
});