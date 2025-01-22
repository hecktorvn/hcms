import ExampleComponent from "./components/ExampleComponent.vue";

export default {
  install(app) {
    app.component("example-component", ExampleComponent);
  },
};
