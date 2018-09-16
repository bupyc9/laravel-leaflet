<template>
    <div>
        <Spinner v-if="loading" class="m-auto"></Spinner>
        <div class="form-group">
            <label for="categories">Category</label>
            <select name="category_id" id="categories" v-model="category_id" class="form-control" @change="applyFilter">
                <option value="">All</option>
                <option v-for="category in categories" :key="category.id" v-bind:value="category.id">
                    {{category.name}}
                </option>
            </select>
        </div>
        <v-map ref="map" :zoom="zoom" :center="center" class="map">
            <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"/>
        </v-map>
    </div>
</template>

<script>
    import Leaflet from "leaflet";
    import {mapState} from "vuex";

    export default {
        name: "PointIndex",
        data() {
            return {
                loading: false,
                zoom: 13,
                center: Leaflet.latLng(47.413220, -1.219482),
                category_id: null,
                markers: Leaflet.layerGroup(),
            }
        },
        computed: mapState(["categories"]),
        mounted: function () {
            this.$store.dispatch("loadCategories");
            this.loadPoints();
        },
        methods: {
            loadPoints: function () {
                const map = this.$refs.map.mapObject;
                const self = this;

                this.$store.dispatch("loadPoints", this.category_id)
                    .then((points) => {
                        points.forEach(function (point) {
                            const marker = Leaflet.marker(new Leaflet.LatLng(point.latitude, point.longitude))
                                .bindPopup(`Category: ${point.category.name}<br>Date update: ${point.updated_at.format('DD-MM-YYYY hh:mm:ss')}`);

                            self.markers.addLayer(marker);
                        });

                        this.markers.addTo(map);
                    });
            },
            applyFilter() {
                this.markers.clearLayers();
                this.loadPoints();
            }
        }
    }
</script>

<style scoped>
    .map {
        height: 400px;
        width: 100%;
    }
</style>