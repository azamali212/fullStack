import { createSlice, createAsyncThunk, PayloadAction } from '@reduxjs/toolkit';
import axiosInstance from '@/lib/axiosInstance'; // Make sure you have axiosInstance correctly configured
import Cookies from 'js-cookie';

// Interface for TypeScript to define state type
interface HospitalRegistrationState {
  token: string | null;
  name: string | null;
  email: string[];
  password: string | null;
  loading: boolean;
  error: string | null;
}

// Initial state
const initialState: HospitalRegistrationState = {
  token: null,
  email: [],
  name: null,
  password: null,
  loading: false,
  error: null,
};

// Create async thunk for registration
export const registerUser = createAsyncThunk(
  'hospitalRegistration/registerUser',
  async (userData: { name: string; email: string; password: string; password_confirmation: string }, { rejectWithValue }) => {
    try {
      const response = await axiosInstance.post('api/hospital-registration/organization/HospitalRegistrationUser/register', userData);
      return response.data;  // Send the response data back
    } catch (error) {
      return rejectWithValue(error.response.data);  // Handle error by rejecting with the error response
    }
  }
);

// Create async thunk for login
export const loginHRU = createAsyncThunk(
  'hospitalRegistration/loginHRU',
  async (credentials: { email: string; password: string }, { rejectWithValue }) => {
    try {
      const response = await axiosInstance.post('api/organization/hospitalRegistrationUser/login', credentials);
      return response.data;  // Send the response data back (which includes token and user)
    } catch (error) {
      return rejectWithValue(error.response.data);  // Handle error by rejecting with the error response
    }
  }
);

// Create async thunk for logout
// Redux Thunk for Logout
export const performLogout = createAsyncThunk(
  "hospitalRegistration/performLogout",
  async (_, { dispatch }) => {
    try {
      await axiosInstance.post("api/hospital-registration/organization/logout");
      Cookies.remove("token");  // Ensure token is removed from cookies
      localStorage.removeItem("token");  // Ensure token is removed from local storage
      dispatch(clearUser());
    } catch (error) {
      console.error("Error during logout:", error);
      throw error;
    }
  }
);

// Redux slice
const hospitalRegistrationSlice = createSlice({
  name: 'hospitalRegistration',
  initialState,
  reducers: {
    clearError: (state) => {
      state.error = null;
    },
    setUser(state, action) {
      state.token = action.payload.token;
      state.name = action.payload.name;
    },
    clearUser(state) {
      state.token = null;
      state.name = null;
      state.email = [];
      state.password = null;
    },
    setToken: (state, action) => {
      state.token = action.payload.token;
      state.name = action.payload.name;
    },
    clearToken: (state) => {
      state.token = null;
      state.name = "";
    },
  },
  extraReducers: (builder) => {
    // Handle registration actions
    builder.addCase(registerUser.pending, (state) => {
      state.loading = true;
      state.error = null;
    });
    builder.addCase(registerUser.fulfilled, (state, action: PayloadAction<any>) => {
      state.loading = false;
      state.token = action.payload.token;
      state.name = action.payload.user.name;
      state.email = [action.payload.user.email];
      Cookies.set("token", action.payload.token); // Save token in cookies
      localStorage.setItem("token", action.payload.token); // Save token in local storage
    });
    builder.addCase(registerUser.rejected, (state, action: PayloadAction<any>) => {
      state.loading = false;
      state.error = action.payload.error || 'Registration failed';
    });

    // Handle login actions
    builder.addCase(loginHRU.pending, (state) => {
      state.loading = true;
      state.error = null;
    });
    builder.addCase(loginHRU.fulfilled, (state, action: PayloadAction<any>) => {
      console.log('Login Success Payload:', action.payload);  // Log the response to check the data structure
      state.loading = false;
      state.token = action.payload.token;
      state.name = action.payload.user.name;
      state.email = [action.payload.user.email];
      Cookies.set('token', action.payload.token);
    });
    builder.addCase(loginHRU.rejected, (state, action: PayloadAction<any>) => {
      state.loading = false;
      state.error = action.payload.error || 'Login failed';
    });

    // Handle logout actions
    builder.addCase(performLogout.pending, (state) => {
      state.loading = true;
      state.error = null;
    });
    builder.addCase(performLogout.fulfilled, (state) => {
      state.loading = false;
      state.token = null;
      state.name = null;
      state.email = [];
      Cookies.remove('token');  // Remove token from cookies
    });
    builder.addCase(performLogout.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload as string;
    });
  },
});

export const { clearError, setUser, clearUser,setToken,clearToken } = hospitalRegistrationSlice.actions;
export default hospitalRegistrationSlice.reducer;