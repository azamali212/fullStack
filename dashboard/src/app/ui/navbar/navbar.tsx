import React, { useState, useEffect } from "react";
import Image from "next/image";
import { Menu, MenuItem, Button, Modal } from "@mui/material";
import SearchIcon from "@mui/icons-material/Search";
import InputBase from "@mui/material/InputBase";
import { useRouter } from "next/navigation";
import "./style.css";
import { logoutUser } from "@/lib/slice/userSlice";
import { AppDispatch } from "@/lib/store";
import { useDispatch } from "react-redux";

function Navbar() {
  const [anchorEl, setAnchorEl] = useState<null | HTMLElement>(null);
  const [isSearchModalOpen, setSearchModalOpen] = useState(false);
  const [isSearchExpanded, setSearchExpanded] = useState(false);
  const router = useRouter();
  const dispatch = useDispatch<AppDispatch>(); 

  // Handle opening of menu
  const handleClick = (event: React.MouseEvent<HTMLElement>) => {
    setAnchorEl(event.currentTarget);
  };

  // Handle closing of menu
  const handleClose = () => {
    setAnchorEl(null);
  };

  // Search click logic
  const handleSearchClick = () => {
    setSearchExpanded(true);
    setSearchModalOpen(true);
  };

  // Logout handler
  const handleLogout = async () => {
    console.log("Logout started...");
    try {
      await dispatch(logoutUser()).unwrap();
      console.log("Logout successful!");
      router.push("/auth/login");
    } catch (error) {
      console.error("Logout failed:", error);
    }
  };

  // Close modal handler
  const handleCloseModal = () => {
    setSearchExpanded(false);
    setSearchModalOpen(false);
  };

  return (
    <nav className="flex flex-row justify-between items-center">
      <div>
        <div
          className={`search-container ${isSearchExpanded ? "expanded" : ""}`}
          onClick={handleSearchClick}
        >
          <InputBase
            placeholder="Search..."
            sx={{
              backgroundColor: "rgba(255, 254, 254, 0.819)",
              borderRadius: "5px",
              paddingLeft: 1,
              transition: "width 0.5s ease",
              width: isSearchExpanded ? "400px" : "200px",
            }}
            startAdornment={<SearchIcon />}
          />
        </div>
      </div>

      <ul className="flex space-x-6">
        <li className="hover:text-gray-400 cursor-pointer">
          <Button onClick={handleClick} style={{ padding: 0, minWidth: 0 }}>
            <Image
              src="/images/bookmark.png"
              alt="Bookmark"
              width={20}
              height={20}
            />
          </Button>
          <Menu
            anchorEl={anchorEl}
            open={Boolean(anchorEl)}
            onClose={handleClose}
            sx={{ backgroundColor: "rgba(0, 0, 0, 0.3)" }}
          >
            <MenuItem onClick={handleClose}>Profile</MenuItem>
            <MenuItem onClick={handleClose}>Language settings</MenuItem>
            <MenuItem onClick={handleLogout}>Log out</MenuItem>
          </Menu>
        </li>
        <li className="hover:text-gray-400 cursor-pointer">
          <Button onClick={handleClick} style={{ padding: 0, minWidth: 0 }}>
            <Image
              src="/images/bookmark.png"
              alt="Bookmark"
              width={20}
              height={20}
            />
          </Button>
          <Menu
            anchorEl={anchorEl}
            open={Boolean(anchorEl)}
            onClose={handleClose}
            sx={{ backgroundColor: "rgba(0, 0, 0, 0.3)" }}
          >
            <MenuItem onClick={handleClose}>Profile</MenuItem>
            <MenuItem onClick={handleClose}>Language settings</MenuItem>
            <MenuItem onClick={handleLogout}>Log out</MenuItem>
          </Menu>
        </li>
        <li className="hover:text-gray-400 cursor-pointer">
          <Button onClick={handleClick} style={{ padding: 0, minWidth: 0 }}>
            <Image
              src="/images/bookmark.png"
              alt="Bookmark"
              width={20}
              height={20}
            />
          </Button>
          <Menu
            anchorEl={anchorEl}
            open={Boolean(anchorEl)}
            onClose={handleClose}
            sx={{ backgroundColor: "rgba(0, 0, 0, 0.3)" }}
          >
            <MenuItem onClick={handleClose}>Profile</MenuItem>
            <MenuItem onClick={handleClose}>Language settings</MenuItem>
            <MenuItem onClick={handleLogout}>Log out</MenuItem>
          </Menu>
        </li>
        {/* Other menu items */}
      </ul>

      <Modal
        open={isSearchModalOpen}
        onClose={handleCloseModal}
        aria-labelledby="search-modal"
        aria-describedby="search-modal-description"
      >
        <div className="modal-content">
          <div className="search-input-container">
            <InputBase
              placeholder="Search..."
              sx={{
                width: "100%",
                padding: 2,
                backgroundColor: "white",
                borderRadius: "5px",
              }}
              startAdornment={<SearchIcon />}
            />
            <Button onClick={handleCloseModal} sx={{ marginTop: 2 }}>
              Close Search
            </Button>
          </div>
        </div>
      </Modal>
    </nav>
  );
}

export default Navbar;
