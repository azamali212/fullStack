"use client";
import { useState } from "react";
import { FaGoogle, FaTwitter } from "react-icons/fa";
import Image from "next/image";
import Link from "next/link";
import Input from "../../shared/input/input";
import Button from "../../shared/button/button";
import { useDispatch } from "react-redux";
import { AppDispatch } from "@/lib/store";
import { loginHRU } from "@/lib/slice/organizationWebsite/hospitalRegistrationUser/hospitalRegistration";

export default function SignIn() {
  const dispatch = useDispatch<AppDispatch>();
  const [formData, setFormData] = useState({
    email: "",
    password: "",
  });
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({ ...prevData, [name]: value }));
    setError(""); // Clear errors on input change
  };

  const handleSubmit = async () => {
    if (!formData.email || !formData.password) {
      setError("Email and Password are required.");
      return;
    }

    setLoading(true);
    try {
      const response = await dispatch(loginHRU(formData)).unwrap();
      // Store token in local storage
      localStorage.setItem("token", response.token);
      alert("Login successful!");
      window.location.href = "/oganizationWebsite/pages/hospitalRegistration"; // Redirect after successful login
    } catch (err) {
      setError(err.message || "Login failed. Please try again.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex min-h-full items-center justify-center px-6 py-12 bg-[var(--website-primary-color)] lg:px-8">
      <div className="w-full max-w-md space-y-8 bg-stone-200 p-8 rounded-xl shadow-lg transform transition-all duration-500 hover:scale-105">
        <div className="text-center">
          <Image
            alt="Your Company"
            width={40}
            height={40}
            src="/images/newlogo.png"
            className="mx-auto h-12 w-auto"
          />
          <h2 className="mt-6 text-3xl font-bold text-gray-900">
            Sign in to your account
          </h2>
        </div>

        {error && <div className="text-red-500 text-center">{error}</div>}

        <form className="space-y-6">
          <Input
            id="email"
            name="email"
            type="email"
            label="Email address"
            required
            value={formData.email}
            onChange={handleChange}
          />
          <Input
            id="password"
            name="password"
            type="password"
            label="Password"
            required
            value={formData.password}
            onChange={handleChange}
          />

          <Button
            type="button"
            text={loading ? "Signing In..." : "Sign In"}
            className="bg-indigo-600 text-white hover:bg-indigo-500"
            onClick={handleSubmit}
            disabled={loading}
          />
        </form>

        <div className="space-y-4">
          <div className="flex justify-center space-x-4">
            <Button
              text="Sign in with Google"
              icon={<FaGoogle className="w-5 h-5" />}
              className="text-gray-900 hover:bg-gray-100"
              isFullWidth
            />
            <Button
              text="Sign in with Twitter"
              icon={<FaTwitter className="w-5 h-5" />}
              className="text-gray-900 hover:bg-gray-100"
              isFullWidth
            />
          </div>

          <p className="mt-10 text-center text-sm text-gray-500">
            If you don't have an account,{" "}
            <Link
              href="/oganizationWebsite/auth/signUp"
              className="font-semibold text-indigo-600 hover:text-indigo-500"
            >
              Sign Up
            </Link>
          </p>
        </div>
      </div>
    </div>
  );
}