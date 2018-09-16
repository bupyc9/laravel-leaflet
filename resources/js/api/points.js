import axios from 'axios';
import moment from 'moment';

export const index = () => {
    return new Promise(function (resolve, reject) {
        axios
            .get('/api/points')
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

export const create = (longitude, latitude, category_id) => {
    return new Promise(function (resolve, reject) {
        axios
            .post('/api/points', {
                longitude: longitude,
                latitude: latitude,
                category_id: category_id,
            })
            .then(response => {
                const point = response.data;
                point.created_at = moment(point.created_at);
                point.updated_at = moment(point.updated_at);

                resolve(point);
            })
            .catch(error => {
                reject(error);
            })
    });
};