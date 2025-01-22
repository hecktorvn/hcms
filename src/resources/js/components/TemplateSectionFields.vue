<template>
  <fieldset :disabled="saving">
    <form ref="form" :class="`grid grid-cols-${cols} p-5`">
      <template v-for="(field, key) in fields">
        <div
          class="flex flex-col p-2"
          :style="`grid-column: span ${field.cols ?? 1};`"
        >
          <label class="text-xs">{{ field.label }}</label>
          <component
            :name="key"
            :is="getFieldComponent(field)"
            v-bind="field.attributes"
            :value="values[key]"
          />
        </div>
      </template>
    </form>
  </fieldset>

  <div class="flex w-full justify-end p-5 pt-0">
    <button
      @click="save"
      :disabled="saving"
      class="rounded-sm bg-blue-500 p-3 px-5 text-white"
    >
      {{ saving ? 'Saving...' : 'Save' }}
    </button>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, inject, ref } from 'vue';

const page = usePage();
const saving = inject('saving');
const emit = defineEmits(['save']);

const props = defineProps({
  template: String | Number,
  section: String | Number,
  cols: {
    type: Number,
    default: 3,
  },
  fields: {
    type: Object,
    required: true,
  },
});

const form = ref(null);
const values = computed(() => {
  const settings = page.props.hcms.settings[props.template];

  const currentSection = settings.find(
    ({ section }) => section === props.section,
  );

  return currentSection?.config ?? {};
});

const save = () => {
  const formData = new FormData(form.value);
  const settings = page.props.hcms.settings[props.template];

  const currentSection = settings.find(
    ({ section }) => section === props.section,
  );

  currentSection.config = Object.fromEntries(formData);
  emit('save', currentSection.config);
};

const getFieldComponent = (field) => {
  switch (field.type) {
    case 'text':
      return 'input';
    case 'textarea':
      return 'textarea';
    case 'select':
      return 'select';
    default:
      return 'input';
  }
};
</script>
