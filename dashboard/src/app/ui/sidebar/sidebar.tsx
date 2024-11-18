import React, { useState } from 'react';
import { FaChevronDown } from 'react-icons/fa';
import { SidebarItem, sidebarItems } from './sidebarItems';

interface SidebarProps {
  isSidebarOpen: boolean;
  userRole: string; // Role passed from Dashboard
}

function Sidebar({ isSidebarOpen, userRole }: SidebarProps) {
  const [activeDropdown, setActiveDropdown] = useState<number | null>(null);

  const handleDropdown = (index: number) => {
    setActiveDropdown(activeDropdown === index ? null : index);
  };

  // Filter sidebar items based on userRole
  const filteredItems = sidebarItems.filter((item) => {
    return !item.role || item.role.includes(userRole);
  });

  return (
    <aside
      className={`p-4 text-white h-full min-h-screen transition-all duration-300 ${
        isSidebarOpen ? 'w-64' : 'w-20'
      }`}
    >
      <ul>
        {filteredItems.length > 0 ? (
          filteredItems.map((item, index) => (
            <li key={index} className="mb-2 p-2">
              <div
                className={`flex items-center cursor-pointer p-2 rounded-md hover:bg-gray-700 transition-colors duration-200 ${
                  isSidebarOpen ? 'justify-between' : 'justify-center'
                }`}
                onClick={() => handleDropdown(index)} // Handle dropdown toggle
              >
                <div className="flex items-center">
                  {item.icon && <item.icon className="mr-2 w-4 h-4 text-indigo-400" />}
                  {isSidebarOpen && (
                    <a href={item.href} className="hover:text-indigo-300">
                      {item.label}
                    </a>
                  )}
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
                    activeDropdown === index ? 'max-h-screen opacity-100' : 'max-h-0 opacity-0'
                  }`}
                >
                  {item.subItems.filter((subItem) => !subItem.role || subItem.role.includes(userRole)).map(
                    (subItem, subIndex) => (
                      <li key={subIndex} className="flex p-2 items-center mt-2">
                        {subItem.icon && <subItem.icon className="mr-2 w-4 h-4 text-gray-400" />}
                        {isSidebarOpen && (
                          <a href={subItem.href} className="hover:text-indigo-300 transition-colors duration-200">
                            {subItem.label}
                          </a>
                        )}
                      </li>
                    )
                  )}
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