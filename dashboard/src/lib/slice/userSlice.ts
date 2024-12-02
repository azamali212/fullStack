'use client'
import { createSlice, createAsyncThunk, PayloadAction } from '@reduxjs/toolkit';
import axiosInstance from '../axiosInstance';
import Cookies from 'js-cookie';

// Interface for TypeScript to define state type
interface UserState {
  token: string | null;
  role: string | null;
  permissions: string[];
  name: string | null;
  loading: boolean;
  error: string | null;
}

// Initial state
const initialState: UserState = {
  token: null,
  role: null,
  permissions: [],
  name: null,
  loading: false,
  error: null,
};

// Thunk for user login
export const loginUser = createAsyncThunk(
  'user/login',
  async (credentials: { email: string; password: string }, { rejectWithValue }) => {
    try {
      // Get CSRF token before login
      console.log('Fetching CSRF token...');
      await axiosInstance.get('/sanctum/csrf-cookie');
      console.log('CSRF token fetched');

      // Send login request
      const response = await axiosInstance.post('/api/super-admin/login', credentials);
      console.log('Login response:', response.data);

      const { token, role, permissions, name } = response.data;

      // Check if response data is correct
      if (!token || !role || !permissions || !name) {
        console.error('Missing data in the response:', response.data);
      }

      // Store token and user info in local storage
      console.log('Storing data in localStorage...');
      localStorage.setItem('token', token);
      localStorage.setItem('role', role);
      localStorage.setItem('permissions', JSON.stringify(permissions));
      localStorage.setItem('name', name);

      // Return the data for the Redux store
      return { token, role, permissions, name };
    } catch (error: any) {
      console.error('Login error:', error.response?.data);
      return rejectWithValue(error.response?.data?.error || 'An error occurred');
    }
  }
);


export const logoutUser = createAsyncThunk(
  'user/logout',
  async (_, { rejectWithValue }) => {
    try {
      // Get token from localStorage or sessionStorage
      const token = localStorage.getItem('token');
      console.log('Retrieved token:', token);
      if (!token) {
        throw new Error('Token not found');
      }

      // Proceed with logout if token is found
      await axiosInstance.get('/sanctum/csrf-cookie');
      await axiosInstance.post('/api/super-admin/logout', {}, {
        headers: {
          Authorization: `Bearer ${token}`,
        }
      });

      // Clear localStorage and cookies after logout
      localStorage.clear();
      Cookies.remove('XSRF-TOKEN', { path: '/' });
      Cookies.remove('laravel_session', { path: '/' });
      Cookies.remove('loggedin', { path: '/' });
      Cookies.remove('userRole', { path: '/' });

      return true;
    } catch (error: any) {
      console.error('Logout error:', error);
      return rejectWithValue(error.response?.data?.error || error.message || 'Logout failed');
    }
  }
);

// User slice
const userSlice = createSlice({
  name: 'user',
  initialState,
  reducers: {}, // No direct reducers for login/logout; handled by thunks
  extraReducers: (builder) => {
    builder
      .addCase(loginUser.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(loginUser.fulfilled, (state, action: PayloadAction<{ token: string; role: string; permissions: string[]; name: string }>) => {
        state.loading = false;
        state.token = action.payload.token;
        state.role = action.payload.role;
        state.permissions = action.payload.permissions;
        state.name = action.payload.name;
      })
      .addCase(loginUser.rejected, (state, action) => {
        state.loading = false;
        state.error = action.payload as string;
      })
      .addCase(logoutUser.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(logoutUser.fulfilled, (state) => {
        state.loading = false;
        state.token = null;
        state.role = null;
        state.permissions = [];
        state.name = null;
      })
      .addCase(logoutUser.rejected, (state, action) => {
        state.loading = false;
        state.error = action.payload as string;
      });
  },
});

export default userSlice.reducer;