import { configureStore } from '@reduxjs/toolkit';
import userReducer from './slice/userSlice';
import userRoleSlice from './slice/userRoleSlice';
import userPermissionSlice from './slice/userPermissionSlice';
import adminSlice from './slice/adminSlice';
import { hospitalReducer } from './slice/hospital/hospitalSlice';
import hospitalRegistrationSlice from './slice/organizationWebsite/hospitalRegistrationUser/hospitalRegistration';


export const store = configureStore({
  reducer: {
    user: userReducer,
    userRoles: userRoleSlice,
    userPermission: userPermissionSlice,
    admins: adminSlice,
    hospitals:hospitalReducer,
    hospitalRegistration:hospitalRegistrationSlice
  },
  devTools: process.env.NODE_ENV !== "production",
});

export type RootState = ReturnType<typeof store.getState>;
export type AppDispatch = typeof store.dispatch;