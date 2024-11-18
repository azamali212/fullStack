import React, { useState, useEffect } from 'react';
import Navbar from '../ui/navbar/navbar';
import Sidebar from '../ui/sidebar/sidebar';
import { FaBars } from 'react-icons/fa'; // Icon for the toggle button
import './style.css';

interface DashboardProps {
  children: React.ReactNode;
  userRole: string; // Accept userRole dynamically as a prop
}

function Dashboard({ children, userRole }: DashboardProps) {
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

    handleResize(); // Set initial state based on screen width
    window.addEventListener('resize', handleResize); // Update state on resize

    return () => {
      window.removeEventListener('resize', handleResize);
    };
  }, []);

  return (
    <div className="h-screen flex flex-col">
      <div className="navbar p-2 flex justify-between items-center">
        <button className="ml-3 focus:outline-none" onClick={toggleSidebar}>
          <FaBars className="w-5 h-5" />
        </button>
        <Navbar />
      </div>

      <div className="flex flex-1">
        {/* Sidebar */}
        <div
          className={`sidebar ${
            isSidebarOpen ? 'open' : 'closed'
          } text-white transition-transform duration-300 transform lg:w-64 lg:absolute h-full z-10`}
        >
          <Sidebar isSidebarOpen={isSidebarOpen} userRole={userRole} />
        </div>

        {/* Main Content */}
        <main
          className={`flex-1 p-3 bg-white transition-all duration-300 ${
            isSidebarOpen ? 'lg:ml-64' : 'lg:ml-0' // When sidebar is open, move content to the right
          }`}
        >
          {children}
        </main>
      </div>
    </div>
  );
}

export default Dashboard;