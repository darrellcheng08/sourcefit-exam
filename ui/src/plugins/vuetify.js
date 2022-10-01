import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';

Vue.use(Vuetify);

export default new Vuetify({
    icons: {
        iconfont: 'mdi'
    },
    theme: {
        options: {
            customProperties: true
        },
        themes: {
            light: {
                primary: '#1976D2',
                secondary: '#304156',
                accent: '#11cdef',
                tertiary: '#fcb326',
                quaternary: '#c9342f',
                error: '#FF5252',
                warning: '#ff5722',
                danger: '#f44336',
                info: '#3f51b5',
                success: '#28ad74',
                black: '#000',
                border: '#cecece',
                border1: '#e0e0e0',
                hovered: "#f5f5f5",
                disabled: "#ababab",
                selected: "#ffeac1",
                orange: "#f39000",
                glass: '#f4f4f4'
            },
            dark: {
                primary: '#1976D2',
                secondary: '#304156',
                accent: '#11cdef',
                error: '#FF5252',
                warning: '#ff5722',
                danger: '#f44336',
                info: '#3f51b5',
                success: '#28ad74',
                black: '#fff',
                border: '#5b5b5b',
                border1: '#5d5d5d',
                hovered: "#333",
                disabled: "#ababab",
                selected: "#6c511d",
                orange: "#f39000",
            }
        }
    }
});
