import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { VitePWA } from 'vite-plugin-pwa';
export default defineConfig({ plugins:[vue(), VitePWA({registerType:'autoUpdate', manifest:{name:'Footprints', short_name:'Footprints', display:'standalone', start_url:'/', theme_color:'#2457ff', background_color:'#ffffff'}})], server:{proxy:{'/api':'http://localhost:8000','/sanctum':'http://localhost:8000'}} });
