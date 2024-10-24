"use client";  // Client-side directive for Redux

import localFont from "next/font/local";
import { Provider } from "react-redux";
import store from "../redux/store";
import { useEffect } from "react";
import { setAuthToken } from "../utils/axios"; // Import setAuthToken function
import "./globals.css";
import Head from 'next/head';

// Load fonts using next/font
const geistSans = localFont({
  src: "./fonts/GeistVF.woff",
  variable: "--font-geist-sans",
  weight: "100 900",
});
const geistMono = localFont({
  src: "./fonts/GeistMonoVF.woff",
  variable: "--font-geist-mono",
  weight: "100 900",
});


// Root Layout for the entire app
export default function RootLayout({ children }) {
 
  useEffect(() => {
    const token = localStorage.getItem('token'); // Get token from local storage
    setAuthToken(token); // Set the token if it exists
  }, []); // Empty dependency array ensures this runs only once

  return (
    <html lang="en">
        <head>
        <title>Login</title>
        <meta name='description' content='Description' />
      </head>
      <body
        className={`${geistSans.variable} ${geistMono.variable} antialiased`}
      >
        {/* Redux Provider wrapping the app */}
        <Provider store={store}>
          {children}
        </Provider>
      </body>
    </html>
  );
}