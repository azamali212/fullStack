"use client";
import React, { useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useRouter } from "next/navigation";
import { loginUser } from "../../../lib/slice/userSlice"; // Adjust path accordingly
import { RootState, AppDispatch } from "../../../lib/store"; // Adjust path accordingly
import Input from "../../shared/inputs/input"; // Adjust path accordingly
import Button from "../../shared/buttons/button"; // Adjust path accordingly
import Cookies from "js-cookie";

const Login: React.FC = () => {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const dispatch = useDispatch<AppDispatch>();
  const router = useRouter();
  const { loading, error } = useSelector((state: RootState) => state.user);

  const handleLoginClick = async () => {
    const resultAction = await dispatch(loginUser({ email, password }));
    if (loginUser.fulfilled.match(resultAction)) {
      console.log("Login successful, redirecting...");
      const userRole = resultAction.payload.role; // Assuming the payload contains user role
      Cookies.set("loggedin", "true");
      Cookies.set("userRole", userRole); // Store role in a cookie for use in middleware

      // Redirect based on role
      if (userRole === "System Administrator") {
        router.push("/dashboard/superAdmin/dashboard");
      } else if (userRole === "Hospital Administrator") {
        router.push("/dashboard/hospital/dashboard");
      } else {
        console.error("Unknown role");
      }
    } else {
      console.log("Login failed", resultAction.error);
    }
  };

  return (
    <div className="flex items-center justify-center min-h-screen bg-white">
      <div className="w-full max-w-xs">
        <div
          style={{ backgroundColor: "#405189" }}
          className="shadow-lg rounded-lg p-5 px-10 pt-8 pb-10 mb-4 min-h-[500px] flex flex-col justify-center"
        >
          <Input
            id="email"
            name="email"
            type="email"
            placeholder="Email"
            label="Email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />
          <Input
            id="password"
            name="password"
            type="password"
            placeholder="Password"
            label="Password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
          <div className="flex items-center justify-between mt-6">
            <Button
              text="Sign In"
              onClick={handleLoginClick}
              disabled={loading}
            />
            <a href="#" className="text-blue-500 hover:text-blue-800">
              Forgot Password?
            </a>
          </div>
          {error && <p className="text-red-500 text-xs mt-4">{error}</p>}
        </div>
        <p className="text-center text-gray-500 text-xs mt-4">
          &copy;2020 Acme Corp. All rights reserved.
        </p>
      </div>
    </div>
  );
};

export default Login;