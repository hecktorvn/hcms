import SectionsGrid from "./src/resources/js/components/SectionsGrid.vue";
import SectionsSidebar from "./src/resources/js/components/SectionsSidebar.vue";
import { trans } from "laravel-vue-i18n";
import Vue3ColorPicker from "vue3-colorpicker";
import "vue3-colorpicker/style.css";
import { getCurrentInstance, ref } from "vue";

const hcmsInstance = ref(null);

export const hcms = (key, defaultValue) => {
  if(hcmsInstance.value) {
    return hcmsInstance.value(key, defaultValue);
  }

  return getCurrentInstance().appContext.config.globalProperties.$hcms(key, defaultValue);
};

const translate = (config, key, defaultValue) => {
  const {currentTemplate} = config;
  const settings = config.settings[currentTemplate] ?? [];

  const [section, field] = key.split(".");
  config = settings.find((item) => item.section === section)?.config ?? {};

  const value = config[field] ?? defaultValue;
  return trans(value.length ? value : defaultValue) || defaultValue;
};

export default {
  install(app) {
    app
      .use(Vue3ColorPicker)
      .component("template-sections", SectionsGrid)
      .component("template-sections:sidebar", SectionsSidebar);
      
    hcmsInstance.value = (key, defaultValue) => {
      const pageProps = app.config.globalProperties.$page.props;
      return translate(pageProps.hcms, key, defaultValue);
    };

    app.config.globalProperties.$hcms = hcmsInstance.value;
  },
};
