'use client'

import React, { useEffect, useState } from 'react';
import { useSelector } from 'react-redux';
import { RootState } from './lib/store';  // Adjust path as needed
import { useRouter, usePathname } from 'next/navigation';

export const withAuth = (Component: React.ComponentType) => {
  // Create a wrapper component
  const Wrapper = (props: any) => {
    const router = useRouter();
    const pathname = usePathname();
    const [isLoading, setIsLoading] = useState(true); // To avoid rendering the component too early
    const token = useSelector((state: RootState) => state.user.token) || localStorage.getItem('token'); // Get token from Redux or localStorage

    useEffect(() => {
      // If no token, redirect to login page unless already on login page
      if (!token) {
        if (pathname !== '/auth/login') {
          router.push('/auth/login'); // Redirect to login page if no token
        }
      } else {
        // If there's a token, and we're on the login page, redirect to the dashboard
        if (pathname === '/auth/login') {
          router.push('/dashboard/hospital/dashboard'); // Redirect to dashboard if logged in
        }
      }
      setIsLoading(false); // Mark loading as finished
    }, [token, pathname, router]);

    // Show loading screen while token is being checked
    if (isLoading) {
      return <div>Loading...</div>;
    }

    // If token exists, render the protected component
    return <Component {...props} />;
  };

  // Set displayName for better debugging in React dev tools
  Wrapper.displayName = `withAuth(${Component.displayName || Component.name})`;

  return Wrapper;
};