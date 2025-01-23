import { usePage } from "@inertiajs/vue3";
import SectionsGrid from "./src/resources/js/components/SectionsGrid.vue";
import SectionsSidebar from "./src/resources/js/components/SectionsSidebar.vue";
import { wTrans } from "laravel-vue-i18n";
import Vue3ColorPicker from "vue3-colorpicker";
import "vue3-colorpicker/style.css";

export const hcms = (key, defaultValue) => {
    const hcms = usePage().props.hcms;
    const settings = hcms.settings[hcms.currentTemplate] ?? [];

    const [section, field] = key.split(".");
    const config = settings.find((item) => item.section === section)?.config ?? {};

    const value = config[field] ?? defaultValue;

    return wTrans(value.length ? value : defaultValue).value;
};

export default {
  install(app) {
    app
      .use(Vue3ColorPicker)
      .component("template-sections", SectionsGrid)
      .component("template-sections:sidebar", SectionsSidebar);

    app.config.globalProperties.$hcms = hcms;
  },
};
