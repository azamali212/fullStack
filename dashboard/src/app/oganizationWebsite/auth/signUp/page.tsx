'use client'
import { useState } from 'react';
import { FaGoogle, FaTwitter } from 'react-icons/fa';
import Image from 'next/image';
import Link from 'next/link';
import Input from '../../shared/input/input';
import Button from '../../shared/button/button';
import { registerUser } from '@/lib/slice/organizationWebsite/hospitalRegistrationUser/hospitalRegistration';
import { useDispatch, useSelector } from 'react-redux';
import { AppDispatch,RootState } from '@/lib/store';
import axiosInstance from '@/lib/axiosInstance';

export default function SignUp() {
  const dispatch = useDispatch<AppDispatch>();
  const { loading, error } = useSelector((state: RootState) => state.hospitalRegistration || {});

  const [formData, setFormData] = useState({
    name: '',
    email: '',
    password: '',
    confirmPassword: '',
  });

  const [verificationModal, setVerificationModal] = useState(false);
  const [verificationCode, setVerificationCode] = useState('');
  const [email, setEmail] = useState('');

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({ ...prevData, [name]: value }));
  };

  const handleSubmit = async () => {
    if (formData.password !== formData.confirmPassword) {
      alert('Passwords do not match!');
      return;
    }

    try {
      const result = await dispatch(
        registerUser({
          name: formData.name,
          email: formData.email,
          password: formData.password,
          password_confirmation: formData.confirmPassword,
        })
      ).unwrap();
      setEmail(formData.email); // Save email for verification
      setVerificationModal(true); // Open the verification modal
    } catch (err) {
      console.error('Registration failed', err);
    }
  };

  const handleVerification = async () => {
    try {
      const response = await axiosInstance.post('/api/hospital-registration/organization/verify-email', {
        email,
        verification_code: verificationCode,
      });
      console.log(response); // Log the response after the API call
      alert('Email verified successfully!');
      setVerificationModal(false);
      window.location.href = '/oganizationWebsite/auth/signIn'; // Redirect to login page
    } catch (error) {
      console.error('Verification failed:', error);
      alert('Invalid verification code. Please try again.');
    }
  };

  return (
    <div className="flex min-h-full items-center justify-center px-6 py-12 bg-[var(--website-primary-color)] lg:px-8">
      <div className="w-full max-w-2xl space-y-8 bg-stone-200 p-8 rounded-xl shadow-lg transform transition-all duration-500 hover:scale-105">
        <div className="text-center">
          <Image
            alt="Your Company"
            width={40}
            height={40}
            src="/images/newlogo.png"
            className="mx-auto h-12 w-auto"
          />
          <h2 className="mt-6 text-3xl font-bold text-gray-900">Create your account</h2>
        </div>

        <form className="space-y-6">
          <Input
            id="name"
            name="name"
            type="text"
            label="Full Name"
            required
            value={formData.name}
            onChange={handleChange}
          />
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
          <Input
            id="confirmPassword"
            name="confirmPassword"
            type="password"
            label="Confirm Password"
            required
            value={formData.confirmPassword}
            onChange={handleChange}
          />
          <Button
            type="button"
            text={loading ? 'Signing Up...' : 'Sign Up'}
            className="bg-indigo-600 text-white hover:bg-indigo-500"
            disabled={loading}
            onClick={handleSubmit}
          />
        </form>

        <div className="space-y-4">
          <p className="mt-10 text-center text-sm text-gray-500">
            Already have an account?{' '}
            <Link href="/oganizationWebsite/auth/signIn" className="font-semibold text-indigo-600 hover:text-indigo-500">
              Sign In
            </Link>
          </p>
        </div>
      </div>

      {/* Verification Modal */}
      {verificationModal && (
        <div className="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75">
          <div className="bg-white p-6 rounded-lg shadow-lg">
            <h2 className="text-2xl font-bold mb-4">Verify Your Email</h2>
            <Input
              id="verificationCode"
              name="verificationCode"
              type="text"
              label="Verification Code"
              required
              value={verificationCode}
              onChange={(e) => setVerificationCode(e.target.value)}
            />
            <div className="mt-4 flex justify-end">
              <Button
                type="button"
                text="Verify"
                className="bg-indigo-600 text-white hover:bg-indigo-500"
                onClick={handleVerification}
              />
            </div>
          </div>
        </div>
      )}
    </div>
  );
}