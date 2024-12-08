// features/user/userSlice.ts
import { createSlice, createAsyncThunk, PayloadAction } from '@reduxjs/toolkit';
import axiosInstance from '../axiosInstance';

interface Hospital {
    id: number;
    name: string;
  }

interface Admin {
  id: number;
  name: string;
  email: string;
  role: string;
  permissions: string[];
  hospital?: Hospital;
}

interface UserState {
  users: Admin[];
  user: Admin | null;
  status: 'idle' | 'loading' | 'succeeded' | 'failed';
  error: string | null;
}

const initialState: UserState = {
  users: [],
  user: null,
  status: 'idle',
  error: null,
};

// Async Thunks
export const getUsers = createAsyncThunk('users/getUsers', async () => {
  const response = await axiosInstance.get('/api/user');
  return response.data.data.users; // Assuming response contains users in 'data.users'
});

export const createUser = createAsyncThunk(
  'users/createUser',
  async (userData: { name: string; email: string; role: string; permissions: string[] }) => {
    const response = await axiosInstance.post('/api/user/store', userData);
    return response.data.data; // Assuming response contains the created user in 'data'
  }
);

export const getUser = createAsyncThunk('users/getUser', async (user: string) => {
  const response = await axiosInstance.get(`/api/user/${user}`); // Correct route to get a specific user
  return response.data.data; // Assuming response contains the user in 'data'
});

export const updateUser = createAsyncThunk(
  'users/updateUser',
  async ({ user, userData }: { user: string; userData: any }) => {
    const response = await axiosInstance.put(`/api/user/${user}`, userData); // Correct route to update a user
    return response.data.data; // Assuming response contains the updated user in 'data'
  }
);

export const deleteUser = createAsyncThunk('users/deleteUser', async (user: string) => {
  const response = await axiosInstance.delete(`/api/user/${user}`); // Correct route to delete a user
  return user; // Return user ID for deletion
});

// Slice
const adminSlice = createSlice({
  name: 'admins',
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    // Get Users
    builder.addCase(getUsers.pending, (state) => {
      state.status = 'loading';
    });
    builder.addCase(getUsers.fulfilled, (state, action: PayloadAction<Admin[]>) => {
      state.status = 'succeeded';
      state.users = action.payload;
    });
    builder.addCase(getUsers.rejected, (state, action) => {
      state.status = 'failed';
      state.error = action.error.message || 'Failed to fetch users';
    });

    // Create User
    builder.addCase(createUser.pending, (state) => {
      state.status = 'loading';
    });
    builder.addCase(createUser.fulfilled, (state, action: PayloadAction<Admin>) => {
      state.status = 'succeeded';
      state.users.push(action.payload);
    });
    builder.addCase(createUser.rejected, (state, action) => {
      state.status = 'failed';
      state.error = action.error.message || 'Failed to create user';
    });

    // Get Single User
    builder.addCase(getUser.pending, (state) => {
      state.status = 'loading';
    });
    builder.addCase(getUser.fulfilled, (state, action: PayloadAction<Admin>) => {
      state.status = 'succeeded';
      state.user = action.payload;
    });
    builder.addCase(getUser.rejected, (state, action) => {
      state.status = 'failed';
      state.error = action.error.message || 'Failed to fetch user';
    });

    // Update User
    builder.addCase(updateUser.pending, (state) => {
      state.status = 'loading';
    });
    builder.addCase(updateUser.fulfilled, (state, action: PayloadAction<Admin>) => {
      state.status = 'succeeded';
      const index = state.users.findIndex((user) => user.id === action.payload.id);
      if (index !== -1) {
        state.users[index] = action.payload;
      }
    });
    builder.addCase(updateUser.rejected, (state, action) => {
      state.status = 'failed';
      state.error = action.error.message || 'Failed to update user';
    });

    // Delete User
    builder.addCase(deleteUser.pending, (state) => {
      state.status = 'loading';
    });
    builder.addCase(deleteUser.fulfilled, (state, action: PayloadAction<string>) => {
        state.status = 'succeeded';
        // Check if 'state.user' is not null before filtering
        if (state.user && state.user.id !== Number(action.payload)) { // Convert string to number here
          state.users = state.users.filter((user) => user.id !== Number(action.payload)); // Convert string to number here as well
        }
      });
    builder.addCase(deleteUser.rejected, (state, action) => {
      state.status = 'failed';
      state.error = action.error.message || 'Failed to delete user';
    });
  },
});

export default adminSlice.reducer;
