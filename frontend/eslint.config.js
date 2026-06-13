import js from '@eslint/js'; import vue from 'eslint-plugin-vue';
export default [js.configs.recommended, ...vue.configs['flat/recommended'], {files:['src/**/*.{js,vue}'], languageOptions:{ecmaVersion:'latest', sourceType:'module'}}];
