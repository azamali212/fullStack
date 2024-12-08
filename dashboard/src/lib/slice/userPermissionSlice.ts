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
  successMessage: string | null;
}

const initialState: PermissionState = {
  permissions: [],
  loading: false,
  error: null,
  successMessage: null,
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

//Async Action to add Permissions
export const addPermissions = createAsyncThunk(
  "permissions/addPermissions",
  async (permissionData: { name: string[] }, { rejectWithValue }) => {
    try {
      const response = await axiosInstance.post(
        "/api/permissions/store",
        permissionData
      );
      return response.data; // Return success message and data
    } catch (error: any) {
      return rejectWithValue(
        error.response?.data?.message || "Failed to add permissions"
      );
    }
  }
);

//Async Action to Edit Permissions
export const updatePermission = createAsyncThunk(
  "permissions/updatePermission",
  async (
    {
      permission, // permission ID
      permissionData,
    }: { permission: number; permissionData: { name: string } },
    { rejectWithValue }
  ) => {
    try {
      const response = await axiosInstance.put(
        `/api/permissions/${permission}`,
        permissionData
      );
      return response.data.data;
    } catch (error: any) {
      return rejectWithValue(
        error.response?.data?.message || "Failed to update permission"
      );
    }
  }
);

// Delete Permission
export const deletePermission = createAsyncThunk(
  "permissions/deletePermission",
  async (permission: number, { rejectWithValue }) => {
    try {
      await axiosInstance.delete(`/api/permissions/${permission}`);
      return permission;
    } catch (error: any) {
      return rejectWithValue(
        error.response?.data?.message || "Failed to delete permission"
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
    builder.addCase(addPermissions.pending, (state) => {
      state.loading = true;
      state.successMessage = null;
      state.error = null;
    });

    builder.addCase(addPermissions.fulfilled, (state, action) => {
      state.loading = false;
      state.successMessage = action.payload.message;
    });

    builder.addCase(addPermissions.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload as string;
    });

    builder.addCase(updatePermission.pending, (state) => {
      state.loading = true;
      state.error = null;
      state.successMessage = null;
    });

    builder.addCase(updatePermission.fulfilled, (state, action) => {
      state.loading = false;
      state.successMessage = "Permission updated successfully";

      // Update the permission in the state by name
      const updatedPermission = action.payload;
      const index = state.permissions.findIndex(
        (perm) => perm.name === updatedPermission.name
      );
      if (index !== -1) {
        state.permissions[index] = updatedPermission;
      }
    });

    builder.addCase(updatePermission.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload as string;
    });

    // Delete role
    builder.addCase(deletePermission.fulfilled, (state, action) => {
      state.permissions = state.permissions.filter(
        (permission) => permission.id !== action.payload
      );
    });

    // Generic rejection matcher for all asyncThunks
    builder.addMatcher(
      (
        action
      ): action is ReturnType<
        | typeof fetchPermissions.rejected
        | typeof addPermissions.rejected
        | typeof updatePermission.rejected
        | typeof deletePermission.rejected
      > => action.type.endsWith("/rejected"),
      (state, action) => {
        state.error = action.payload as string;
        state.loading = false;
      }
    );
  },
});

export default userPermissionSlice.reducer;
