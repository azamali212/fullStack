"use client";
import React, { useState, useEffect } from "react";
import {
  Dialog,
  DialogActions,
  DialogContent,
  DialogTitle,
  Button,
  TextField,
} from "@mui/material";
import { useDispatch, useSelector } from "react-redux";
import { addPermissions } from "@/lib/slice/userPermissionSlice";
import { AppDispatch, RootState } from "@/lib/store";

interface AddPermissionModelProps {
  open: boolean;
  handleClose: () => void;
  onPermissionAdded: () => void;
}

const AddPermissionModel: React.FC<AddPermissionModelProps> = ({
  open,
  handleClose,
  onPermissionAdded,
}) => {
  const [permissionName, setPermissionName] = useState("");
  const [permissionGroup, setPermissionGroup] = useState("");

  const dispatch = useDispatch<AppDispatch>();
  const { loading, error, successMessage } = useSelector(
    (state: RootState) => state.userPermission
  );

  useEffect(() => {
    if (!open) {
      // Reset form when the modal is closed
      setPermissionName("");
      setPermissionGroup("");
    }
  }, [open]);

  const handleSubmit = () => {
    if (permissionName.trim() && permissionGroup.trim()) {
      dispatch(
        addPermissions({ name: [permissionName], group: permissionGroup })
      );
      onPermissionAdded(); // Notify parent about successful addition
      handleClose(); // Close the modal
    }
  };

  return (
    <Dialog open={open} onClose={handleClose} maxWidth="sm" fullWidth>
      <DialogTitle className="text-center text-xl font-semibold text-gray-700">
        Add Permissions
      </DialogTitle>
      <DialogContent className="space-y-4">
        {/* Permission Name Field */}
        <TextField
          fullWidth
          label="Permission Name"
          value={permissionName}
          onChange={(e) => setPermissionName(e.target.value)}
          variant="standard"
          className="transition-all duration-300 ease-in-out"
          sx={{
            "& .MuiOutlinedInput-root": {
              "&:hover fieldset": {
                borderColor: "#3f51b5", // Hover effect for input field
              },
            },
          }}
        />

        {/* Permission Group Field */}
        <TextField
          fullWidth
          label="Permission Group"
          value={permissionGroup}
          onChange={(e) => setPermissionGroup(e.target.value)}
          variant="standard"
          className="transition-all duration-300 ease-in-out"
          sx={{
            "& .MuiOutlinedInput-root": {
              "&:hover fieldset": {
                borderColor: "#3f51b5", // Hover effect for input field
              },
            },
          }}
        />
      </DialogContent>
      <DialogActions className="justify-between">
        <Button
          onClick={handleClose}
          color="secondary"
          className="transition-all duration-300 ease-in-out hover:bg-gray-200"
        >
          Cancel
        </Button>
        <Button onClick={handleSubmit} color="primary" disabled={loading}>
          Add Permission
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default AddPermissionModel;