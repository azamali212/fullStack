"use client";
import React, { useState, useEffect } from "react";
import {
  Table,
  TableBody,
  TableCell,
  TableContainer,
  TableHead,
  TableRow,
  TablePagination,
  Paper,
  Typography,
  Button,
  Grid,
  Alert,
  TextField,
  Box,
  Tooltip,
  IconButton,
  Menu,
  MenuItem,
  Snackbar,
  Alert as MuiAlert,
} from "@mui/material";
import SearchIcon from "@mui/icons-material/Search";
import MoreVertIcon from "@mui/icons-material/MoreVert";
import { useDispatch, useSelector } from "react-redux";
import { AppDispatch, RootState } from "@/lib/store";
import { deleteRole, fetchRole } from "@/lib/slice/userRoleSlice";
import Dashboard from "@/app/components/layout";
import AddRoleModal from "./models/roleModel";
import EditRoleModal from "./models/editRoleModel";
import DeleteRoleModal from "./models/deleteRoleModel";

const UserRole = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [anchorEl, setAnchorEl] = useState<null | HTMLElement>(null);
  const [selectedPermissions, setSelectedPermissions] = useState<
    string[] | null
  >(null);

  const [roleToEdit, setRoleToEdit] = useState<{
    id: number;
    name: string;
    permissions: number[];
  } | null>(null);

  const [openAddModal, setOpenAddModal] = useState(false);
  const [openEditModal, setOpenEditModal] = useState(false);
  const [openSnackbar, setOpenSnackbar] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [openDeleteModal, setOpenDeleteModal] = useState(false);
  const [roleToDelete, setRoleToDelete] = useState<string>("");
  const dispatch = useDispatch<AppDispatch>();

  const {
    roles: userRoles,
    loading,
    error,
  } = useSelector((state: RootState) => state.userRoles);

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      window.location.href = "/login";
    } else {
      dispatch(fetchRole());
    }
  }, [dispatch]);

  const handleSearchChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setSearchQuery(event.target.value);
    setPage(0);
  };

  const handleChangePage = (event: unknown, newPage: number) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event: React.ChangeEvent<HTMLInputElement>) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  const filteredRoles = userRoles.filter((role: any) =>
    role.name.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const handleOpenDeleteModal = (roleName: string) => {
    setRoleToDelete(roleName);
    setOpenDeleteModal(true);
  };

  const handleDeleteRole = () => {
    if (roleToDelete) {
      const roleId = userRoles.find((role) => role.name === roleToDelete)?.id;
      if (roleId) {
        dispatch(deleteRole(roleId));
        setSnackbarMessage("Role deleted successfully!");
        setOpenSnackbar(true);
      }
    }
  };

  const handleCloseDeleteModal = () => {
    setOpenDeleteModal(false);
    setRoleToDelete("");
  };

  const paginatedRoles = filteredRoles.slice(
    page * rowsPerPage,
    page * rowsPerPage + rowsPerPage
  );

  const handleOpenPermissions = (
    event: React.MouseEvent<HTMLElement>,
    permissions: string[] | { [key: string]: any }[]
  ) => {
    const formattedPermissions = permissions.map((permission) => {
      if (typeof permission === "string") {
        return permission;
      }
      return permission.name || JSON.stringify(permission);
    });

    setAnchorEl(event.currentTarget);
    setSelectedPermissions(formattedPermissions);
  };

  const handleClosePermissions = () => {
    setAnchorEl(null);
    setSelectedPermissions(null);
  };

  const handleOpenAddModal = () => {
    setOpenAddModal(true);
  };

  const handleCloseAddModal = () => {
    setOpenAddModal(false);
  };

  const handleOpenEditModal = (role: { id: number; name: string; permissions: number[] }) => {
    setRoleToEdit(role);
    setOpenEditModal(true);
  };

  const handleCloseEditModal = () => {
    setOpenEditModal(false);
    setRoleToEdit(null);
  };

  const handleRoleAdded = () => {
    setSnackbarMessage("Role added successfully!");
    setOpenSnackbar(true);
    setRoleToEdit(null);
    setSearchQuery("");
    setPage(0);
  };

  const handleRoleUpdated = () => {
    dispatch(fetchRole());
    setSnackbarMessage("Role updated successfully!");
    setOpenSnackbar(true);
  };

  return (
    <Dashboard userRole="System Administrator" userImage="" userName="" className="">
      <Box sx={{ p: 3 }}>
        <Grid container spacing={2} justifyContent="space-between" alignItems="center" sx={{ mb: 3 }}>
          <Grid item xs={8}>
            <Typography variant="h6" gutterBottom>
              Roles Management
            </Typography>
          </Grid>
          <Grid item xs={12} sm={6}>
            <TextField
              sx={{ width: "300px" }}
              variant="outlined"
              placeholder="Search roles..."
              value={searchQuery}
              onChange={handleSearchChange}
              InputProps={{
                startAdornment: <SearchIcon sx={{ mr: 1, color: "grey.500" }} />
              }}
            />
          </Grid>
        </Grid>

        {error && !error.includes("Token not found") && (
          <Alert severity="error" sx={{ mb: 2 }}>
            {error}
          </Alert>
        )}

        <TableContainer component={Paper}>
          <Table aria-label="Roles Table">
            <TableHead>
              <TableRow>
                <TableCell sx={tableHeaderStyle}>Role ID</TableCell>
                <TableCell sx={tableHeaderStyle}>Role Name</TableCell>
                <TableCell sx={tableHeaderStyle}>Permissions</TableCell>
                <TableCell sx={tableHeaderStyle}>Actions</TableCell>
                <TableCell sx={tableHeaderStyle}>
                  <Button variant="contained" color="primary" onClick={handleOpenAddModal}>
                    Add Role
                  </Button>
                </TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {paginatedRoles.map((role: any) => (
                <TableRow key={role.id}>
                  <TableCell>{role.id}</TableCell>
                  <TableCell>{role.name}</TableCell>
                  <TableCell>
                    <Tooltip title="View Permissions">
                      <IconButton onClick={(event) => handleOpenPermissions(event, role.permissions)}>
                        <MoreVertIcon />
                      </IconButton>
                    </Tooltip>
                  </TableCell>
                  <TableCell>
                    <Button variant="outlined" color="primary" onClick={() => handleOpenEditModal(role)} sx={{ mr: 1 }}>
                      Edit
                    </Button>
                    <Button variant="outlined" color="error" onClick={() => handleOpenDeleteModal(role.name)}>
                      Delete
                    </Button>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </TableContainer>

        <Menu anchorEl={anchorEl} open={Boolean(anchorEl)} onClose={handleClosePermissions}>
          {selectedPermissions?.map((permission, index) => (
            <MenuItem key={index}>{permission}</MenuItem>
          ))}
        </Menu>

        <TablePagination
          component="div"
          count={filteredRoles.length}
          page={page}
          onPageChange={handleChangePage}
          rowsPerPage={rowsPerPage}
          onRowsPerPageChange={handleChangeRowsPerPage}
          sx={{ mt: 2 }}
        />

        <AddRoleModal open={openAddModal} handleClose={handleCloseAddModal} onRoleAdded={handleRoleAdded} />
        <EditRoleModal open={openEditModal} handleClose={handleCloseEditModal} onRoleUpdated={handleRoleUpdated} roleToEdit={roleToEdit || { id: 0, name: "", permissions: [] }} />
        <DeleteRoleModal open={openDeleteModal} handleClose={handleCloseDeleteModal} handleDelete={handleDeleteRole} roleName={roleToDelete} />

        <Snackbar open={openSnackbar} autoHideDuration={6000} onClose={() => setOpenSnackbar(false)}>
          <MuiAlert onClose={() => setOpenSnackbar(false)} severity="success" sx={{ width: "100%" }}>
            {snackbarMessage}
          </MuiAlert>
        </Snackbar>
      </Box>
    </Dashboard>
  );
};

// Style for Table headers
const tableHeaderStyle = {
  backgroundColor: "#2227436c", 
  color: "#fff",
  fontWeight: "bold",
};

export default UserRole;