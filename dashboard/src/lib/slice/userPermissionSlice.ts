import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axiosInstance from "../axiosInstance";

// Interface for Permissions
interface Permission {
  id: number;
  name: string;
  group: string;
}

// Define the initial state for permissions
interface PermissionState {
  permissions: Permission[];
  loading: boolean;
  error: string | null;
}

const initialState: PermissionState = {
  permissions: [],
  loading: false,
  error: null,
};

// Async action to fetch permissions
export const fetchPermissions = createAsyncThunk(
  "permissions/fetchPermissions",
  async (_, { rejectWithValue }) => {
    try {
      const response = await axiosInstance.get("/api/permission");
      return response.data.data;
    } catch (error: any) {
      return rejectWithValue(
        error.response?.data?.message || "Failed to fetch permissions"
      );
    }
  }
);

// Create slice for permissions
const userPermissionSlice = createSlice({
  name: "permissions",
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    builder.addCase(fetchPermissions.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(fetchPermissions.fulfilled, (state, action) => {
      state.loading = false;
      state.permissions = action.payload;
    });

    builder.addCase(fetchPermissions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload as string;
    });
  },
});

export default userPermissionSlice.reducer;
