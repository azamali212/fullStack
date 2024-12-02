'use client';
import Dashboard from '@/app/components/layout';
import React, { useState, useEffect } from 'react';
import Image from 'next/image';
import Paper from '@mui/material/Paper';
import Skeleton from '@mui/material/Skeleton';
import Link from 'next/link';

function UserSetting() {
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const timer = setTimeout(() => {
      setLoading(false);
    }, 1000); // Simulate loading for 3 seconds
    return () => clearTimeout(timer);
  }, []);

  // Define the images array and corresponding titles
  const images = [
    { src: "/images/management.png", title: "Permissions" },
    { src: "/images/ambulance.png", title: "Ambulance" },
    { src: "/images/hospital.png", title: "Hospital" },
    { src: "/images/image1.png", title: "User" },
    { src: "/images/image2.png", title: "Staff" },
    { src: "/images/medical-team.png", title: "Medical Team" },
  ];

  return (
    <Dashboard
      userRole="System Administrator"
      className="p-5"
      userName="Admin"
      userImage=""
    >
      {/* Section 1 */}
      <Link href="/pages/userRole" className="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        {images.map((img, idx) => (
          <Paper
            elevation={3} // Reduced elevation for a subtler effect
            key={idx}
            className={`${
              idx % 2 === 0 ? 'bg-blue-300' : 'bg-green-300'
            } p-3 rounded-lg flex flex-row items-center transform transition duration-300 hover:scale-105 hover:shadow-lg shadow-md`}
          >
            {/* Image */}
            {loading ? (
              <Skeleton variant="rectangular" width={100} height={120} />
            ) : (
              <Image
                src={img.src} // Use the image path dynamically from the array
                alt={img.title}
                width={100} // Reduced width
                height={120} // Reduced height
                className="object-cover rounded-md"
              />
            )}

            {/* Title (name) */}
            <div className="ml-4 text-lg font-semibold text-gray-800">
              {img.title}
            </div>
          </Paper>
        ))}
       
      </Link>

      {/* Section 2 */}
      <div className="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {images.map((img, idx) => (
          <Paper
            elevation={3} // Same as before, subtle shadow
            key={idx + images.length} // Ensure unique key for each item
            className={`${
              idx % 2 === 0 ? 'bg-red-300' : 'bg-yellow-300'
            } p-3 rounded-lg flex flex-row items-center transform transition duration-300 hover:scale-105 hover:shadow-lg shadow-md`}
          >
            {/* Image */}
            {loading ? (
              <Skeleton variant="rectangular" width={100} height={120} />
            ) : (
              <Image
                src={img.src}
                alt={img.title}
                width={100}
                height={120}
                className="object-cover rounded-md"
              />
            )}

            {/* Title (name) */}
            <div className="ml-4 text-lg font-semibold text-gray-800">
              {img.title}
            </div>
          </Paper>
        ))}
      </div>

      {/* Section 3 */}
      <div className="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {images.map((img, idx) => (
          <Paper
            elevation={3} // Subtle shadow
            key={idx + 2 * images.length} // Ensure unique key
            className={`${
              idx % 2 === 0 ? 'bg-purple-300' : 'bg-pink-300'
            } p-3 rounded-lg flex flex-row items-center transform transition duration-300 hover:scale-105 hover:shadow-lg shadow-md`}
          >
            {/* Image */}
            {loading ? (
              <Skeleton variant="rectangular" width={100} height={120} />
            ) : (
              <Image
                src={img.src}
                alt={img.title}
                width={100}
                height={120}
                className="object-cover rounded-md"
              />
            )}

            {/* Title (name) */}
            <div className="ml-4 text-lg font-semibold text-gray-800">
              {img.title}
            </div>
          </Paper>
        ))}
      </div>
    </Dashboard>
  );
}

export default UserSetting;