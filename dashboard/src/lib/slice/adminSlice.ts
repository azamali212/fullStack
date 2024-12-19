// features/user/userSlice.ts
import { createSlice, createAsyncThunk, PayloadAction } from "@reduxjs/toolkit";
import axiosInstance from "../axiosInstance";

interface Hospital {
  id: number;
  name: string;
}

interface Admin {
  id: number;
  name: string;
  email: string;
  role: string;
  password: string;
  permissions: string[];
  hospital?: Hospital;
}

interface UserState {
  users: Admin[];
  user: Admin | null;
  status: "idle" | "loading" | "succeeded" | "failed";
  error: string | null;
}

const initialState: UserState = {
  users: [],
  user: null,
  status: "idle",
  error: null,
};

// Async Thunks
export const getUsers = createAsyncThunk("users/getUsers", async () => {
  const response = await axiosInstance.get("/api/user");
  console.log(response);
  return response.data.data.users; // Assuming response contains users in 'data.users'
});


export const createUser = createAsyncThunk(
  "users/createUser",
  async (
    userData: { name: string; email: string; role: string; permissions: string[]; password: string; hospital_id: number, },
    { rejectWithValue }
  ) => {
    try {
      const response = await axiosInstance.post("/api/user/store", userData);
      return response.data.data;
    } catch (error: any) {
      if (error.response) {
        return rejectWithValue(error.response.data.message || "Failed to create user");
      }
      return rejectWithValue("An unexpected error occurred");
    }
  }
);

export const getUser = createAsyncThunk(
  "users/getUser",
  async (user: string) => {
    const response = await axiosInstance.get(`/api/user/${user}`); // Correct route to get a specific user
    return response.data.data; // Assuming response contains the user in 'data'
  }
);

export const updateUser = createAsyncThunk(
  "users/updateUser",
  async (
    { user, userData }: { user: number; userData: Admin },
    { rejectWithValue }
  ) => {
    try {
      const response = await axiosInstance.put(`/api/user/${user}`, userData);
      return response.data; // return updated user data
    } catch (error) {
      return rejectWithValue(
        error.response?.data?.message || "Failed to update user"
      );
    }
  }
);

export const deleteUser = createAsyncThunk<string, string>(
  "users/deleteUser",
  async (user: string, { rejectWithValue }) => {
    try {
      await axiosInstance.delete(`/api/user/${user}`);
      return user; // Return user ID
    } catch (error: any) {
      return rejectWithValue(
        error?.response?.data?.message ||
          error?.message ||
          "Failed to delete user"
      );
    }
  }
);

// Slice
const adminSlice = createSlice({
  name: "admins",
  initialState,
  reducers: {
    addUserOptimistically: (state, action) => {
      state.users.push(action.payload);
    }
  },
  extraReducers: (builder) => {
    builder.addCase(getUsers.pending, (state) => {
      state.status = "loading";
    });
    builder.addCase(
      getUsers.fulfilled,
      (state, action: PayloadAction<Admin[]>) => {
        state.status = "succeeded";
        state.users = action.payload;
      }
    );
    builder.addCase(getUsers.rejected, (state, action) => {
      state.status = "failed";
      state.error = action.error.message || "Failed to fetch users";
    });

    builder.addCase(createUser.pending, (state) => {
      state.status = "loading";
    });
    builder.addCase(createUser.fulfilled, (state, action: PayloadAction<Admin>) => {
      state.status = "succeeded";
      state.users.push(action.payload); // Adding the new user optimistically here
    });

    builder.addCase(createUser.rejected, (state, action) => {
      state.status = "failed";
      state.error = action.error.message || "Failed to create user";
    });

    builder.addCase(getUser.pending, (state) => {
      state.status = "loading";
    });
    builder.addCase(
      getUser.fulfilled,
      (state, action: PayloadAction<Admin>) => {
        state.status = "succeeded";
        state.user = action.payload;
      }
    );
    builder.addCase(getUser.rejected, (state, action) => {
      state.status = "failed";
      state.error = action.error.message || "Failed to fetch user";
    });

    builder.addCase(updateUser.pending, (state) => {
      state.status = "loading";
    });
    builder.addCase(updateUser.fulfilled, (state, action: PayloadAction<Admin>) => {
      state.status = "succeeded";
      const index = state.users.findIndex(
        (user) => user.id === action.payload.id
      );
      if (index !== -1) {
        state.users[index] = action.payload;
      }
    });

    builder.addCase(updateUser.rejected, (state, action) => {
      state.status = "failed";
      state.error = action.error.message || "Failed to update user";
    });

    builder.addCase(deleteUser.pending, (state) => {
      state.status = "loading";
    });
    builder.addCase(
      deleteUser.fulfilled,
      (state, action: PayloadAction<string>) => {
        state.status = "succeeded";
        state.users = state.users.filter(
          (user) => user.id !== Number(action.payload)
        );
      }
    );
    builder.addCase(deleteUser.rejected, (state, action) => {
      state.status = "failed";
      state.error =
        action.payload || action.error.message || "Failed to delete user";
    });
  },
});

export default adminSlice.reducer;
