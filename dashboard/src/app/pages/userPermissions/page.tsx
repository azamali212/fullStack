"use client"; // Ensures this file runs on the client side

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
  Snackbar,
  Alert as MuiAlert,
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
} from "@mui/material";
import SearchIcon from "@mui/icons-material/Search";
import { useDispatch, useSelector } from "react-redux";
import { AppDispatch, RootState } from "@/lib/store";
import {
  fetchPermissions,
  addPermissions,
  updatePermission,
  deletePermission,
} from "@/lib/slice/userPermissionSlice";
import EditPermissionModal from "./models/editPermissionModel";
import DeletePermissionModal from "./models/deletePermissionModel";
import Dashboard from "@/app/components/layout";
import AddPermissionModel from "./models/permissionModel";

const PermissionsTable = () => {
  const [searchQuery, setSearchQuery] = useState("");
  const [page, setPage] = useState(0);
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [openAddModal, setOpenAddModal] = useState(false);
  const [newPermissionName, setNewPermissionName] = useState("");
  const [openSnackbar, setOpenSnackbar] = useState(false);
  const [snackbarMessage, setSnackbarMessage] = useState("");
  const [openEditModal, setOpenEditModal] = useState(false);
  const [permissionToEdit, setPermissionToEdit] = useState<{
    id: string;
    name: string;
  } | null>(null);
  const [openDeleteModal, setOpenDeleteModal] = useState(false);
  const [permissionToDelete, setPermissionToDelete] = useState<string | null>(
    null
  );

  const dispatch = useDispatch<AppDispatch>();
  const { permissions, loading, error, successMessage } = useSelector(
    (state: RootState) => state.userPermission
  );

  useEffect(() => {
    dispatch(fetchPermissions());
  }, [dispatch]);

  const handleSearchChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setSearchQuery(event.target.value);
    setPage(0);
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

  const handleOpenAddModal = () => {
    setOpenAddModal(true);
  };

  const handleCloseAddModal = () => {
    setOpenAddModal(false);
  };

  const handlePermissionAdded = () => {
    setSnackbarMessage("Permission added successfully!");
    setOpenSnackbar(true);
    dispatch(fetchPermissions()); // Refresh the permissions list
  };

  const handleOpenEditModal = (permission: { id: string; name: string }) => {
    setPermissionToEdit(permission);
    setOpenEditModal(true);
  };

  const handleCloseEditModal = () => {
    setOpenEditModal(false);
    setPermissionToEdit(null);
  };

  const handleAddPermission = async () => {
    if (newPermissionName.trim()) {
      try {
        await dispatch(addPermissions({ name: [newPermissionName] })).unwrap();
        setSnackbarMessage("Permission added successfully!");
        dispatch(fetchPermissions()); // Refresh the permissions list
        handleCloseAddModal();
        setOpenSnackbar(true);
      } catch (err) {
        setSnackbarMessage(err || "Failed to add permission");
        setOpenSnackbar(true);
      }
    }
  };

  const filteredPermissions = permissions.filter((permission) =>
    permission.name.toLowerCase().includes(searchQuery.toLowerCase())
  );

  const paginatedPermissions = filteredPermissions.slice(
    page * rowsPerPage,
    page * rowsPerPage + rowsPerPage
  );

  const handleOpenDeleteModal = (permission: { id: string; name: string }) => {
    setPermissionToDelete(permission.id);  // Now we have access to permission.id
    setOpenDeleteModal(true);
  };

  const handleCloseDeleteModal = () => {
    setOpenDeleteModal(false);
    setPermissionToDelete(null);
  };

  const handleDeletePermission = async () => {
    if (permissionToDelete) {
      try {
        await dispatch(deletePermission(permissionToDelete)).unwrap(); // Use the ID
        setSnackbarMessage("Permission deleted successfully!");
        dispatch(fetchPermissions()); // Refresh the permissions list
        handleCloseDeleteModal(); // Close the modal after deletion
        setOpenSnackbar(true);
      } catch (err) {
        setSnackbarMessage(err || "Failed to delete permission");
        setOpenSnackbar(true);
      }
    }
  };

  return (
    <Dashboard
      userRole="System Administrator"
      userImage=""
      userName=""
      className=""
    >
      <Box sx={{ p: 3 }}>
        <Grid
          container
          spacing={2}
          justifyContent="space-between"
          alignItems="center"
          sx={{ mb: 3 }}
        >
          <Grid item xs={8}>
            <Typography variant="h6" gutterBottom>
              Permissions Management
            </Typography>
          </Grid>
          <Grid item xs={12} sm={6}>
            <TextField
              sx={{ width: "300px" }}
              variant="outlined"
              placeholder="Search permissions..."
              value={searchQuery}
              onChange={handleSearchChange}
              InputProps={{
                startAdornment: (
                  <SearchIcon sx={{ mr: 1, color: "grey.500" }} />
                ),
              }}
            />
          </Grid>
        </Grid>

        {error && (
          <Alert severity="error" sx={{ mb: 2 }}>
            {error}
          </Alert>
        )}

        <TableContainer component={Paper}>
          <Table aria-label="Permissions Table">
            <TableHead>
              <TableRow>
                <TableCell sx={tableHeaderStyle}>Permission ID</TableCell>
                <TableCell sx={tableHeaderStyle}>Permission Name</TableCell>
                <TableCell sx={tableHeaderStyle}>Group</TableCell>
                <TableCell sx={tableHeaderStyle}>Actions</TableCell>
                <TableCell sx={tableHeaderStyle}>
                <Button variant="contained" color="primary" onClick={handleOpenAddModal}>
          Add Permission
        </Button>
                </TableCell>
              </TableRow>
            </TableHead>
            <TableBody>
              {paginatedPermissions.map((permission) => (
                <TableRow key={permission.id}>
                  <TableCell>{permission.id}</TableCell>
                  <TableCell>{permission.name}</TableCell>
                  <TableCell>{permission.group}</TableCell>
                  <TableCell>
                    <Button
                      variant="outlined"
                      color="primary"
                      onClick={() => handleOpenEditModal(permission)}
                      sx={{ mr: 1 }}
                    >
                      Edit
                    </Button>
                    <Button
                      variant="outlined"
                      color="error"
                      onClick={() => handleOpenDeleteModal(permission)}
                    >
                      Delete
                    </Button>
                  </TableCell>
                </TableRow>
              ))}
            </TableBody>
          </Table>
        </TableContainer>

        <TablePagination
          component="div"
          count={filteredPermissions.length}
          page={page}
          onPageChange={handleChangePage}
          rowsPerPage={rowsPerPage}
          onRowsPerPageChange={handleChangeRowsPerPage}
          sx={{ mt: 2 }}
        />

        {/* Add New Permission Modal */}
        <Dialog open={openAddModal} onClose={handleCloseAddModal}>
          <DialogTitle>Add New Permission</DialogTitle>
          <DialogContent>
            <TextField
              fullWidth
              label="Permission Name"
              value={newPermissionName}
              onChange={(e) => setNewPermissionName(e.target.value)}
              variant="outlined"
            />
          </DialogContent>
          <DialogActions>
            <Button onClick={handleCloseAddModal} color="secondary">
              Cancel
            </Button>
            <Button onClick={handleAddPermission} color="primary">
              Add Permission
            </Button>
          </DialogActions>
        </Dialog>

        <AddPermissionModel
          open={openAddModal}
          handleClose={handleCloseAddModal}
          onPermissionAdded={handlePermissionAdded}
        />
        {/* Edit Permission Modal */}
        <EditPermissionModal
          open={openEditModal}
          handleClose={handleCloseEditModal}
          onPermissionUpdated={() => {
            setSnackbarMessage("Permission updated successfully!");
            setOpenSnackbar(true);
            dispatch(fetchPermissions());
          }}
          permissionToEdit={permissionToEdit!}
        />

        {/* Delete Permission Modal */}
        <DeletePermissionModal
          open={openDeleteModal}
          handleClose={handleCloseDeleteModal}
          handleDelete={handleDeletePermission}
          permissionName={
            permissions.find(
              (permission) => permission.id === permissionToDelete
            )?.name || ""
          }
        />
        <Snackbar
          open={openSnackbar}
          autoHideDuration={6000}
          onClose={() => setOpenSnackbar(false)}
        >
          <MuiAlert
            onClose={() => setOpenSnackbar(false)}
            severity={successMessage ? "success" : "error"}
            sx={{ width: "100%" }}
          >
            {snackbarMessage}
          </MuiAlert>
        </Snackbar>
      </Box>
    </Dashboard>
  );
};

const tableHeaderStyle = {
  backgroundColor: "#3f51b5",
  color: "#fff",
  fontWeight: "bold",
};

export default PermissionsTable;
