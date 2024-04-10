<template>
    <div class="container mt-5">
        <h1>Login</h1>
        <form @submit.prevent="login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" v-model="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" class="form-control" id="password" v-model="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        login() {
            axios.post('http://localhost:89/api/login', {
                email: this.email,
                password: this.password
            })
                .then(response => {
                    const token = response.data.data.token;

                    this.$store.commit('login', token);
                    this.$router.push('/contacts');
                })
                .catch(error => {
                    console.error('Ошибка: ', error);
                });
        }
    }
};
</script>

<style scoped>

</style>
