<template>
    <div class="container mt-5">
        <h1>Профиль</h1>
        <div class="card mt-3">
            <div class="card-body">
                <div v-if="!editMode">
                    <p class="card-text"><strong>Имя:</strong> <span @click="editMode = true">{{ profile.name }}</span></p>
                    <p class="card-text"><strong>Фамилия:</strong> <span @click="editMode = true">{{ profile.surname }}</span></p>
                    <p class="card-text"><strong>Email:</strong> <span @click="editMode = true">{{ profile.email }}</span></p>
                    <p class="card-text"><strong>Телефон:</strong> <span @click="editMode = true">{{ profile.phone }}</span></p>
                    <button class="btn btn-primary" @click="editMode = true">Редактировать профиль</button>
                </div>
                <div v-else>
                    <form @submit.prevent="updateProfile">
                        <div class="mb-3">
                            <label for="name" class="form-label">Имя:</label>
                            <input type="text" id="name" class="form-control" v-model="updatedProfile.name">
                        </div>
                        <div class="mb-3">
                            <label for="surname" class="form-label">Фамилия:</label>
                            <input type="text" id="surname" class="form-control" v-model="updatedProfile.surname">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" class="form-control" v-model="updatedProfile.email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Телефон:</label>
                            <input type="text" id="phone" class="form-control" v-model="updatedProfile.phone">
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="button" class="btn btn-secondary" @click="editMode = false">Отмена</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            token: this.$store.state.token,
            profile: {
                name: null,
                surname: null,
                email: null,
                phone: null,
            },
            updatedProfile: {},
            editMode: false
        };
    },
    mounted() {
        this.fetchProfile();
    },
    methods: {
        fetchProfile() {
            axios.get('http://localhost:89/api/profile', {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.profile = response.data.data;
                    this.updatedProfile = { ...this.profile };
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                });
        },
        updateProfile() {
            axios.put('http://localhost:89/api/profile/update', this.updatedProfile, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.editMode = false;
                    this.profile = { ...this.updatedProfile };
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                });
        }
    }
};
</script>

<style>

</style>
