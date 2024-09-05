import axios  from 'axios';

const token = localStorage.getItem('auth_token') ? localStorage.getItem('auth_token') : null;
const API_URL =  process.env.REACT_APP_BASE_API_DEV;

export const instance = axios.create({
    baseURL: `${API_URL}`,
    headers: {
        'Authorization': `Bearer ${token}`
    },
})