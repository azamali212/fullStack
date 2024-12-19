import { createSlice, createAsyncThunk, PayloadAction } from "@reduxjs/toolkit";
import axiosInstance from "@/lib/axiosInstance";
import { Hospital } from "./hospitalInterface";

interface HospitalState {
  hospitals: Hospital[];
  loading: boolean;
  error: string | null;
}

const initialState: HospitalState = {
  hospitals: [],
  loading: false,
  error: null,
};

// Async Thunks
export const getHospitals = createAsyncThunk(
  "hospitals/getHospitals",
  async () => {
    const response = await axiosInstance.get("/api/hospital");
    console.log(response.data);
    return response.data.data; // Assuming response contains hospitals in 'data.hospitals'
  }
);

const hospitalSlice = createSlice({
  name: "hospital",
  initialState,
  reducers: {
    // Add custom reducers if needed
  },
  extraReducers: (builder) => {
    builder
      .addCase(getHospitals.pending, (state) => {
        state.loading = true;
        state.error = null;
      })
      .addCase(getHospitals.fulfilled, (state, action: PayloadAction<Hospital[]>) => {
        state.hospitals = action.payload; // action.payload will be the array of hospitals
        state.loading = false;
      })
      .addCase(getHospitals.rejected, (state, action: PayloadAction<any>) => {
        state.loading = false;
        state.error = action.payload;
      });
  },
});

export const hospitalReducer = hospitalSlice.reducer;