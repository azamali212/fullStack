import axios from 'axios';
import Cookies from 'js-cookie';

// Set up axios to use credentials
axios.defaults.withCredentials = true;

// Get CSRF token from cookies
const csrfToken = Cookies.get('XSRF-TOKEN');
if (csrfToken) {
  axios.defaults.headers.common['X-XSRF-TOKEN'] = csrfToken;
}

// Create an axios instance for API requests
const axiosInstance = axios.create({
  baseURL: 'http://127.0.0.1:8000/',  // Replace with your actual API URL
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true,
});

// Interceptor to add JWT token to the headers
axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

export default axiosInstance;