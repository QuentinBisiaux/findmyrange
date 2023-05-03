<template>
  <span
      class="cursor-pointer font-semibold"
      :title="`Joué : ${props.data.played}, Relancé : ${props.data.raised} fois, Limp : ${props.data.limped}`"
  >
    {{ hand }}
  </span>
</template>

<script setup>
import { defineProps, computed } from 'vue'

const props = defineProps({
  hand: {
    type: String,
    required: true,
  },
  data: {
    type: Object,
    required: true,
  }
});
</script>

<style scoped>
/* You can add TailwindCSS classes here to style the matrix */
</style>