import axios from 'axios';
import moment from 'moment';

export const index = () => {
    return new Promise(function (resolve, reject) {
        axios
            .get('/api/categories')
            .then(response => {
                let items = response.data.map(function (item) {
                    item.created_at = moment(item.created_at);
                    item.updated_at = moment(item.updated_at);

                    return item;
                });

                resolve(items);
            })
            .catch(error => {
                reject(error);
            })
    });
};

export const create = (name) => {
    return new Promise(function (resolve, reject) {
        axios
            .post('/api/categories', {
                name: name
            })
            .then(response => {
                const category = response.data;
                category.created_at = moment(category.created_at);
                category.updated_at = moment(category.updated_at);

                resolve(category);
            })
            .catch(error => {
                reject(error);
            })
    });
};

export const update = (category) => {
    return new Promise(function (resolve, reject) {
        axios
            .put('/api/categories/' + category.id, {
                name: category.name
            })
            .then(response => {
                const category = response.data;
                category.created_at = moment(category.created_at);
                category.updated_at = moment(category.updated_at);

                resolve(category);
            })
            .catch(error => {
                reject(error);
            })
    });
};
