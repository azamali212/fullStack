"use client";

import React, { useState, useEffect } from "react";
import Image from "next/image";
import { useRouter } from "next/navigation";
import { FaChevronDown } from "react-icons/fa";
import { sidebarItems } from "./sidebarItems";
import Link from "next/link";
import { logoutUser } from "../../../lib/slice/userSlice";
import { useDispatch } from "react-redux";

interface SidebarProps {
  isSidebarOpen: boolean;
  userRole: string;
  name: string;
  userImage?: string; // User's profile image URL (optional)
}

function Sidebar({
  isSidebarOpen,
  userRole,
  name: propName,
  userImage,
}: SidebarProps) {
  const [activeDropdown, setActiveDropdown] = useState<number | null>(null);
  const dispatch = useDispatch(); // Use the typed dispatch
  const router = useRouter();

  const [userName, setUserName] = useState<string | null>(null);

  useEffect(() => {
    const storedName = localStorage.getItem("name");

    if (!propName) {
      setUserName(storedName);
    }
  }, [propName]);

  const handleDropdown = (index: number) => {
    setActiveDropdown(activeDropdown === index ? null : index);
  };

  const handleLogout = async () => {
    try {
      await dispatch(logoutUser()).unwrap(); // Ensure proper handling of the thunk result
      router.push("/auth/login");
    } catch (error) {
      console.error("Logout failed:", error);
    }
  };

  // Filter sidebar items based on userRole
  const filteredItems = sidebarItems.filter((item) => {
    return !item.role || item.role.length === 0 || item.role.includes(userRole);
  });

  return (
    <aside
      className={`p-4 text-white h-full rounded-full min-h-screen transition-all duration-300 ${
        isSidebarOpen ? "w-64" : "w-20"
      }`}
    >
      {/* Profile Section */}
      <div className="flex items-center mb-6 p-2 transition-all duration-300">
        {userImage ? (
          <div
            className={`relative rounded-full border-2 border-indigo-500 overflow-hidden transition-all ${
              isSidebarOpen ? "w-12 h-12" : "w-8 h-8"
            }`}
          >
            <Image
              src={userImage}
              alt="User Profile"
              layout="fill"
              objectFit="cover"
              priority
            />
          </div>
        ) : (
          <div
            className={`flex items-center justify-center rounded-full border-2 border-indigo-500 bg-gray-500 text-white transition-all ${
              isSidebarOpen ? "w-12 h-12" : "w-8 h-8"
            }`}
          >
            {userName ? userName[0] : "U"}
          </div>
        )}
        {isSidebarOpen && (
          <div className="ml-4">
            <h5 className="text-lg font-semibold">{userName}</h5>
            <span className="text-sm text-indigo-300">{userRole}</span>
          </div>
        )}
      </div>

      <ul>
        {filteredItems.length > 0 ? (
          filteredItems.map((item, index) => (
            <li key={index} className="mb-2 p-2">
              <div
                className={`flex items-center cursor-pointer p-2 rounded-md hover:bg-gray-700 transition-colors duration-200 ${
                  isSidebarOpen ? "justify-between" : "justify-center"
                }`}
                onClick={() =>
                  item.label === "Logout"
                    ? handleLogout()
                    : handleDropdown(index)
                }
              >
                <div className="flex items-center">
                  {item.icon && (
                    <item.icon className="mr-2 w-4 h-4 text-indigo-400" />
                  )}
                  {isSidebarOpen && (
                    <span className="hover:text-indigo-300">{item.label}</span>
                  )}
                </div>
                {item.subItems && item.label !== "Logout" && (
                  <span
                    className={`transform transition-transform duration-300 ${
                      activeDropdown === index ? "rotate-180" : ""
                    }`}
                  >
                    <FaChevronDown className="w-3 h-3" />
                  </span>
                )}
              </div>
              {item.subItems && (
                <ul
                  className={`ml-6 overflow-hidden transition-all duration-500 ease-in-out border-l-2 ${
                    activeDropdown === index
                      ? "max-h-screen opacity-100 border-indigo-400"
                      : "max-h-0 opacity-0 border-transparent"
                  }`}
                >
                  {item.subItems
                    .filter(
                      (subItem) =>
                        !subItem.role || subItem.role.includes(userRole)
                    )
                    .map((subItem, subIndex) => (
                      <li key={subIndex} className="flex p-2 items-center mt-2">
                        {subItem.icon && (
                          <subItem.icon className="mr-2 w-4 h-4 text-gray-400" />
                        )}
                        {isSidebarOpen && (
                          <Link
                            href={subItem.href}
                            className="hover:text-indigo-300 transition-colors duration-200"
                          >
                            {subItem.label}
                          </Link>
                        )}
                      </li>
                    ))}
                </ul>
              )}
            </li>
          ))
        ) : (
          <li>No Sidebar Items Available</li>
        )}
      </ul>
    </aside>
  );
}

export default Sidebar;
