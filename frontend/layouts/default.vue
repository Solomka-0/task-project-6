<template>
  <div>
    <Header/>
    <div class="default-layout page-content min-h-[80vh]">
      <slot/>
    </div>
    <Footer/>
    <Loader/>
    <Notices/>
  </div>
</template>

<script setup lang="ts">
import Header from '~/src/components/Header/Header.vue'
import Footer from "~/src/components/Footer/Footer.vue";
import Loader from "~/src/components/Loader/Loader.vue";
import Notices from "~/src/components/Notices/Notices.vue";
</script>