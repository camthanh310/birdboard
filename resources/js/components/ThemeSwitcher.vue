<template>
    <div class="mr-8 flex items-center">
        <button
            class="rounded-full w-4 h-4 bg-card border mr-4"
            v-for="(color, theme) in themes"
            :class="{ 'border-pink-400' : theme === selectedTheme }"
            :style="{ backgroundColor: color }"
            @click="toggleTheme(theme)"
        >
        </button>
    </div>
</template>

<script>
export default {
    name: 'ThemeSwitcher',
    data() {
        return {
            themes: {
                'theme-light': '#f5f6f9',
                'theme-dark': '#222222'
            },
            selectedTheme: 'theme-light'
        }
    },
    created() {
        this.selectedTheme = localStorage.getItem('theme') || 'theme-light'
    },
    methods: {
        toggleTheme(theme) {
            this.selectedTheme = theme
        }
    },
    watch: {
        selectedTheme(theme) {
            document.body.className = document.body.className.replace(/theme-\w+/, theme)
            localStorage.setItem('theme', theme)
        }
    }
}
</script>