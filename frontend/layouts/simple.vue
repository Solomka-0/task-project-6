<template>
  <div class="bg-[#131313]">
    <div class="default-layout">
      <slot/>
    </div>
    <Loader/>
    <Notices/>
  </div>
</template>

<script setup lang="ts">
import Loader from "~/src/components/Loader/Loader.vue";
import Notices from "~/src/components/Notices/Notices.vue";
</script>