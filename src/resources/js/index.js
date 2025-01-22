import { usePage } from '@inertiajs/vue3';
import SectionsGrid from './components/SectionsGrid.vue';
import SectionsSidebar from './components/SectionsSidebar.vue';

export default {
  install(app) {
    app.component('template-sections', SectionsGrid);
    app.component('template-sections:sidebar', SectionsSidebar);

    app.config.globalProperties.$hcms = (key) => {
      const hcms = usePage().props.hcms;
      const settings = hcms.settings[hcms.currentTemplate] ?? {};

      const [section, field] = key.split('.');
      const config =
        settings.find((item) => item.section === section)?.config ?? {};

      return config[field] ?? '';
    };
  },
};
