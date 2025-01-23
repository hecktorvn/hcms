<template>
  <div class="cms-templates">
    <div class="p-5">
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
    </div>

    <div v-if="selectedTemplate && currentTemplate" class="flex h-full border">
      <div class="min-w-[300px] border-r p-5">
        <h1 class="text-xs">
          Template.: <b>{{ currentTemplate.name }}</b>
        </h1>
        <TemplateSections
          :sections="currentTemplate.sections"
          @change="showSection"
        />
      </div>
      <div class="grow">
        <TemplateSectionFields
          @save="saveSectionFields"
          :section="currentSection"
          :template="selectedTemplate"
          v-if="currentSection !== null"
          :fields="currentTemplate.sections[currentSection].fields"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, provide } from 'vue';
import { usePage } from '@inertiajs/vue3';

import TemplateSections from './TemplateSections.vue';
import TemplateSectionFields from './TemplateSectionFields.vue';
import axios from 'axios';

const page = usePage();
const saving = ref(false);
const currentSection = ref(null);
const selectedTemplate = ref(page.props.hcms.currentTemplate);

provide('saving', saving);

const emit = defineEmits('save:settings');

const templates = computed(() => page.props.hcms.templates);
const currentTemplate = computed(() => templates.value[selectedTemplate.value]);

provide('currentTemplate', currentTemplate);

const showSection = (index) => {
  currentSection.value = index;
};

const saveSectionFields = (fields) => {
  saving.value = true;

  axios
    .put(
      route('cms.template.update', {
        template: selectedTemplate.value,
        section: currentSection.value,
      }),
      fields,
    )
    .then(() => {
      emit('saved:settings', {
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
