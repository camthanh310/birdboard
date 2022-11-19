import './bootstrap';

import { createApp } from 'vue';

import ThemeSwitcher from '@/components/ThemeSwitcher.vue'

const app = createApp({})

app.component('ThemeSwitcher', ThemeSwitcher)
app.mount('#app')