"use client"; 

import { useState, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { loginUser } from "@/redux/slices/userSlice";
import Input from "@/components/ui/Input";
import Button from "@/components/ui/Button";
import { useRouter } from "next/navigation"; 
import ToastWrapper, { notify } from "@/components/ToastWrapper"; 

export default function Login() {
  const dispatch = useDispatch();
  const router = useRouter();
  const { role, error, isAuthenticated, loading } = useSelector((state) => state.user);

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [errorMessage, setErrorMessage] = useState(null);

  useEffect(() => {
    if (isAuthenticated) {
      router.push('/pages/auth-page/dashboard');
    }
    if (error) {
      setErrorMessage(error.message || "An error occurred.");
      if (error.message === "User does not have the right permissions.") {
        notify("You do not have the right permissions to access this page.");
      }
    }
  }, [isAuthenticated, error, router]);

  const handleLogin = async (e) => {
    e.preventDefault();
    setErrorMessage(null);

    if (!email || !password) {
      setErrorMessage("Email and Password are required.");
      return;
    }

    await dispatch(loginUser({ email, password }));
  };

  return (
    <div className="flex flex-col items-center justify-center min-h-screen bg-gray-100">
      <ToastWrapper />
      <form onSubmit={handleLogin} className="bg-slate-300 p-6 rounded-md shadow-md w-80">
        <h2 className="text-stone-600 text-2xl mb-4">Login</h2>

        {errorMessage && (
          <div className="bg-red-500 text-white p-2 rounded mb-4">
            <p>{errorMessage}</p>
            <button onClick={() => setErrorMessage(null)} className="mt-2 underline">Close</button>
          </div>
        )}

        <Input
          label="Email"
          type="email"
          placeholder="example@example.com"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />

        <div className="mt-4">
          <Input
            label="Password"
            type="password"
            placeholder="Your password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />
        </div>

        <Button type="submit" className="mt-4 w-full" disabled={loading}>
          {loading ? 'Logging in...' : 'Login'}
        </Button>
      </form>
    </div>
  );
}