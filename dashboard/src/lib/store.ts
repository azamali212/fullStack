import { configureStore } from '@reduxjs/toolkit';
import userReducer from './slice/userSlice';
import userRoleSlice from './slice/userRoleSlice';
import userPermissionSlice from './slice/userPermissionSlice';


export const store = configureStore({
  reducer: {
    user: userReducer,
    userRoles: userRoleSlice,
    userPermission: userPermissionSlice
  },
  devTools: process.env.NODE_ENV !== "production",
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;