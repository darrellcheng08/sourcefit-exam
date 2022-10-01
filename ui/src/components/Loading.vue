<template>
    <div
        v-show="value"
        class="v-page_loading v-page_loading--absolute theme--dark"
        :class="value ? 'v-page_loading--active' : ''"
        style="z-index: 1000;"
    >
        <div
            class="v-page_loading__scrim"
            :style="{
                'background-color': $vuetify.dark
                    ? 'rgb(33, 33, 33)'
                    : 'rgb(255,255,255)',
                'border-color': $vuetify.dark
                    ? 'rgb(33, 33, 33)'
                    : 'rgb(255,255,255)'
            }"
        ></div>
        <div class="v-page_loading__content">
            <slot name="content">
                <v-progress-circular
                    indeterminate
                    :color="color"
                ></v-progress-circular>
                <span :class="`ml-2 ${color}--text`">Please Wait</span>
            </slot>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        value: {
            type: Boolean,
            default: false
        },
        color: {
            type: String,
            default: "primary"
        }
    },
    data() {
        return {};
    },
    computed: {},
    methods: {},
    watch: {}
};
</script>

<style scoped>
.page-loading {
    justify-content: center;
    position: absolute !important;
    height: 100vh;
    align-items: center;
    display: flex;
    width: 100%;
    background: #eeeeee;
    z-index: 20 !important;
}
.page-loading__dark {
    justify-content: center;
    position: absolute !important;
    height: 100vh;
    align-items: center;
    display: flex;
    width: 100%;
    background: #252525;
    z-index: 20 !important;
}
.v-page_loading {
    align-items: center;
    border-radius: inherit;
    display: flex;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
    transition: 0.3s cubic-bezier(0.25, 0.8, 0.5, 1), z-index 1ms;
}
.theme--dark.v-page_loading {
    color: #fff;
}
.v-page_loading--active {
    pointer-events: auto;
}
.v-page_loading--absolute {
    position: absolute;
}

.v-page_loading__content {
    position: relative;
}
.v-page_loading__scrim {
    border-radius: inherit;
    bottom: 0;
    height: 100%;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
    transition: inherit;
    width: 100%;
    will-change: opacity;
}
</style>
