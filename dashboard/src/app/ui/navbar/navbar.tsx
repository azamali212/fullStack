'use client';
import React from 'react';

function Navbar() {
  return (
    <nav className="p-4 flex justify-between items-center">
      {/* Logo or Brand */}

      {/* Navigation Links */}
      <ul className="flex space-x-6">
        <li className="hover:text-gray-400 cursor-pointer">Home</li>
        <li className="hover:text-gray-400 cursor-pointer">About</li>
        <li className="hover:text-gray-400 cursor-pointer">Services</li>
        <li className="hover:text-gray-400 cursor-pointer">Contact</li>
        <li className="hover:text-gray-400 cursor-pointer">Profile</li>
      </ul>
    </nav>
  );
}

export default Navbar;