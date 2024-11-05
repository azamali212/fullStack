import axios from 'axios';

export const setAuthToken = (token) => {
  if (token) {
    localStorage.setItem('token', token); // Store the token in local storage
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`; // Use Bearer token for authorization
  } else {
    localStorage.removeItem('token'); // Remove the token
    delete axios.defaults.headers.common['Authorization'];
  }
};

// Function to initialize token on app load
export const initializeAuthToken = () => {
  const token = localStorage.getItem('token');
  if (token) {
    setAuthToken(token); // Set the token if it exists
  }
};

const instance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', // Your API's base URL
});

export default instance;