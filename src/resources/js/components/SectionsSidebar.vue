<template>
  <button
    v-if="!showSettings"
    style="z-index: 500"
    @click="showSettings = !showSettings"
    class="fixed left-0 top-5 rounded-r-md bg-gray-500 p-2 px-3 text-xs text-white shadow"
  >
    {{ $t("Edit") }}
  </button>
  <div
    v-show="showSettings"
    style="z-index: 500"
    class="cms-templates fixed left-0 top-0 h-screen bg-white shadow"
  >
    <div class="flex justify-between gap-5 p-5">
      <div class="flex gap-4 divide-x">
        <select v-model="selectedTemplate" placeholder="Selecione um template">
          <option value="">Selecione um Template</option>
          <template v-for="template in templates" :key="template.slug">
            <option
              :value="template.slug"
              :selected="template.slug === selectedTemplate"
            >
              {{ template.name }}
            </option>
          </template>
        </select>
      </div>

      <button
        class="rounded-md border px-3 py-2 text-xs"
        @click="showSettings = !showSettings"
      >
        {{ $t("Close") }}
      </button>
    </div>

    <div v-if="currentTemplate" class="flex h-full border-t">
      <div class="w-full min-w-80 p-5" :class="{ 'border-r': currentSection }">
        <h1 class="text-xs">
          Template.: <b>{{ currentTemplate.name }}</b>
        </h1>
        <TemplateSections
          :sections="currentTemplate.sections"
          @change="showSection"
        />
      </div>
      <div class="w-screen max-w-[400px] grow" v-if="currentSection !== null">
        <TemplateSectionFields
          @save="saveSectionFields"
          @cancel="showSection(null)"
          :section="currentSection"
          :template="selectedTemplate"
          :fields="currentTemplate.sections[currentSection].fields"
          :cols="currentTemplate.sections[currentSection]?.cols ?? 1"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, provide } from "vue";
import { usePage } from "@inertiajs/vue3";

import TemplateSections from "./TemplateSections.vue";
import TemplateSectionFields from "./TemplateSectionFields.vue";
import axios from "axios";

const page = usePage();
const saving = ref(false);
const showSettings = ref(false);
const currentSection = ref(null);
const selectedTemplate = ref(page.props.hcms.currentTemplate);

provide("saving", saving);

const emit = defineEmits("save:settings");

const templates = computed(() => page.props.hcms.templates);
const currentTemplate = computed(() => templates.value[selectedTemplate.value]);

provide("currentTemplate", currentTemplate);

const showSection = (index) => {
  currentSection.value = index;
};

const saveSectionFields = (fields) => {
  saving.value = true;

  axios
    .put(
      route("cms.template.update", {
        template: selectedTemplate.value,
        section: currentSection.value,
      }),
      fields
    )
    .then(() => {
      emit("saved:settings", {
        fields,
        section: currentSection.value,
        selectedTemplate: selectedTemplate.value,
      });
    })
    .finally(() => {
      saving.value = false;
    });
};
</script>
