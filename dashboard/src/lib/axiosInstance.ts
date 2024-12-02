import axios from 'axios';
import Cookies from 'js-cookie';

axios.defaults.withCredentials = true;

// Get CSRF token from cookies
const csrfToken = Cookies.get('XSRF-TOKEN');
if (csrfToken) {
  axios.defaults.headers.common['X-XSRF-TOKEN'] = csrfToken;
}

// Create an axios instance for API requests
const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/',
  headers: {
    'Content-Type': 'application/json',
  },
});

// Interceptor to add JWT token to the headers
axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token'); // Get token from local storage
    if (token) {
      console.log('Setting Authorization header:', `Bearer ${token}`);
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default axiosInstance;