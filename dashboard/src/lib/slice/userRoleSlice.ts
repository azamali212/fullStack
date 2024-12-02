import { createSlice, createAsyncThunk } from "@reduxjs/toolkit";
import axiosInstance from "../axiosInstance";

//Create Type Interface In TypeScript
interface RoleState {
  roles: Array<any>;
  permissions: number[];
  loading: boolean;
  error: string | null;
}

//Create Initial State
const initialState: RoleState = {
  roles: [],
  permissions: [],
  loading: false,
  error: null,
};

//Async Actions

//Get All Role
export const fetchRole = createAsyncThunk(
  "roles/fetchRole",
  async (_, { rejectWithValue }) => {
    try {
      const response = await axiosInstance.get("/api/role");
      return response.data.data;
    } catch (error: any) {
      // Check for token or session related errors here
      if (error.response?.status === 401) {
        return rejectWithValue("Unauthorized, please log in again.");
      }
      return rejectWithValue(error.response?.data?.message || "Failed to fetch roles");
    }
  }
);

//Add Role
export const addRole = createAsyncThunk(
  "roles/addRole",
  async (
    roleData: { name: string; permission: number[] },
    { rejectWithValue }
  ) => {
    try {
      const response = await axiosInstance.post("/api/role/store", roleData);
      return response.data.data;
    } catch (error: any) {
      return rejectWithValue(
        error.response?.data?.message || "Failed to add role"
      );
    }
  }
);

// Update role
export const updateRole = createAsyncThunk(
  "roles/updateRole",
  async (
    {
      role,
      roleData,
    }: { role: number; roleData: { name: string; permission: number[] } },
    { rejectWithValue }
  ) => {
    try {
      console.log("Request data to update role:", roleData);  // Log the request data

      const response = await axiosInstance.put(`/api/roles/${role}`, roleData);

      return {
        id: role,
        name: response.data.data.name,
        permissions: response.data.data.permissions, // Ensure correct property name here
      };
    } catch (error: any) {
      return rejectWithValue(
        error.response?.data?.message || "Failed to update role"
      );
    }
  }
);

// Delete role
export const deleteRole = createAsyncThunk(
  "roles/deleteRole",
  async (role: number, { rejectWithValue }) => {
    try {
      await axiosInstance.delete(`/api/roles/${role}`);
      return role;
    } catch (error: any) {
      return rejectWithValue(
        error.response?.data?.message || "Failed to delete role"
      );
    }
  }
);

//Create Slice
const userRoleSlice = createSlice({
  name: "roles",
  initialState,
  reducers: {},
  // Updated extraReducers for type safety
  extraReducers: (builder) => {
    builder.addCase(fetchRole.pending, (state) => {
      state.loading = true;
    });

    builder.addCase(fetchRole.fulfilled, (state, action) => {
      state.loading = false;
      state.roles = action.payload; // `action.payload` is typed as expected from `fetchRole`
    });

    builder.addCase(fetchRole.rejected, (state, action) => {
      state.loading = false;
      state.error = action.payload as string; // Ensure this matches your expected `rejectWithValue` output
    });

    // Add role
    builder.addCase(addRole.fulfilled, (state, action) => {
      state.roles.push(action.payload);
    });

    // Update role
    builder.addCase(updateRole.fulfilled, (state, action) => {
      const index = state.roles.findIndex((role) => role.id === action.payload.id);
      if (index >= 0) {
        state.roles[index] = {
          ...state.roles[index],
          name: action.payload.name,
          permissions: action.payload.permissions, // Correctly replace permissions
        };
      }
    });

    // Delete role
    builder.addCase(deleteRole.fulfilled, (state, action) => {
      state.roles = state.roles.filter((role) => role.id !== action.payload);
    });

    // Generic rejection matcher for all asyncThunks
    builder.addMatcher(
      (
        action
      ): action is ReturnType<
        | typeof fetchRole.rejected
        | typeof addRole.rejected
        | typeof updateRole.rejected
        | typeof deleteRole.rejected
      > => action.type.endsWith("/rejected"),
      (state, action) => {
        state.error = action.payload as string;
        state.loading = false;
      }
    );
  },
});

export default userRoleSlice.reducer;
