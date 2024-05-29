<template>
  <div class="default-layout page-content min-h-[90vh]">
    <slot/>
  </div>
  <Footer/>
  <Loader/>
  <Notices/>
</template>

<script setup lang="ts">
import Loader from "~/src/components/Loader/Loader.vue";
import Notices from "~/src/components/Notices/Notices.vue";
import Footer from "~/src/components/Footer/Footer.vue";
</script>