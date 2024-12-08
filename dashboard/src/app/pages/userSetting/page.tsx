'use client';

import React, { useState, useEffect } from 'react';
import Link from 'next/link';
import Image from 'next/image';
import Paper from '@mui/material/Paper';
import Skeleton from '@mui/material/Skeleton';
import Dashboard from '@/app/components/layout';

function UserSetting() {
  const [loading, setLoading] = useState(true);

  // Simulate a loading effect
  useEffect(() => {
    const timer = setTimeout(() => {
      setLoading(false);
    }, 1000);
    return () => clearTimeout(timer);
  }, []);

  // Define the cards array with routes
  const cards = [
    { src: "/images/management.png", title: "Role", route: "/pages/userRole" },
    { src: "/images/user.png", title: "Permission", route: "/pages/userPermissions" },
    { src: "/images/image1.png", title: "User", route: "/pages/user" },
    // Add more cards here as needed
  ];

  return (
    <Dashboard
      userRole="System Administrator"
      userImage=""
      userName="Admin"
      className=""
    >
      <div className="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {cards.map((card, idx) => (
          <Link href={card.route} key={idx} className="transform transition duration-300 hover:scale-105">
            <Paper
              elevation={3}
              className={`${
                idx % 2 === 0 ? 'bg-blue-300' : 'bg-green-300'
              } p-3 rounded-lg flex flex-row items-center shadow-md hover:shadow-lg`}
            >
              {loading ? (
                <Skeleton variant="rectangular" width={100} height={120} />
              ) : (
                <Image
                  src={card.src}
                  alt={card.title}
                  width={100}
                  height={120}
                  className="object-cover rounded-md"
                />
              )}
              <div className="ml-4 text-lg font-semibold text-gray-800">
                {card.title}
              </div>
            </Paper>
          </Link>
        ))}
      </div>
    </Dashboard>
  );
}

export default UserSetting;