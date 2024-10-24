import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axios, { setAuthToken } from "@/utils/axios";

const initialState = {
  isAuthenticated: false,
  loading: false,
  error: null,
  role: null,
  token: null,
};

export const loginUser = createAsyncThunk(
  "user/login",
  async ({ email, password }, { rejectWithValue }) => {
    try {
      const response = await axios.post("/super-admin/login", { email, password });
      const { token, role } = response.data;

      setAuthToken(token);
      localStorage.setItem('token', token);

      return { token, role };
    } catch (error) {
      return rejectWithValue(
        error.response ? error.response.data : error.message
      );
    }
  }
);

const userSlice = createSlice({
  name: "user",
  initialState,
  reducers: {
    logout: (state) => {
      state.isAuthenticated = false;
      state.loading = false;
      state.error = null;
      state.role = null;
      setAuthToken(null);
      localStorage.removeItem('token');
    },
  },
  extraReducers: (builder) => {
    builder
      .addCase(loginUser.pending, (state) => {
        state.loading = true;
      })
      .addCase(loginUser.fulfilled, (state, action) => {
        state.loading = false;
        state.isAuthenticated = true;
        state.token = action.payload.token;
        state.role = action.payload.role;
      })
      .addCase(loginUser.rejected, (state, action) => {
        state.loading = false;
        state.error = action.payload;
      });
  },
});

export const { logout } = userSlice.actions;
export default userSlice.reducer;