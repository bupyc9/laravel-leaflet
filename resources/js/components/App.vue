<template>
    <div class="container">
        <header class="py-3">
            <ul class="nav">
                <li class="nav-item">
                    <router-link :to="{name: 'home'}" class="nav-link">Home</router-link>
                </li>
            </ul>
        </header>
        <main role="main">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    export default {
        name: "App"
    }
</script>

<style scoped>

</style>