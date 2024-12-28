import React, { useState } from "react";
import { useSelector, useDispatch } from "react-redux";
import { RootState } from "@/lib/store";
import { deleteUser } from "@/lib/slice/adminSlice";
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  TablePagination,
  Paper,
  TextField,
  Grid,
  Typography,
  IconButton,
  Tooltip,
  Menu,
  MenuItem,
  Snackbar,
  Button,
} from "@mui/material";
import { Line } from "react-chartjs-2";
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip as ChartTooltip,
  Legend,
} from "chart.js";
import SearchIcon from "@mui/icons-material/Search";
import MoreVertIcon from "@mui/icons-material/MoreVert";
import MuiAlert from "@mui/material/Alert";
import AddUserModal from "./models/userModel"; // Assuming the modal is in this path
import EditUserModal from "./models/editUserModel"; // Import the EditUserModal
import { getUsers } from "@/lib/slice/adminSlice";
import { AppDispatch } from "@/lib/store";
import ShowUserModel from "./models/showSingleUser";

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  ChartTooltip,
  Legend
);
interface Admin {
  id: number;
  name: string;
  email: string;
  password: string;
  roles: { name: string }[];
  permission: { name: string }[];
  hospital?: {
    name: string;
  };
}

function UserData() {
  const [searchTerm, setSearchTerm] = useState("");
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [anchorEl, setAnchorEl] = useState<null | HTMLElement>(null);
  const [openSnackbar, setOpenSnackbar] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [openAddModal, setOpenAddModal] = useState(false);
  const [openEditModal, setOpenEditModal] = useState(false);
  const [selectedUser, setSelectedUser] = useState<Admin | null>(null); // Selected user for editing
  const [openViewModal, setOpenViewModal] = useState(false);
  const [viewedUser, setViewedUser] = useState<Admin | null>(null);

  const dispatch = useDispatch<AppDispatch>();

  const { users, status } = useSelector((state: RootState) => state.admins);

  if (status === "loading") {
    return <div>Loading...</div>;
  }

  const handleViewUser = (user: Admin) => {
    setViewedUser(user); // Set the user to be viewed
    setOpenViewModal(true); // Open the modal
  };

  const handleSearchChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setSearchTerm(event.target.value);
    setPage(0); // Reset pagination when search term changes
  };

  const handleChangePage = (event: unknown, newPage: number) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (
    event: React.ChangeEvent<HTMLInputElement>
  ) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  // Filter users
  const filteredUsers = Array.isArray(users)
    ? users.filter((user) => {
        return (
          (user.name &&
            user.name.toLowerCase().includes(searchTerm.toLowerCase())) ||
          (user.email &&
            user.email.toLowerCase().includes(searchTerm.toLowerCase())) ||
          (user.role &&
            user.role.name.toLowerCase().includes(searchTerm.toLowerCase()))
        );
      })
    : [];

  const roles = Array.isArray(users)
    ? users.flatMap((user) =>
        Array.isArray(user.roles) ? user.roles.map((role) => role.name) : []
      )
    : [];

  const roleCounts = roles.reduce((acc: { [key: string]: number }, role) => {
    acc[role] = (acc[role] || 0) + 1;
    return acc;
  }, {});

  const doctorCount = roleCounts["Doctor"] || 0; // Specific role (Doctor)

  const chartData = {
    labels: Object.keys(roleCounts), // Role names
    datasets: [
      {
        label: "Total Users by Role",
        data: Object.values(roleCounts), // Count of each role
        fill: false,
        borderColor: "rgb(75, 192, 192)",
        tension: 0.1,
      },
      {
        label: "Doctor Role Count",
        data: Object.keys(roleCounts).map((role) =>
          role === "Doctor" ? roleCounts[role] : null
        ),
        fill: false,
        borderColor: "rgb(255, 99, 132)",
        borderDash: [5, 5],
        tension: 0.1,
      },
    ],
  };

  const paginatedUsers = filteredUsers.slice(
    page * rowsPerPage,
    page * rowsPerPage + rowsPerPage
  );

  const handleDelete = (userId: number) => {
    dispatch(deleteUser(userId))
      .unwrap()
      .then(() => {
        setSnackbarMessage("User deleted successfully!");
      })
      .catch((error) => {
        console.error("Failed to delete user:", error);
        setSnackbarMessage("Failed to delete user.");
      });
    setOpenSnackbar(true);
    setAnchorEl(null); // Close menu after action
  };

  const handleEdit = (user: Admin) => {
    setSelectedUser(user); // Set the user to be edited
    setOpenEditModal(true); // Open the edit modal
    setAnchorEl(null); // Close menu
  };

  const handleUserUpdated = () => {
    setOpenEditModal(false); // Close the modal
    setSelectedUser(null); // Clear the selected user
    dispatch(getUsers());
  };

  const handleClosePermissions = () => {
    setAnchorEl(null); // Close menu
  };

  // Function to handle when a user is added (close modal and refresh the table)
  const handleUserAdded = () => {
    // Close the modal
    setOpenAddModal(false);
    dispatch(getUsers());
  };

  return (
    <div style={{ padding: "24px", backgroundColor: "#f5f5f5" }}>
      <Grid
        container
        spacing={2}
        justifyContent="space-between"
        alignItems="center"
        sx={{ mb: 3 }}
      >
        <Grid item xs={8}>
          <Typography variant="h6" gutterBottom>
            User Management
          </Typography>
        </Grid>
        <Grid item xs={12} sm={6}>
          <TextField
            variant="outlined"
            fullWidth
            placeholder="Search users..."
            value={searchTerm}
            onChange={handleSearchChange}
            InputProps={{
              startAdornment: <SearchIcon sx={{ mr: 1, color: "grey.500" }} />,
            }}
          />
        </Grid>
        <Grid item xs={12} sm={6} container justifyContent="flex-end">
          <Button
            variant="contained"
            color="primary"
            onClick={() => setOpenAddModal(true)} // Open modal on button click
          >
            Add User
          </Button>
        </Grid>
      </Grid>

      <TableContainer component={Paper}>
        <Table aria-label="Users Table">
          <TableHead>
            <TableRow>
              <TableCell
                sx={{
                  backgroundColor: "#2227436c",
                  color: "#fff",
                  fontWeight: "bold",
                }}
              >
                ID
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#2227436c",
                  color: "#fff",
                  fontWeight: "bold",
                }}
              >
                Name
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#2227436c",
                  color: "#fff",
                  fontWeight: "bold",
                }}
              >
                Email
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#2227436c",
                  color: "#fff",
                  fontWeight: "bold",
                }}
              >
                Role
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#2227436c",
                  color: "#fff",
                  fontWeight: "bold",
                }}
              >
                Hospital
              </TableCell>
              <TableCell
                sx={{
                  backgroundColor: "#2227436c",
                  color: "#fff",
                  fontWeight: "bold",
                }}
              >
                Actions
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {paginatedUsers.map((user) => (
              <TableRow key={user.id}>
                <TableCell>{user.id}</TableCell>
                <TableCell>{user.name}</TableCell>
                <TableCell>{user.email}</TableCell>
                <TableCell>
                  {/* Check if roles exist and map through them */}
                  {user.roles && user.roles.length > 0
                    ? user.roles.map((role, index) => (
                        <span key={index}>
                          {role.name}
                          {index < user.roles.length - 1 && ", "}
                        </span>
                      ))
                    : "No Role Assigned"}
                </TableCell>
                <TableCell>
                  {user.hospital ? user.hospital.name : "No Hospital"}
                </TableCell>
                <TableCell>
                  <Tooltip title="More Actions">
                    <IconButton onClick={(e) => setAnchorEl(e.currentTarget)}>
                      <MoreVertIcon />
                    </IconButton>
                  </Tooltip>
                  <Menu
                    anchorEl={anchorEl}
                    open={Boolean(anchorEl)}
                    onClose={handleClosePermissions}
                  >
                    <MenuItem onClick={() => handleEdit(user)}>Edit</MenuItem>
                    <MenuItem onClick={() => handleDelete(user.id)}>
                      Delete
                    </MenuItem>
                    <MenuItem onClick={() => handleViewUser(user)}>
                      View Details
                    </MenuItem>
                  </Menu>
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </TableContainer>

      <TablePagination
        component="div"
        count={filteredUsers.length}
        page={page}
        onPageChange={handleChangePage}
        rowsPerPage={rowsPerPage}
        onRowsPerPageChange={handleChangeRowsPerPage}
      />

      <Snackbar
        open={openSnackbar}
        autoHideDuration={6000}
        onClose={() => setOpenSnackbar(false)}
      >
        <MuiAlert
          onClose={() => setOpenSnackbar(false)}
          severity="success"
          sx={{ width: "100%" }}
        >
          {snackbarMessage}
        </MuiAlert>
      </Snackbar>

      {/* Add User Modal */}
      <AddUserModal
        open={openAddModal}
        handleClose={() => setOpenAddModal(false)}
        onUserAdded={handleUserAdded}
      />

      {/* Show User Modal */}
      <ShowUserModel
        open={openViewModal}
        user={viewedUser}
        handleClose={() => setOpenViewModal(false)}
        handleEditClick={() => {
          setOpenViewModal(false); // Close the view modal
          setSelectedUser(viewedUser); // Set the selected user for editing
          setOpenEditModal(true); // Open the edit modal
        }}
      />

      {/* Edit User Modal */}
      {selectedUser && (
        <EditUserModal
          open={openEditModal}
          handleClose={() => setOpenEditModal(false)}
          user={selectedUser}
          onUserUpdated={handleUserUpdated}
        />
      )}

      {/* Chart Section */}
      <div style={{ marginTop: "50px" }}>
        <Typography variant="h6" gutterBottom>
          User Distribution by Role
        </Typography>
        <Line data={chartData} />
      </div>
    </div>
  );
}

export default UserData;
