<template>
    <div>
        <Spinner v-if="loading" class="m-auto"></Spinner>
        <v-map ref="map" :zoom="zoom" :center="center" class="map">
            <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"/>
        </v-map>
    </div>
</template>

<script>
    import Leaflet from "leaflet";

    export default {
        name: "PointIndex",
        data() {
            return {
                loading: false,
                zoom: 13,
                center: Leaflet.latLng(47.413220, -1.219482),
            }
        },
        mounted: function () {
            const map = this.$refs.map.mapObject;

            this.loading = true;
            this.$store.dispatch("loadPoints")
                .then((points) => {
                    this.loading = false;
                    points.forEach(function (point) {
                        Leaflet.marker(new Leaflet.LatLng(point.latitude, point.longitude))
                            .addTo(map)
                            .bindPopup(`Category: ${point.category.name}<br>Date update: ${point.updated_at.format('DD-MM-YYYY hh:mm:ss')}`);
                    });
                });
        },
    }
</script>

<style scoped>
    .map {
        height: 400px;
        width: 100%;
    }
</style>