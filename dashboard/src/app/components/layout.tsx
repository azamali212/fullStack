"use client";

import React, { useState, useEffect } from "react";
import Navbar from "../ui/navbar/navbar";
import Sidebar from "../ui/sidebar/sidebar";
import { FaBars } from "react-icons/fa";
import { useRouter } from "next/navigation"; // Import useRouter for navigation
import "./style.css";
import BasicBreadcrumbs from "../ui/breadcrumbs/breadcrumbs";

interface DashboardProps {
  children: React.ReactNode;
  userRole: string;
  className: string;
  userName: string;
  userImage: string;
}

function Dashboard({
  children,
  userRole,
  className,
  userName,
  userImage,
}: DashboardProps) {
  const [isSidebarOpen, setIsSidebarOpen] = useState(true);

  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  // Ensure sidebar is open on large screens by default
  useEffect(() => {
    const handleResize = () => {
      if (window.innerWidth >= 1024) {
        setIsSidebarOpen(true); // Sidebar should be open on large screens
      }
    };

    handleResize();
    window.addEventListener("resize", handleResize);

    return () => {
      window.removeEventListener("resize", handleResize);
    };
  }, []);

  return (
    <div className="h-screen flex flex-col">
      {/* Navbar */}
      <div className="navbar p-2 flex justify-between items-center">
        <button className="ml-3 focus:outline-none" onClick={toggleSidebar}>
          <FaBars className="w-5 h-5" />
        </button>
        <Navbar />
      </div>

     

      {/* Breadcrumbs (Centered below the Navbar) */}
      <div className="bg-gray-100">
        <BasicBreadcrumbs />
      </div>

      <div className="flex flex-1">
        {/* Sidebar */}
        <div
          className={`sidebar ${
            isSidebarOpen ? "open" : "closed"
          } text-white transition-transform duration-300 transform lg:w-64 lg:absolute h-full z-10`}
        >
          <Sidebar
            isSidebarOpen={isSidebarOpen}
            userRole={userRole}
            userName={userName}
            userImage={userImage}
          />
        </div>

        {/* Main Content */}
        <main
          className={`flex-1 p-3 transition-all duration-300 ${className} ${
            isSidebarOpen ? "lg:ml-64" : "lg:ml-0"
          }`}
        >
          {children}
        </main>
      </div>
    </div>
  );
}

export default Dashboard;
