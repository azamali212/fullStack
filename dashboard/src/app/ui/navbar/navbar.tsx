"use client";
import React, { useState, useEffect } from "react";
import Image from "next/image";
import { Menu, MenuItem, Modal, InputBase } from "@mui/material";
import SearchIcon from "@mui/icons-material/Search";
import { useRouter, usePathname } from "next/navigation";
import { logoutUser } from "@/lib/slice/userSlice";
import { AppDispatch } from "@/lib/store";
import Link from "next/link";
import { useDispatch } from "react-redux";

function Navbar() {
  const [anchorEl, setAnchorEl] = useState<null | HTMLElement>(null);
  const [isSearchModalOpen, setSearchModalOpen] = useState(false);
  const router = useRouter();
  const [pageTitle, setPageTitle] = useState<string>("Dashboard");
  const pathname = usePathname();

  const dispatch = useDispatch<AppDispatch>();

  const handleClick = (event: React.MouseEvent<HTMLElement>) => {
    setAnchorEl(event.currentTarget);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };

  const handleSearchClick = () => {
    setSearchModalOpen(true);
  };

  const handleCloseModal = () => {
    setSearchModalOpen(false);
  };

  const handleLogout = async () => {
    try {
      await dispatch(logoutUser()).unwrap();
      router.push("/auth/login");
    } catch (error) {
      console.error("Logout failed:", error);
    }
  };

  useEffect(() => {
    const pageTitles: Record<string, string> = {
      "/": "Dashboard",
      "/pages/userRole": "Role Page",
      "/pages/userPermissions": "Permission Page",
    };
    setPageTitle(pageTitles[pathname] || "Dashboard");

    // No return value here (which is expected behavior)
  }, [pathname]);

  return (
    <nav className="shadow-md flex w-full items-center justify-between">
      {/* Left Section (Logo + Search) */}
      <div className="flex items-center space-x-4 pl-6">
        <Link
          href="/dashboard/superAdmin/dashboard"
          className="flex items-center p-2"
        >
          <Image
            src="/images/user.png"
            alt="User"
            width={40}
            height={40}
            className="rounded-full"
          />
        </Link>
      </div>

      {/* Page Title */}

      {/* Right Section (Profile + Notifications) */}
      <div className="flex items-center space-x-4">
        <div className="relative hidden md:flex">
          <input
            type="search"
            placeholder="Search"
            className="px-4 py-2 w-72 rounded-full border border-gray-300 focus:outline-none text-black focus:ring-2 focus:ring-blue-500"
          />
          <button
            onClick={handleSearchClick}
            className="absolute right-0 top-0 flex items-center justify-center h-full w-10 rounded-r-full bg-blue-500 text-white"
          >
            <SearchIcon />
          </button>
        </div>

        <a
          href="#"
          className="relative text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80"
          data-twe-nav-link-ref
        >
          <span className="[&>svg]:h-6 [&>svg]:w-6">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fillRule="evenodd"
                d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z"
                clipRule="evenodd"
              />
            </svg>
          </span>

          <span className="absolute -mt-7 ms-4 rounded-full bg-danger px-[0.50em] py-[0.25em] text-[0.8rem] font-bold text-2xl leading-none text-rose-600">
            1
          </span>
        </a>

        <a
          className="text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80"
          href="#"
          data-twe-nav-link-ref
        >
          <span className="[&>svg]:h-6 [&>svg]:w-6">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fillRule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z"
                clipRule="evenodd"
              />
            </svg>
          </span>
        </a>

        <a
          className="hidden-arrow flex items-center text-black/60 transition duration-200 hover:text-black/80 hover:ease-in-out focus:text-black/80 active:text-black/80 motion-reduce:transition-none dark:text-white/60 dark:hover:text-white/80 dark:focus:text-white/80 dark:active:text-white/80"
          href="#"
          id="dropdownMenuButton1"
          role="button"
          data-twe-dropdown-toggle-ref
          aria-expanded="false"
        >
          <span className="[&>svg]:h-6 [&>svg]:w-6">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path d="M3.505 2.365A41.369 41.369 0 019 2c1.863 0 3.697.124 5.495.365 1.247.167 2.18 1.108 2.435 2.268a4.45 4.45 0 00-.577-.069 43.141 43.141 0 00-4.706 0C9.229 4.696 7.5 6.727 7.5 8.998v2.24c0 1.413.67 2.735 1.76 3.562l-2.98 2.98A.75.75 0 015 17.25v-3.443c-.501-.048-1-.106-1.495-.172C2.033 13.438 1 12.162 1 10.72V5.28c0-1.441 1.033-2.717 2.505-2.914z" />
              <path d="M14 6c-.762 0-1.52.02-2.271.062C10.157 6.148 9 7.472 9 8.998v2.24c0 1.519 1.147 2.839 2.71 2.935.214.013.428.024.642.034.2.009.385.09.518.224l2.35 2.35a.75.75 0 001.28-.531v-2.07c1.453-.195 2.5-1.463 2.5-2.915V8.998c0-1.526-1.157-2.85-2.729-2.936A41.645 41.645 0 0014 6z" />
            </svg>
          </span>

          <span className="absolute -mt-6 ms-5 rounded-full bg-danger px-[0.50em] py-[0.25em] text-[0.6rem] font-bold leading-none text-white">
            6
          </span>
        </a>

        <button onClick={handleClick} className="relative">
          <Image
            src="/images/user.png"
            alt="User"
            width={40}
            height={40}
            className="rounded-full"
          />
        </button>
        <Menu
          anchorEl={anchorEl}
          open={Boolean(anchorEl)}
          onClose={handleClose}
        >
          <MenuItem onClick={handleLogout}>Logout</MenuItem>
        </Menu>
      </div>

      {/* Search Modal */}
      <Modal
        open={isSearchModalOpen}
        onClose={handleCloseModal}
        aria-labelledby="search-modal-title"
        aria-describedby="search-modal-description"
      >
        <div className="flex justify-center items-center min-h-screen bg-gray-800 bg-opacity-50">
          <div className="bg-white rounded-md p-4 w-full max-w-lg">
            <InputBase
              placeholder="Search…"
              fullWidth
              inputProps={{ "aria-label": "search" }}
              className="p-4 border rounded-lg"
            />
          </div>
        </div>
      </Modal>
    </nav>
  );
}

export default Navbar;
