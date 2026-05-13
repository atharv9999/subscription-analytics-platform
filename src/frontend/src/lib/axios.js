import axios from 'axios';

const api = axios.create({
    // We point this to your Nginx port
    baseURL: 'http://localhost:8080/api', 
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
    },
});

export default api;