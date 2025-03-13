<template>
  <fieldset :disabled="saving">
    <form ref="form" :class="`grid grid-cols-${cols} p-5`">
      <template v-for="(field, key) in fields">
        <div
          class="flex flex-col p-2"
          :style="`grid-column: span ${field.cols ?? 1};`"
        >
          <label class="text-xs">{{ $t(field.label) }}</label>
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

  <div class="flex w-full justify-end p-5 pt-0 gap-3 text-xs">
    <button @click="emit('cancel')" class="p-3 px-5 border text-gray-500">
      {{ $t("Cancel") }}
    </button>
    <button
      @click="save"
      :disabled="saving"
      class="rounded-sm bg-blue-500 p-3 px-5 text-white"
    >
      {{ $t(saving ? "Saving..." : "Save") }}
    </button>
  </div>
</template>

<script setup>
import { computed, inject, ref, getCurrentInstance } from "vue";
import InputPicker from "./InputPicker.vue";

const page = getCurrentInstance().appContext.config.globalProperties.$page;

const saving = inject("saving");
const emit = defineEmits(["save", "cancel"]);

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
  const settings = page.props.hcms.settings[props.template] ?? [];

  const currentSection = settings.find(
    ({ section }) => section === props.section
  );

  return currentSection?.config ?? {};
});

const save = () => {
  const formData = new FormData(form.value);
  const settings = page.props.hcms.settings[props.template] ?? [];

  const currentSection =
    settings.find(({ section }) => section === props.section) ?? {};

  if (!currentSection.config) {
    if(typeof page.props.hcms.settings[props.template] !== 'Object') {
      page.props.hcms.settings[props.template] = [];
    }

    page.props.hcms.settings[props.template].push({
      section: props.section,
      config: Object.fromEntries(formData),
    });
  }

  currentSection.config = Object.fromEntries(formData);
  emit("save", currentSection.config);
};

const getFieldComponent = (field) => {
  switch (field.type) {
    case "text":
      return "input";
    case "picker":
    case "color":
      return InputPicker;
    default:
      return field.type;
  }
};
</script>
