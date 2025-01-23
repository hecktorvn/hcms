<template>
  <div class="relative">
    <input v-model="color" placeholder="#000000" :name="name" class="w-full" />
    <div class="absolute right-1 top-[.4rem]">
      <color-picker v-model:pureColor="color" format="hex" shape="circle" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";

const props = defineProps({
  name: String,
  value: String,
});

const color = ref(props.value);

watch(props.value, () => {
  color.value = props.value;
});
</script>
