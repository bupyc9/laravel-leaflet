<template>
    <div>
        <!--<Spinner v-if="loading" class="m-auto"/>-->
        <div>
            <div class="form-group">
                <label for="categories">Category</label>
                <select name="category_id" id="categories" v-model="category_id" class="form-control">
                    <option v-for="category in categories" :key="category.id" v-bind:value="category.id">
                        {{category.name}}
                    </option>
                </select>
            </div>
            <v-map ref="map" :zoom="zoom" :center="center" class="map" @click="addMarker">
                <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></v-tilelayer>
            </v-map>
            <button class="btn btn-primary mt-2" @click="add" :disabled="category_id === null || marker === null">Add</button>
        </div>
    </div>
</template>

<script>
    import {mapState} from "vuex";
    import Leaflet from "leaflet";
    import * as pointsApi from "../../api/points";

    export default {
        name: "PointCreate",
        data() {
            return {
                loading: false,
                category_id: null,
                zoom: 13,
                center: Leaflet.latLng(47.413220, -1.219482),
                marker: null,
            }
        },
        computed: mapState(["categories"]),
        mounted: function () {
            this.loading = true;
            this.$store.dispatch("loadCategories")
                .then((items) => {
                    this.loading = false;
                    this.category_id = items[0].id;
                });
        },
        methods: {
            add() {
                const latLng = this.marker.getLatLng();

                pointsApi
                    .create(latLng.lng, latLng.lat, this.category_id)
                    .then(point => {
                        this.$store.dispatch('addPoint', point);
                        this.$router.push({name: 'home'});
                    });
            },
            addMarker(e) {
                const map = this.$refs.map.mapObject;

                if (this.marker !== null) {
                    map.removeLayer(this.marker);
                }

                this.marker = new Leaflet.Marker(e.latlng).addTo(map);
            }
        },
    }
</script>

<style scoped>
    .map {
        height: 400px;
        width: 100%;
    }
</style>