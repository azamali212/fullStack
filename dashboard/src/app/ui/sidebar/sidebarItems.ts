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
      { label: 'Manage Hospitals', href: '/pages/hospital', icon: FaHospital, role: ['Hospital Administrator', 'System Administrator'] },
      { label: 'Doctor Panel', href: '#', icon: FaUserMd, role: ['System Administrator'] },
      { label: 'User Settings', href: '/pages/userSetting', icon: FaRegUser, role: ['System Administrator'] }
    ]
  },
  {
    label: 'Applications',
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
    label: 'Social Accounts ',
    href: '#',
    icon: FaHome,
    role: ['System Administrator'],
    subItems: [
      { label: 'Mobile Panel', href: '#', icon: FaHospital, role: ['Hospital Administrator', 'System Administrator'] },
      { label: 'Social Panel', href: '#', icon: FaUserMd, role: ['System Administrator'] },
    ]
  },
  {
    label: 'Tasks',
    href: '#',
    icon: FaHome,
    role: ['System Administrator'],
    subItems: [
      { label: 'Hospital Panel', href: '#', icon: FaHospital, role: ['Hospital Administrator', 'System Administrator'] },
      { label: 'Doctor Panel', href: '#', icon: FaUserMd, role: ['System Administrator'] },
      { label: 'User Settings', href: '/pages/userSetting', icon: FaRegUser, role: ['System Administrator'] }
    ]
  },
  {
    label: 'Users',
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
    label: 'Employee',
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
    label: 'Data Control',
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
    label: 'Calender',
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
    label: 'Email',
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
    label: 'Notifications',
    href: '#',
    icon: FaSignOutAlt,
    role: ['Hospital Administrator', 'System Administrator'],
  },
  {
    label: 'Payments',
    href: '#',
    icon: FaSignOutAlt,
    role: ['Hospital Administrator', 'System Administrator'],
  },
  {
    label: 'Departments',
    href: '#',
    icon: FaSignOutAlt,
    role: ['Hospital Administrator', 'System Administrator'],
  },
  {
    label: 'Logout',
    href: '#',
    icon: FaSignOutAlt,
    role: []
  }
];