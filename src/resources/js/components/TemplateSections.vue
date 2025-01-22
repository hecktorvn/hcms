<template>
  <div class="grid gap-3 pt-2">
    <div
      role="button"
      @click="() => selectSection(index)"
      v-for="(section, index) in sections"
      :class="{ 'bg-gray-50 border-blue-500': index === currentSection }"
      class="p-3 border rounded-sm px-4"
    >
      <h2>{{ section.name }}</h2>
    </div>
  </div>
</template>
<script setup>
import { ref, watch } from "vue";

const currentSection = ref(null);
const emit = defineEmits(["change"]);
const props = defineProps({
  sections: {
    type: Array,
    required: true,
  },
});

const selectSection = (index) => {
  currentSection.value = index;
  emit("change", index);
};

watch(
  () => props.sections,
  () => selectSection(null)
);
</script>
