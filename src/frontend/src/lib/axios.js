import axios from 'axios';

const api = axios.create({
    // We point this to your Nginx port
    baseURL: 'http://localhost:8080/api', 
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
    },
});
api.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default api;