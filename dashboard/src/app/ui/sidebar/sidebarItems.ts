'use client';
import { IconType } from "react-icons"; // Import the type for icons
import { FaHome, FaCog, FaUser, FaSignOutAlt, FaHospital,FaUserMd,FaRegUser
} from "react-icons/fa"; // Import example icons
import { AiOutlineAppstore } from "react-icons/ai"; 
import { TfiControlEject } from "react-icons/tfi"; // Additional icon from Ai library
import { MdOutlineSettingsInputComponent } from "react-icons/md";
import { FaUserGroup } from "react-icons/fa6";

interface SidebarItem {
  label: string;
  href: string;
  icon?: IconType; // Add icon property
  subItems?: SidebarItem[];
}


export const sidebarItems: SidebarItem[] = [
  { 
    label: 'Dashboard', 
    href: '#', 
    icon: FaHome, // Use FaHome icon for Dashboard
    subItems:[
      { label: 'Hospital Panel', href: '#', icon: FaHospital }, // Use FaHospital for Hospital Panel
      { label: 'Doctor Panel', href: '#', icon: FaUserMd }, // Use AiOutlineAppstore for Doctor Panel
      { label: 'User Settings', href: '#' ,icon: FaRegUser},
      { label: 'Role Settings', href: '#',icon: TfiControlEject},
      { label: 'Permissions Settings', href: '#',icon: MdOutlineSettingsInputComponent },
      { label: 'Staff Settings', href: '#',icon: FaUserGroup }
    ]
  },
  { 
    label: 'Settings', 
    href: '#', 
    icon: FaCog, // Use FaCog icon for Settings
    subItems: [
      { label: 'Account Settings', href: '#' },
      { label: 'Privacy Settings', href: '#' }
    ]
  },
  { 
    label: 'Profile', 
    href: '#', 
    icon: FaUser, // Use FaUser icon for Profile
    subItems: [
      { label: 'Edit Profile', href: '#' },
      { label: 'View Profile', href: '#' }
    ]
  },
  { 
    label: 'Logout', 
    href: '#', 
    icon: FaSignOutAlt // Use FaSignOutAlt icon for Logout
  },
  { label: 'Another Item', href: '#', icon: AiOutlineAppstore } // Example of another icon
];