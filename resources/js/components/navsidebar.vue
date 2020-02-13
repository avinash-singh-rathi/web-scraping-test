<template>
<div class="">

          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'home'}"> Dashboard</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'websites'}"> Websites</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'categories'}"> Categories</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'brands'}"> Brands</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'process'}"> Crawl</router-link>
              </li>
            </ul>
          </div>
</div>

</template>

<script>
export default {
}
</script>
