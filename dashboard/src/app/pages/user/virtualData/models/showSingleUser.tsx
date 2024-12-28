import React from "react";
import {
  Dialog,
  DialogTitle,
  DialogContent,
  DialogActions,
  Typography,
  Button,
  Box,
  IconButton,
} from "@mui/material";
import CloseIcon from "@mui/icons-material/Close";

interface User {
  id: number;
  name: string;
  email: string;
  roles: { name: string }[];
  hospital?: { name: string };
  permissions?: { name: string }[];
}

interface ShowUserModelProps {
  open: boolean;
  user: User | null;
  handleClose: () => void;
}

function ShowUserModel({
    open,
    user,
    handleClose,
    handleEditClick, // Add a new prop for handling edit action
  }: ShowUserModelProps & { handleEditClick: () => void }) {
    if (!user) return null;

  return (
    <Dialog
      open={open}
      onClose={handleClose}
      maxWidth="sm"
      fullWidth
      aria-labelledby="user-details-dialog"
    >
      <DialogTitle>
        User Details
        <IconButton
          onClick={handleClose}
          sx={{ position: "absolute", right: 8, top: 8 }}
        >
          <CloseIcon />
        </IconButton>
      </DialogTitle>
      <DialogContent dividers>
        <Box>
          <Typography variant="subtitle1" gutterBottom>
            <strong>Name:</strong> {user.name}
          </Typography>
          <Typography variant="subtitle1" gutterBottom>
            <strong>Email:</strong> {user.email}
          </Typography>
          <Typography variant="subtitle1" gutterBottom>
            <strong>Roles:</strong>{" "}
            {user.roles && user.roles.length > 0
              ? user.roles.map((role, index) => (
                  <span key={index}>
                    {role.name}
                    {index < user.roles.length - 1 && ", "}
                  </span>
                ))
              : "No Roles Assigned"}
          </Typography>
          <Typography variant="subtitle1" gutterBottom>
            <strong>Hospital:</strong>{" "}
            {user.hospital ? user.hospital.name : "No Hospital"}
          </Typography>
          <Typography variant="subtitle1" gutterBottom>
            <strong>Permissions:</strong>{" "}
            {user.permissions && user.permissions.length > 0
              ? user.permissions.map((perm, index) => (
                  <span key={index}>
                    {perm.name}
                    {index < user.permissions.length - 1 && ", "}
                  </span>
                ))
              : "No Permissions"}
          </Typography>
        </Box>
      </DialogContent>
      <DialogActions>
      <Button onClick={handleEditClick} color="primary">
          Edit
        </Button>
        <Button onClick={handleClose} color="primary">
          Close
        </Button>
      </DialogActions>
    </Dialog>
  );
}

export default ShowUserModel;