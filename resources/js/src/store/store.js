import { createStore } from 'vuex';


export default createStore({
    state: {
        authenticated: false,
        token: null,
    },
    mutations: {
        login(state, token) {
            state.authenticated = true;
            state.token = token;
        },
        logout(state) {
            state.authenticated = false;
            state.token = null;
        },
    },
});
