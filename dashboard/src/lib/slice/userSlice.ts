import { createSlice, createAsyncThunk, PayloadAction } from '@reduxjs/toolkit';
import axiosInstance from '../axiosInstance';

interface UserState {
  token: string | null;
  role: string | null;
  permissions: string[];
  name: string | null;
  loading: boolean;
  error: string | null;
}

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
      await axiosInstance.get('/sanctum/csrf-cookie');
      
      // Send login request
      const response = await axiosInstance.post('/api/super-admin/login', credentials);
      const { token, role, permissions, name } = response.data;

      // Store token and user info in local storage
      localStorage.setItem('token', token);
      localStorage.setItem('role', role);
      localStorage.setItem('permissions', JSON.stringify(permissions));
      localStorage.setItem('name', name);

      return { token, role, permissions, name };
    } catch (error: any) {
      return rejectWithValue(error.response?.data?.error || 'An error occurred');
    }
  }
);

const userSlice = createSlice({
  name: 'user',
  initialState,
  reducers: {
    logout: (state) => {
      state.token = null;
      state.role = null;
      state.permissions = [];
      state.name = null;
      localStorage.removeItem('token');
      localStorage.removeItem('role');
      localStorage.removeItem('permissions');
      localStorage.removeItem('name');
    },
  },
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
      });
  },
});

export const { logout } = userSlice.actions;
export default userSlice.reducer;