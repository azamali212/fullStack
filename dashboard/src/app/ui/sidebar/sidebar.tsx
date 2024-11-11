'use client';
import React, { useState } from 'react';
import { sidebarItems } from './sidebarItems';
import { FaChevronDown } from 'react-icons/fa'; // Icon for dropdown indicator

function Sidebar({ isSidebarOpen }: { isSidebarOpen: boolean }) {
  const [activeDropdown, setActiveDropdown] = useState<number | null>(null);

  const handleDropdown = (index: number) => {
    setActiveDropdown(activeDropdown === index ? null : index);
  };

  return (
    <aside
      className={`p-4 text-white h-full min-h-screen transition-all duration-300 ${
        isSidebarOpen ? 'w-64' : 'w-20'
      }`}
    >
      <ul>
        {sidebarItems.map((item, index) => (
          <li key={index} className="mb-2 p-2">
            <div
              className={`flex items-center cursor-pointer p-2 rounded-md hover:bg-gray-700 transition-colors duration-200 ${
                isSidebarOpen ? 'justify-between' : 'justify-center'
              }`}
              onClick={() => handleDropdown(index)}
            >
              <div className="flex items-center">
                {item.icon && (
                  <item.icon className="mr-2 w-4 h-4 text-indigo-400" />
                )}
                <a href={item.href} className="hover:text-indigo-300">
                  {item.label}
                </a>
              </div>
              {item.subItems && (
                <span
                  className={`transform transition-transform duration-300 ${
                    activeDropdown === index ? 'rotate-180' : ''
                  }`}
                >
                  <FaChevronDown className="w-3 h-3" />
                </span>
              )}
            </div>
            {item.subItems && (
              <ul
                className={`ml-6 overflow-hidden transition-all duration-500 ease-in-out ${
                  activeDropdown === index
                    ? 'max-h-screen opacity-100'
                    : 'max-h-0 opacity-0'
                }`}
                style={{
                  transitionProperty: 'max-height, opacity',
                }}
              >
                {item.subItems.map((subItem, subIndex) => (
                  <li key={subIndex} className="flex p-2  items-center mt-2">
                    {subItem.icon && (
                      <subItem.icon className="mr-2 w-4 h-4 text-gray-400" />
                    )}
                    <a
                      href={subItem.href}
                      className="hover:text-indigo-300 transition-colors duration-200 whitespace-nowrap"
                    >
                      {subItem.label}
                    </a>
                  </li>
                ))}
              </ul>
            )}
          </li>
        ))}
      </ul>
    </aside>
  );
}

export default Sidebar;