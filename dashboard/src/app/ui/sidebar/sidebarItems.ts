import { FaHome, FaCog, FaUser, FaSignOutAlt, FaHospital, FaUserMd, FaRegUser } from "react-icons/fa";
import { IconType } from "react-icons";

export interface SidebarItem {
  label: string;
  href: string;
  icon?: IconType;
  role?: string[]; // Role-based access control
  subItems?: SidebarItem[];
}

// Example sidebar items with roles
export const sidebarItems: SidebarItem[] = [
  {
    label: 'Dashboard',
    href: '#',
    icon: FaHome,
    role: ['System Administrator'],
    subItems: [
      { label: 'Hospital Panel', href: '#', icon: FaHospital, role: ['Hospital Administrator', 'System Administrator'] },
      { label: 'Doctor Panel', href: '#', icon: FaUserMd, role: ['System Administrator'] },
      { label: 'User Settings', href: '#', icon: FaRegUser, role: ['System Administrator'] }
    ]
  },
  {
    label: 'Settings',
    href: '#',
    icon: FaCog,
    role: ['System Administrator'],
    subItems: [
      { label: 'Account Settings', href: '#', role: ['System Administrator'] },
      { label: 'Privacy Settings', href: '#', role: ['System Administrator'] }
    ]
  },
  {
    label: 'Profile',
    href: '#',
    icon: FaUser,
    role: ['Hospital Administrator', 'System Administrator'],
    subItems: [
      { label: 'Edit Profile', href: '#', role: ['Hospital Administrator', 'System Administrator'] },
      { label: 'View Profile', href: '#', role: ['Hospital Administrator', 'System Administrator'] }
    ]
  },
  {
    label: 'Logout',
    href: '#',
    icon: FaSignOutAlt,
    role: ['Hospital Administrator', 'System Administrator']
  }
];