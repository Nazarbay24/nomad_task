<template>
    <div>
        <div class="header">
            <h1>Контакты</h1>
            <button class="btn btn-primary" @click="showCreateForm">Добавить</button>
        </div>
        <div class="input-group mb-3" style="margin-top: 15px;">
            <input type="text" class="form-control" placeholder="Поиск по имени, номеру" v-model="searchQuery" @input="handleInput">
        </div>
        <table class="table">
            <thead>
            <tr>
                <th @click="toggleSort" style="cursor: pointer;">Name <i :class="sortDirection === 'asc' ? 'fa fa-arrow-up' : 'fa fa-arrow-down'"></i></th>
                <th>Phone</th>
                <th>Created At</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="contact in contacts" :key="contact.id">
                <td>{{ contact.name }}</td>
                <td>{{ contact.phone }}</td>
                <td>{{ contact.created_at }}</td>
                <td>
                    <button class="btn btn-secondary" @click="showEditForm(contact)">Edit</button>
                    <button class="btn btn-danger" @click="deleteContact(contact.id)" style="margin-left: 10px;">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                    <a class="page-link" href="#" @click="fetchContacts(currentPage - 1)">Previous</a>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ 'active': page === currentPage }">
                    <a class="page-link" href="#" @click="fetchContacts(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                    <a class="page-link" href="#" @click="fetchContacts(currentPage + 1)">Next</a>
                </li>
            </ul>
        </nav>

        <div v-if="showForm" class="form_modal">
            <div>
                <h2 v-if="!editMode">Add Contact</h2>
                <h2 v-else>Edit Contact</h2>
                <form @submit.prevent="submitForm">
                    <div class="mb-3">
                        <input type="text" class="form-control" v-model="formData.name" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" v-model="formData.phone" placeholder="Phone">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ editMode ? 'Update' : 'Add' }}</button>
                    <button type="button" class="btn btn-secondary" @click="hideForm">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {debounce} from "lodash";

export default {
    data() {
        return {
            token: this.$store.state.token,
            contacts: [],
            currentPage: 1,
            totalPages: 1,
            searchQuery: '',
            sortDirection: 'asc',
            showForm: false, // Показывать форму создания или редактирования контакта
            editMode: false, // Режим редактирования контакта
            formData: {id: '', name: '', phone: '' },
        };
    },
    mounted() {
        this.fetchContacts();
    },
    methods: {
        fetchContacts() {
            let data = {};
            if (this.searchQuery != '') {
                data.search = this.searchQuery
            }
            if (this.sortDirection != '') {
                data.sort_name = this.sortDirection
            }

            axios.post('http://localhost:89/api/contact/get-all', data, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.contacts = response.data.data.data;
                    this.currentPage = response.data.data.current_page;
                    this.totalPages = response.data.data.last_page;
                })
                .catch(error => {
                    console.error('Error fetching contacts:', error);
                });

        },
        toggleSort() {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            this.fetchContacts();
        },
        fetchContactsWithDebounce: debounce(function() {
            this.fetchContacts();
        }, 400),
        handleInput() {
            this.fetchContactsWithDebounce();
        },

        showCreateForm() {
            this.showForm = true;
            this.editMode = false;
            this.formData = { name: '', phone: '' };
        },
        showEditForm(contact) {
            this.showForm = true;
            this.editMode = true;
            this.formData = {id: contact.id, name: contact.name, phone: contact.phone };
        },
        hideForm() {
            this.showForm = false;
            this.editMode = false;
            this.formData = { name: '', phone: '' };
        },
        submitForm() {
            if (this.editMode) {
                axios.post(`http://localhost:89/api/contact/update/${this.formData.id}`, this.formData, {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    }
                })
                    .then(response => {
                        this.fetchContacts();
                        this.showForm = false;
                    })
                    .catch(error => {
                        console.error('Error fetching contacts:', error);
                    });
            } else {
                axios.post(`http://localhost:89/api/contact/create`, this.formData, {
                    headers: {
                        Authorization: `Bearer ${this.token}`
                    }
                })
                    .then(response => {
                        this.fetchContacts();
                        this.showForm = false;
                    })
                    .catch(error => {
                        console.error('Error fetching contacts:', error);
                    });
            }
        },
        deleteContact(contactId) {
            axios.post(`http://localhost:89/api/contact/delete/${contactId}`, {}, {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.fetchContacts();
                })
                .catch(error => {
                    console.error('Error fetching contacts:', error);
                });
        }
    },
};
</script>

<style scoped>
.header {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}
.header button {
    margin-left: 30px;
}
.form_modal {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
}
.form_modal > div {
    background: #fff;
    padding: 50px;
}
</style>

