<template>
    <nav class="navbar navbar-expand navbar-light bg-light">
        <router-link class="navbar-brand" to="/">BAMRI</router-link>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <router-link class="nav-link" to="/bus">Bus</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/driver">Driver</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="/order">Order</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>